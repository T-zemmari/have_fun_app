<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkersBoard = document.getElementById('checkersBoard');
        const resetGameBtn = document.getElementById('resetGameBtn');
        const boardSize = 8;
        const playerColor = 'white';
        const computerColor = 'black';

        let selectedChecker = null;
        let playerMoved = false; // Indicador para asegurar que el ordenador no mueva hasta que el jugador haya movido

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
                    playerMoved = true; // El jugador ha movido
                    if (checkWin(playerColor)) {
                        Swal.fire({
                            html: `<h4>¡Felicidades! Has ganado el juego de damas.</h4>`,
                            icon: "success"
                        });
                        generateBoard();
                    } else {
                        setTimeout(() => {
                            if (playerMoved) {
                                computerMove();
                                if (checkWin(computerColor)) {
                                    Swal.fire({
                                        html: `<h4>¡Lo siento! Has perdido el juego de damas.</h4>`,
                                        icon: "error"
                                    });
                                    generateBoard();
                                }
                                playerMoved = false; // Resetear el indicador después del movimiento del ordenador
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

            const targetCell = document.querySelector(`td[data-row="${endRow}"][data-col="${endCol}"]`);
            if (targetCell && targetCell.firstChild && targetCell.firstChild.dataset.color === checker.dataset.color) {
                return false; // No se puede mover a una celda con una pieza del mismo color
            }

            if (distance === 1 && Math.abs(startCol - endCol) === 1) {
                return (endRow - startRow) === direction || checker.classList.contains('king');
            } else if (distance === 2 && Math.abs(startCol - endCol) === 2) {
                const middleRow = (startRow + endRow) / 2;
                const middleCol = (startCol + endCol) / 2;
                const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
                if (middleCell && middleCell.firstChild && middleCell.firstChild.dataset.color !== checker.dataset.color) {
                    return true; // Movimiento de captura válido
                }
            }
            return false;
        }

        function moveChecker(checker, destination) {
            if (destination.childElementCount === 0) {
                destination.appendChild(checker);
                const row = parseInt(destination.dataset.row);
                if ((row === 0 && checker.dataset.color === playerColor) || (row === boardSize - 1 && checker.dataset.color === computerColor)) {
                    checker.classList.add('king');
                }
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
                const capturedPiece = capturePieceIfNeeded(randomMove.startRow, randomMove.startCol, randomMove.move.row, randomMove.move.col);
                moveChecker(startCell.firstChild, targetCell);
            }
        }

        function capturePieceIfNeeded(startRow, startCol, endRow, endCol) {
            const middleRow = (startRow + endRow) / 2;
            const middleCol = (startCol + endCol) / 2;
            const middleCell = document.querySelector(`td[data-row="${middleRow}"][data-col="${middleCol}"]`);
            if (Math.abs(startRow - endRow) === 2 && middleCell && middleCell.firstChild) {
                middleCell.removeChild(middleCell.firstChild);
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

        resetGameBtn.addEventListener('click', () => {
            selectedChecker = null;
            playerMoved = false; // Resetear el indicador al reiniciar el juego
            generateBoard();
        });

        generateBoard();
    });
</script>
