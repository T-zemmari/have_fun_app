<x-guest-layout>
    @section('title', 'Sudoku')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex justify-center items-center bg-gray-100">
        <div
            class="w-[830px] h-[750px] max-w-4xl p-8 bg-white shadow-lg rounded-lg flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Sudoku</h1>

            <div class="text-center mb-4">
                <p class="text-gray-600">Selecciona un tamaño:</p>
                <div class="flex justify-center mt-4 space-x-4">
                    <button class="btn-size" data-size="3">3x3</button>
                    <button class="btn-size" data-size="5">5x5</button>
                    <button class="btn-size" data-size="9">9x9</button>
                </div>
            </div>

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
        background-color: #d3d3d3;
        /* Gris claro para celdas fijas */
        color: black;
        /* Texto negro */
    }

    #sudokuBoard {
        border-collapse: collapse;
    }

    #sudokuBoard td {
        padding: 0;
    }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sudokuBoard = document.getElementById('sudokuBoard');
    const message = document.getElementById('message');
    const checkBtn = document.getElementById('checkBtn');
    const solveBtn = document.getElementById('solveBtn');
    const clearBtn = document.getElementById('clearBtn');

    document.querySelectorAll('.btn-size').forEach(button => {
        button.addEventListener('click', () => {
            const size = parseInt(button.getAttribute('data-size'));
            createSudokuBoard(size);
        });
    });

    checkBtn.addEventListener('click', checkSudoku);
    solveBtn.addEventListener('click', solveSudoku);
    clearBtn.addEventListener('click', clearSudoku);

    function createSudokuBoard(size) {
        sudokuBoard.innerHTML = '';

        // Ajusta el tamaño de las celdas según el tamaño del tablero
        let cellSize;
        if (size === 9) {
            cellSize = '50px';
        } else if (size === 5) {
            cellSize = '80px';
        } else if (size === 3) {
            cellSize = '120px';
        }

        for (let row = 0; row < size; row++) {
            const tr = document.createElement('tr');
            for (let col = 0; col < size; col++) {
                const td = document.createElement('td');
                const cell = document.createElement('input');
                cell.type = 'text';
                cell.maxLength = 1;
                cell.classList.add('sudoku-cell');
                cell.style.width = cellSize;
                cell.style.height = cellSize;
                td.appendChild(cell);
                tr.appendChild(td);
            }
            sudokuBoard.appendChild(tr);
        }
    }

    function checkSudoku() {
        message.textContent = 'Función de verificación no implementada.';
    }

    function solveSudoku() {
        message.textContent = 'Función de resolver no implementada.';
    }

    function clearSudoku() {
        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => cell.value = '');
        message.textContent = '';
    }
});

</script>
