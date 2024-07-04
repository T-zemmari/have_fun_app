<x-guest-layout>
    @section('title', 'Juego de Damas')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Juego de Damas</h1>
            <table id="checkersBoard" class="mx-auto mb-8"></table>
            <button id="resetGameBtn" class="btn-action">Resetear Juego</button>
        </div>
    </section>
</x-guest-layout>

<style>
    .btn-action {
        padding: 10px 20px;
        background-color: #6ab04c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        display: block;
        margin: 0 auto;
    }

    .btn-action:hover {
        background-color: #5d9e3f;
    }

    table {
        border-collapse: collapse;
        margin: 0 auto;
    }

    td {
        width: 50px;
        height: 50px;
        text-align: center;
        vertical-align: middle;
    }

    .black-cell {
        background-color: #2b6cb0;
    }

    .white-cell {
        background-color: #f0f0f0;
    }

    .checker {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .white-checker {
        background-color: white;
        border: 2px solid #000;
    }

    .black-checker {
        background-color: black;
    }

    .king {
        border: 2px solid gold;
    }

    .selected {
        outline: 3px solid yellow;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkersBoard = document.getElementById('checkersBoard');
        const resetGameBtn = document.getElementById('resetGameBtn');
        const boardSize = 8;
        const playerColor = 'white';
        const computerColor = 'black';

        let selectedChecker = null;
        let playerMoved = false;

        function generateBoard() {
            checkersBoard.innerHTML = '';
            for (let row = 0; row < boardSize; row++) {
                const tr = document.createElement('tr');
                for (let col = 0; col < boardSize; col++) {
                    const td = document.createElement('td');
                    if ((row + col) % 2 === 0) {
                        td.classList.add('white-cell');
                    } else {
                        td.classList.add('black-cell');
                        if (row < 3) {
                            const checker = document.createElement('div');
                            checker.classList.add('checker', 'black-checker');
                            checker.dataset.color = computerColor;
                            td.appendChild(checker);
                        } else if (row > 4) {
                            const checker = document.createElement('div');
                            checker.classList.add('checker', 'white-checker');
                            checker.dataset.color = playerColor;
                            td.appendChild(checker);
                        }
                    }
                    td.addEventListener('click', () => cellClicked(td, row, col));
                    td.dataset.row = row;
                    td.dataset.col = col;
                    tr.appendChild(td);
                }
                checkersBoard.appendChild(tr);
            }
        }

        function cellClicked(cell, row, col) {
            if (selectedChecker) {
                const startRow = parseInt(selectedChecker.parentElement.dataset.row);
                const startCol = parseInt(selectedChecker.parentElement.dataset.col);
                if (isValidMove(startRow, startCol, row, col, selectedChecker)) {
                    const captured = capturePieceIfNeeded(startRow, startCol, row, col);
                    moveChecker(selectedChecker, cell);
                    if (captured) {
                        checkWin(playerColor);
                    }
                    selectedChecker.classList.remove('selected');
                    selectedChecker = null;
                    playerMoved = true;

                    setTimeout(() => {
                        if (playerMoved) {
                            computerMove();
                            checkWin(computerColor);
                            playerMoved = false;
                        }
                    }, 500);
                } else {
                    selectedChecker.classList.remove('selected');
                    selectedChecker = null;
                }
            } else if (cell.firstChild && cell.firstChild.dataset.color === playerColor) {
                selectedChecker = cell.firstChild;
                selectedChecker.classList.add('selected');
            }
        }

        function isValidMove(startRow, startCol, endRow, endCol, checker) {
            const direction = checker.dataset.color === playerColor ? -1 : 1;
            const distance = Math.abs(startRow - endRow);

            const targetCell = document.querySelector(`td[data-row="${endRow}"][data-col="${endCol}"]`);
            if (targetCell && targetCell.firstChild) {
                return false;
            }

            if (distance === 1 && Math.abs(startCol - endCol) === 1) {
                return (endRow - startRow) === direction || checker.classList.contains('king');
            } else if (distance === 2 && Math.abs(startCol - endCol) === 2) {
                const middleRow = (startRow + endRow) / 2;
                const middleCol = (startCol + endCol) / 2;
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                if (middleCell && middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color) {
                    return true;
                }
            }
            return false;
        }

        function moveChecker(checker, destination) {
            destination.appendChild(checker);
            const row = parseInt(destination.dataset.row);
            if ((row === 0 && checker.dataset.color === playerColor) || (row === boardSize - 1 && checker.dataset.color === computerColor)) {
                checker.classList.add('king');
            }
        }

        function capturePieceIfNeeded(startRow, startCol, endRow, endCol) {
            const middleRow = (startRow + endRow) / 2;
            const middleCol = (startCol + endCol) / 2;
            const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
            if (Math.abs(startRow - endRow) === 2 && middleCell && middleCell.firstChild) {
                middleCell.removeChild(middleCell.firstChild);
                return true;
            }
            return false;
        }

        function computerMove() {
            const allCells = Array.from(document.querySelectorAll('.black-cell'));
            const computerCheckers = allCells.filter(cell => cell.firstChild && cell.firstChild.dataset.color === computerColor);

            const possibleMoves = [];
            computerCheckers.forEach(checkerCell => {
                const startRow = parseInt(checkerCell.dataset.row);
                const startCol = parseInt(checkerCell.dataset.col);
                const checker = checkerCell.firstChild;
                const moves = getPossibleMoves(startRow, startCol, checker);
                moves.forEach(move => possibleMoves.push({ startRow, startCol, move }));
            });

            if (possibleMoves.length > 0) {
                const randomMove = possibleMoves[Math.floor(Math.random() * possibleMoves.length)];
                const startCell = document.querySelector(`td[data-row="${randomMove.startRow}"][data-col="${randomMove.startCol}"]`);
                const targetCell = document.querySelector(`td[data-row="${randomMove.move.row}"][data-col="${randomMove.move.col}"]`);
                capturePieceIfNeeded(randomMove.startRow, randomMove.startCol, randomMove.move.row, randomMove.move.col);
                moveChecker(startCell.firstChild, targetCell);
            }
        }

        function getPossibleMoves(row, col, checker) {
            const direction = checker.dataset.color === playerColor ? -1 : 1;
            const possibleMoves = [];

            for (let dCol of [-1, 1]) {
                const newRow = row + direction;
                const newCol = col + dCol;
                const targetCell = document.querySelector(`td[data-row="${newRow}"][data-col="${newCol}"]`);
                if (targetCell && targetCell.childElementCount === 0) {
                    possibleMoves.push({ row: newRow, col: newCol });
                }
            }

            for (let dCol of [-2, 2]) {
                const newRow = row + direction * 2;
                const newCol = col + dCol;
                const middleRow = row + direction;
                const middleCol = col + dCol / 2;
                const targetCell = document.querySelector(`td[data-row="${newRow}"][data-col="${newCol}"]`);
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                if (targetCell && targetCell.childElementCount === 0 && middleCell && middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color) {
                    possibleMoves.push({ row: newRow, col: newCol });
                }
            }

            return possibleMoves;
        }

        function checkWin(color) {
            const allCells = Array.from(document.querySelectorAll('.black-cell'));
            const playerCheckers = allCells.filter(cell => cell.firstChild && cell.firstChild.dataset.color === playerColor);
            const computerCheckers = allCells.filter(cell => cell.firstChild && cell.firstChild.dataset.color === computerColor);

            if (color === playerColor && computerCheckers.length === 0) {
                Swal.fire({
                    html: `<h4>¡Felicidades! Has ganado el juego de damas.</h4>`,
                    icon: "success"
                });
                generateBoard();
                return true;
            } else if (color === computerColor && playerCheckers.length === 0) {
                Swal.fire({
                    html: `<h4>¡Lo siento! Has perdido el juego de damas.</h4>`,
                    icon: "error"
                });
                generateBoard();
                return true;
            }
            return false;
        }

        resetGameBtn.addEventListener('click', () => {
            selectedChecker = null;
            playerMoved = false;
            generateBoard();
        });

        generateBoard();
    });
</script>
