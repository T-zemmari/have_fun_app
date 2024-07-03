<x-guest-layout>
    @section('title', 'Juegos')
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

    #memoryGame {
        display: grid;
        grid-template-columns: repeat(4, 100px);
        gap: 10px;
    }

    .memory-card {
        width: 100px;
        height: 100px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: transparent;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .memory-card.flipped {
        background-color: #6ab04c;
        color: white;
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
                    moveChecker(selectedChecker, cell);
                    selectedChecker.classList.remove('selected');
                    selectedChecker = null;
                    if (checkWin(playerColor)) {
                        alert('¡Felicidades! Has ganado el juego.');
                        generateBoard();
                    } else {
                        setTimeout(() => {
                            computerMove();
                            if (checkWin(computerColor)) {
                                alert('¡Lo siento! Has perdido el juego.');
                                generateBoard();
                            }
                        }, 500);
                    }
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

            if (distance === 1 && Math.abs(startCol - endCol) === 1) {
                return (endRow - startRow) === direction || checker.classList.contains('king');
            } else if (distance === 2 && Math.abs(startCol - endCol) === 2) {
                const middleRow = (startRow + endRow) / 2;
                const middleCol = (startCol + endCol) / 2;
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                if (middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color) {
                    middleCell.removeChild(middleCell.firstChild);
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
                moveChecker(startCell.firstChild, targetCell);
            }
        }

        function getPossibleMoves(row, col, checker) {
            const direction = checker.dataset.color === playerColor ? -1 : 1;
            const possibleMoves = [];

            // Simple moves
            for (let dCol of [-1, 1]) {
                const newRow = row + direction;
                const newCol = col + dCol;
                const targetCell = document.querySelector(`td[data-row="${newRow}"][data-col="${newCol}"]`);
                if (targetCell && targetCell.childElementCount === 0) {
                    possibleMoves.push({ row: newRow, col: newCol });
                }
            }

            // Capturing moves
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
                return true;
            } else if (color === computerColor && playerCheckers.length === 0) {
                return true;
            }
            return false;
        }

        resetGameBtn.addEventListener('click', generateBoard);

        generateBoard();
        
        // Juego de memoria
        const memoryGame = document.getElementById('memoryGame');
        const resetMemoryGameBtn = document.getElementById('resetMemoryGameBtn');
        const cardValues = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        let flippedCards = [];

        function generateMemoryGame() {
            const doubledValues = [...cardValues, ...cardValues];
            const shuffledValues = doubledValues.sort(() => 0.5 - Math.random());
            memoryGame.innerHTML = '';
            shuffledValues.forEach(value => {
                const card = document.createElement('div');
                card.classList.add('memory-card');
                card.dataset.value = value;
                card.addEventListener('click', () => cardClicked(card));
                memoryGame.appendChild(card);
            });
        }

        function cardClicked(card) {
            if (flippedCards.length < 2 && !card.classList.contains('flipped')) {
                card.classList.add('flipped');
                card.textContent = card.dataset.value;
                flippedCards.push(card);
                if (flippedCards.length === 2) {
                    setTimeout(checkMatch, 1000);
                }
            }
        }

        function checkMatch() {
            const [card1, card2] = flippedCards;
            if (card1.dataset.value === card2.dataset.value) {
                card1.style.visibility = 'hidden';
                card2.style.visibility = 'hidden';
            } else {
                card1.classList.remove('flipped');
                card2.classList.remove('flipped');
                card1.textContent = '';
                card2.textContent = '';
            }
            flippedCards = [];
        }

        resetMemoryGameBtn.addEventListener('click', generateMemoryGame);

        generateMemoryGame();
    });
</script>
