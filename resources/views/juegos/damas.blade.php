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
                    if (canCaptureAgain(selectedChecker, row, col)) {
                        selectedChecker.classList.add('selected');
                        return; // Permitir captura múltiple
                    }
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

        if (checker.classList.contains('king')) {
            if (distance === Math.abs(startCol - endCol)) {
                return isPathClear(startRow, startCol, endRow, endCol);
            }
        } else {
            if (distance === 1 && Math.abs(startCol - endCol) === 1) {
                return (endRow - startRow) === direction;
            } else if (distance === 2 && Math.abs(startCol - endCol) === 2) {
                const middleRow = (startRow + endRow) / 2;
                const middleCol = (startCol + endCol) / 2;
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                if (middleCell && middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color) {
                    return true;
                }
            }
        }
        return false;
    }

    function isPathClear(startRow, startCol, endRow, endCol) {
        const rowStep = startRow < endRow ? 1 : -1;
        const colStep = startCol < endCol ? 1 : -1;
        let pathClear = true;
        for (let row = startRow + rowStep, col = startCol + colStep; row !== endRow && col !== endCol; row += rowStep, col += colStep) {
            const cell = document.querySelector(`td[data-row="${row}"][data-col="${col}"]`);
            if (cell.firstChild) {
                pathClear = false;
                break;
            }
        }
        return pathClear;
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
        if (Math.abs(startRow - endRow) > 1 && middleCell && middleCell.firstChild) {
            middleCell.removeChild(middleCell.firstChild);
            return true;
        }
        return false;
    }

    function canCaptureAgain(checker, row, col) {
        const directions = [
            { rowDir: -2, colDir: -2 },
            { rowDir: -2, colDir: 2 },
            { rowDir: 2, colDir: -2 },
            { rowDir: 2, colDir: 2 }
        ];

        return directions.some(({ rowDir, colDir }) => {
            const newRow = row + rowDir;
            const newCol = col + colDir;
            if (newRow >= 0 && newRow < boardSize && newCol >= 0 && newCol < boardSize) {
                const middleRow = row + rowDir / 2;
                const middleCol = col + colDir / 2;
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                const targetCell = document.querySelector(`td[data-row="${newRow}"][data-col="${newCol}"]`);
                return middleCell && middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color && targetCell && !targetCell.firstChild;
            }
            return false;
        });
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

        // Filtrar las jugadas de captura
        const captureMoves = possibleMoves.filter(move => move.move.capture);
        const movesToConsider = captureMoves.length > 0 ? captureMoves : possibleMoves;

        if (movesToConsider.length > 0) {
            const randomMove = movesToConsider[Math.floor(Math.random() * movesToConsider.length)];
            const startCell = document.querySelector(`td[data-row="${randomMove.startRow}"][data-col="${randomMove.startCol}"]`);
            const targetCell = document.querySelector(`td[data-row="${randomMove.move.row}"][data-col="${randomMove.move.col}"]`);
            const capturedPiece = capturePieceIfNeeded(randomMove.startRow, randomMove.startCol, randomMove.move.row, randomMove.move.col);
            moveChecker(startCell.firstChild, targetCell);

            // Movimiento de captura adicional si es posible
            const newMoves = getPossibleMoves(randomMove.move.row, randomMove.move.col, targetCell.firstChild);
            if (capturedPiece && newMoves.length > 0) {
                const nextMove = newMoves[Math.floor(Math.random() * newMoves.length)];
                const nextTargetCell = document.querySelector(`td[data-row="${nextMove.row}"][data-col="${nextMove.col}"]`);
                capturePieceIfNeeded(randomMove.move.row, randomMove.move.col, nextMove.row, nextMove.col);
                moveChecker(targetCell.firstChild, nextTargetCell);
            }
        }
    }

    function getPossibleMoves(row, col, checker) {
        const directions = checker.classList.contains('king')
            ? [
                { rowDir: -1, colDir: -1 },
                { rowDir: -1, colDir: 1 },
                { rowDir: 1, colDir: -1 },
                { rowDir: 1, colDir: 1 }
            ]
            : checker.dataset.color === playerColor
                ? [
                    { rowDir: -1, colDir: -1 },
                    { rowDir: -1, colDir: 1 }
                ]
                : [
                    { rowDir: 1, colDir: -1 },
                    { rowDir: 1, colDir: 1 }
                ];

        const possibleMoves = [];
        for (const { rowDir, colDir } of directions) {
            let newRow = row + rowDir;
            let newCol = col + colDir;

            while (newRow >= 0 && newRow < boardSize && newCol >= 0 && newCol < boardSize) {
                const targetCell = document.querySelector(`td[data-row="${newRow}"][data-col="${newCol}"]`);
                if (targetCell && !targetCell.firstChild) {
                    possibleMoves.push({ row: newRow, col: newCol, capture: false });
                    if (!checker.classList.contains('king')) break; // Los peones solo se mueven un paso
                } else if (targetCell && targetCell.firstChild && targetCell.firstChild.dataset.color !== checker.dataset.color) {
                    const captureRow = newRow + rowDir;
                    const captureCol = newCol + colDir;
                    const captureCell = document.querySelector(`td[data-row="${captureRow}"][data-col="${captureCol}"]`);
                    if (captureCell && !captureCell.firstChild) {
                        possibleMoves.push({ row: captureRow, col: captureCol, capture: true });
                        break;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
                newRow += rowDir;
                newCol += colDir;
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
