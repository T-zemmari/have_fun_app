<x-guest-layout>
    @section('title', 'Sudoku')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex justify-center items-center bg-gray-100">
        <div
            class="w-[830px] max-h-[780px] max-w-4xl p-8 bg-white shadow-lg rounded-lg flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Sudoku</h1>
            <a href="{{ route('sudoku_one') }}" id="resetBtn" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Resetear</a>
            <div id="sudokuBoardContainer" class="mt-8 flex justify-center text-center">
                <table id="sudokuBoard">
                    <!-- Aquí se generará el tablero de Sudoku dinámicamente -->
                </table>
            </div>

            <div id="gameControls" class="mt-8 text-center">
                <button id="checkBtn" class="btn-action">Verificar</button>
                <button id="solveBtn" class="btn-action">Resolver</button>
                <button id="clearBtn" class="btn-action">Limpiar</button>
            </div>

            <div id="message" class="mt-4 text-center text-gray-700 font-medium">
                <!-- Aquí se mostrarán mensajes de alerta -->
            </div>
        </div>
    </section>
</x-guest-layout>

<style>
    .btn-size {
        padding: 10px 20px;
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-size:hover {
        background-color: #357bd8;
    }

    .btn-action {
        padding: 10px 20px;
        background-color: #6ab04c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-right: 10px;
    }

    .btn-action:hover {
        background-color: #5d9e3f;
    }

    .sudoku-cell {
        font-size: 1.2rem;
        text-align: center;
        border: 1px solid #ccc;
        outline: none;
        background-color: white;
        transition: background-color 0.3s ease;
        width: 50px;
        /* Ancho fijo para las celdas */
        height: 50px;
        /* Alto fijo para las celdas */
    }

    .sudoku-cell:focus {
        border-color: #4a90e2;
    }

    .fixed-cell {
        background-color: #8B4513;
        /* Marrón */
        color: white;
        /* Texto blanco */
        font-weight: bold;
    }

    .check-cell {
        background-color: #28a745;
        /* Verde */
        color: white;
        /* Texto blanco */
        font-weight: bold;
    }

    #sudokuBoard {
        border-collapse: collapse;
    }

    #sudokuBoard td {
        padding: 0;
        position: relative;
    }

    #sudokuBoard td::after {
        content: '\u2714';
        /* Símbolo de check */
        color: green;
        font-size: 1.5rem;
        position: absolute;
        display: none;
    }

    .check-row td:last-child::after {
        display: block;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
    }

    .check-column td:first-child::after {
        display: block;
        left: 5px;
        top: -1.5rem;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sudokuBoard = document.getElementById('sudokuBoard');
        const message = document.getElementById('message');
        const checkBtn = document.getElementById('checkBtn');
        const solveBtn = document.getElementById('solveBtn');
        const clearBtn = document.getElementById('clearBtn');

        // Crear un tablero 9x9 al cargar la página
        createSudokuBoard(9);

        checkBtn.addEventListener('click', checkSudoku);
        solveBtn.addEventListener('click', solveSudoku);
        clearBtn.addEventListener('click', clearSudoku);

        function createSudokuBoard(size) {
            sudokuBoard.innerHTML = '';

            // Ajusta el tamaño de las celdas según el tamaño del tablero
            const cellSize = '50px';

            // Genera un tablero válido de Sudoku
            const board = generateSudoku(size);
            const fixedCells = generateFixedCells(size);

            for (let row = 0; row < size; row++) {
                const tr = document.createElement('tr');
                for (let col = 0; col < size; col++) {
                    const td = document.createElement('td');
                    const cell = document.createElement('input');
                    cell.type = 'number';
                    cell.maxLength = 1;
                    cell.classList.add('sudoku-cell');
                    cell.style.width = cellSize;
                    cell.style.height = cellSize;

                    if (fixedCells.includes(`${row},${col}`)) {
                        cell.value = board[row][col];
                        cell.readOnly = true;
                        cell.classList.add('fixed-cell');
                    }

                    td.appendChild(cell);
                    tr.appendChild(td);
                }
                sudokuBoard.appendChild(tr);
            }
        }

        function generateSudoku(size) {
            const board = Array.from({
                length: size
            }, () => Array(size).fill(0));
            if (!solveSudokuBoard(board, size)) {
                console.error("No se pudo generar un tablero válido de Sudoku.");
            }
            return board;
        }

        function solveSudokuBoard(board, size) {
            for (let row = 0; row < size; row++) {
                for (let col = 0; col < size; col++) {
                    if (board[row][col] === 0) {
                        for (let num = 1; num <= size; num++) {
                            if (isValid(board, row, col, num, size)) {
                                board[row][col] = num;
                                if (solveSudokuBoard(board, size)) {
                                    return true;
                                }
                                board[row][col] = 0;
                            }
                        }
                        return false;
                    }
                }
            }
            return true;
        }

        function isValid(board, row, col, num, size) {
            const boxSize = Math.sqrt(size);

            for (let x = 0; x < size; x++) {
                if (board[row][x] === num || board[x][col] === num) {
                    return false;
                }
            }

            const startRow = row - row % boxSize;
            const startCol = col - col % boxSize;

            for (let i = 0; i < boxSize; i++) {
                for (let j = 0; j < boxSize; j++) {
                    if (board[i + startRow][j + startCol] === num) {
                        return false;
                    }
                }
            }

            return true;
        }

        function generateFixedCells(size) {
            const fixedCells = new Set();
            const totalCells = size * size;
            const fixedCount = Math.floor(totalCells * 0.25);

            while (fixedCells.size < fixedCount) {
                const row = Math.floor(Math.random() * size);
                const col = Math.floor(Math.random() * size);
                fixedCells.add(`${row},${col}`);
            }

            return Array.from(fixedCells);
        }

        function checkSudoku() {
            textContent = '';

            const size = 9;
            let isRowCorrect = true;
            let isColumnCorrect = true;

            // Verifica filas
            for (let row = 0; row < size; row++) {
                const rowCells = [];
                const rowSet = new Set();
                for (let col = 0; col < size; col++) {
                    const cell = sudokuBoard.rows[row].cells[col].querySelector('input');
                    rowCells.push(cell);
                    if (cell.value) {
                        rowSet.add(cell.value);
                    }
                }
                if (rowSet.size === size) {
                    rowCells.forEach(cell => cell.parentElement.classList.add('check-row'));
                } else {
                    isRowCorrect = false;
                }
            }

            // Verifica columnas
            for (let col = 0; col < size; col++) {
                const colCells = [];
                const colSet = new Set();
                for (let row = 0; row < size; row++) {
                    const cell = sudokuBoard.rows[row].cells[col].querySelector('input');
                    colCells.push(cell);
                    if (cell.value) {
                        colSet.add(cell.value);
                    }
                }
                if (colSet.size === size) {
                    colCells.forEach(cell => cell.parentElement.classList.add('check-column'));
                } else {
                    isColumnCorrect = false;
                }
            }

            // Mostrar mensaje de verificación
            if (isRowCorrect && isColumnCorrect) {
                textContent = '¡Has ganado! Sudoku completado correctamente.';
                Swal.fire({
                    html: `<h4>${textContent}</h4>`,
                    icon: "success"
                });
            } else {
                textContent = 'Aún hay errores en el Sudoku. <br>Revisa las filas y columnas marcadas.';
                Swal.fire({
                    html: `<h4>${textContent}</h4>`,
                    icon: "error"
                });
            }
        }

        function solveSudoku() {
            const size = 9;
            const board = [];

            // Recoger los valores actuales del tablero
            for (let row = 0; row < size; row++) {
                board.push([]);
                for (let col = 0; col < size; col++) {
                    const cell = sudokuBoard.rows[row].cells[col].querySelector('input');
                    if (cell.value !== '') {
                        board[row][col] = parseInt(cell.value);
                    } else {
                        board[row][col] = 0;
                    }
                }
            }

            // Resolver el Sudoku
            if (solveSudokuBoard(board, size)) {
                // Mostrar el tablero resuelto en el DOM
                for (let row = 0; row < size; row++) {
                    for (let col = 0; col < size; col++) {
                        const cell = sudokuBoard.rows[row].cells[col].querySelector('input');
                        cell.value = board[row][col];
                    }
                }
                textContent = 'Sudoku resuelto correctamente.';
                Swal.fire({
                    html: `<h4>${textContent}</h4>`,
                    icon: "success"
                });
                clearCheckMarks();
            } else {
                textContent = 'No se pudo resolver el Sudoku.';
                Swal.fire({
                    html: `<h4>${textContent}</h4>`,
                    icon: "error"
                });
            }
        }

        function clearSudoku() {
            const cells = document.querySelectorAll('.sudoku-cell:not(.fixed-cell)');
            cells.forEach(cell => cell.value = '');
            textContent = '';
            clearCheckMarks();
        }

        function clearCheckMarks() {
            const rows = document.querySelectorAll('.check-row');
            rows.forEach(row => row.classList.remove('check-row'));

            const columns = document.querySelectorAll('.check-column');
            columns.forEach(col => col.classList.remove('check-column'));
        }
    });
</script>
