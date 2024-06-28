<x-guest-layout>
    @section('title', 'Sudoku')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex justify-center items-center bg-gray-100">
        <div class="w-[830px] h-[750px] max-w-4xl p-8 bg-white shadow-lg rounded-lg flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Sudoku</h1>

            <div class="text-center mb-4">
                <p class="text-gray-600">Selecciona un tamaño:</p>
                <div class="flex justify-center mt-4 space-x-4">
                    <button class="btn-size" data-size="3">3x3</button>
                    <button class="btn-size" data-size="4">4x4</button>
                    <button class="btn-size" data-size="5">5x5</button>
                    <button class="btn-size" data-size="6">6x6</button>
                    <button class="btn-size" data-size="7">7x7</button>
                    <button class="btn-size" data-size="8">8x8</button>
                    <button class="btn-size" data-size="9">9x9</button>
                </div>
            </div>

            <div id="sudokuBoard" class="mt-8 grid place-content-center gap-1 text-center">
                <!-- Aquí se generará el tablero de Sudoku dinámicamente -->
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
        }

        .sudoku-cell:focus {
            border-color: #4a90e2;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sudokuBoard = document.getElementById('sudokuBoard');
            const message = document.getElementById('message');
            let boardSize = 9;
            let board = [];

            // Función para generar un tablero de Sudoku vacío
            function generateEmptyBoard(size) {
                let board = [];
                for (let i = 0; i < size; i++) {
                    board[i] = [];
                    for (let j = 0; j < size; j++) {
                        board[i][j] = 0; // Celda vacía representada como 0
                    }
                }
                return board;
            }

            // Función para renderizar el tablero de Sudoku en la vista
            function renderSudoku(board) {
                sudokuBoard.innerHTML = '';
                sudokuBoard.style.gridTemplateColumns = `repeat(${boardSize}, 1fr)`;
                sudokuBoard.style.width = `${parseInt(boardSize)*40}px`;
                
                const cellSize = 400 / boardSize;
                board.forEach((row, rowIndex) => {
                    row.forEach((value, colIndex) => {
                        const cell = document.createElement('input');
                        cell.type = 'text';
                        cell.classList.add('sudoku-cell');
                        cell.style.width = `${cellSize}px`;
                        cell.style.height = `${cellSize}px`;
                        cell.dataset.row = rowIndex;
                        cell.dataset.col = colIndex;
                        cell.value = value === 0 ? '' : value;
                        cell.addEventListener('input', handleCellInput);
                        sudokuBoard.appendChild(cell);
                    });
                });
            }

            // Función para manejar la entrada del usuario en las celdas del Sudoku
            function handleCellInput(event) {
                const row = parseInt(event.target.dataset.row);
                const col = parseInt(event.target.dataset.col);
                const value = parseInt(event.target.value) || 0;

                if (isValidMove(board, row, col, value)) {
                    board[row][col] = value;
                    event.target.value = value === 0 ? '' : value;
                    checkForWin();
                } else {
                    board[row][col] = 0;
                    event.target.value = '';
                    showMessage('¡Movimiento inválido! Inténtalo de nuevo.');
                }
            }

            // Función para verificar si un movimiento es válido
            function isValidMove(board, row, col, value) {
                // Verificar fila y columna
                for (let i = 0; i < boardSize; i++) {
                    if (board[row][i] === value || board[i][col] === value) {
                        return false;
                    }
                }

                // Verificar subcuadro
                const sqrtSize = Math.sqrt(boardSize);
                const startRow = Math.floor(row / sqrtSize) * sqrtSize;
                const startCol = Math.floor(col / sqrtSize) * sqrtSize;
                for (let i = startRow; i < startRow + sqrtSize; i++) {
                    for (let j = startCol; j < startCol + sqrtSize; j++) {
                        if (board[i][j] === value) {
                            return false;
                        }
                    }
                }

                return true;
            }

            // Función para verificar si se ha completado el Sudoku
            function checkForWin() {
                if (isBoardFull(board) && isBoardValid(board)) {
                    showMessage('¡Felicidades! Has completado el Sudoku correctamente.');
                }
            }

            // Función para verificar si el tablero está lleno
            function isBoardFull(board) {
                for (let i = 0; i < boardSize; i++) {
                    for (let j = 0; j < boardSize; j++) {
                        if (board[i][j] === 0) {
                            return false;
                        }
                    }
                }
                return true;
            }

            // Función para verificar si el tablero es válido
            function isBoardValid(board) {
                for (let i = 0; i < boardSize; i++) {
                    for (let j = 0; j < boardSize; j++) {
                        const value = board[i][j];
                        board[i][j] = 0;
                        if (!isValidMove(board, i, j, value)) {
                            board[i][j] = value;
                            return false;
                        }
                        board[i][j] = value;
                    }
                }
                return true;
            }

            // Función para mostrar mensajes en la interfaz
            function showMessage(msg) {
                message.textContent = msg;
            }

            // Event listeners para los botones de tamaño y controles del juego
            document.querySelectorAll('.btn-size').forEach(button => {
                button.addEventListener('click', function() {
                    boardSize = parseInt(this.dataset.size);
                    board = generateEmptyBoard(boardSize);
                    renderSudoku(board);
                    showMessage('');
                });
            });

            document.getElementById('checkBtn').addEventListener('click', function() {
                if (isBoardValid(board)) {
                    showMessage('¡El tablero es válido!');
                } else {
                    showMessage('¡El tablero no es válido!');
                }
            });

            document.getElementById('solveBtn').addEventListener('click', function() {
                solveSudoku(board);
                renderSudoku(board);
                showMessage('Tablero resuelto automáticamente.');
            });

            document.getElementById('clearBtn').addEventListener('click', function() {
                board = generateEmptyBoard(boardSize);
                renderSudoku(board);
                showMessage('Tablero limpiado.');
            });

            // Función para resolver el Sudoku automáticamente
            function solveSudoku(board) {
                if (solve(board)) {
                    return board;
                } else {
                    showMessage('No se puede resolver el Sudoku.');
                }
            }

            function solve(board) {
                for (let row = 0; row < boardSize; row++) {
                    for (let col = 0; col < boardSize; col++) {
                        if (board[row][col] === 0) {
                            for (let num = 1; num <= boardSize; num++) {
                                if (isValidMove(board, row, col, num)) {
                                    board[row][col] = num;
                                    if (solve(board)) {
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

            // Generar el tablero inicial (9x9)
            board = generateEmptyBoard(boardSize);
            renderSudoku(board);
        });
    </script>
</x-guest-layout>
