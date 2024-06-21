<x-guest-layout>
    @section('title', 'HAVE FUN - Juegos Ajedrez')
    @include('layouts.partials.navbar')

    <section class="w-full h-[91.1vh] flex justify-center md:p-12">
        <div class="w-full max-w-[60%] h-[100%] flex flex-row justify-center items-center mt-[1em] gap-2">
            <div class="w-[60%] h-[100%] flex flex-col justify-between items-center border border-[#dbdbdb] p-1">
                <div class="w-[300px] flex flex-col justify-start items-start p-1">
                    <div id="turn_indicator"
                        class="w-full h-16 rounded-lg bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white flex justify-center items-center">
                        <b class="text-[14px]">TURNO:
                            <span id="current_turn">Blancas</span></b>
                    </div>
                </div>
                <div class="w-full flex flex-row justify-center items-center gap-4">
                    <canvas id="canva_chess" width="480" height="480"></canvas>
                </div>
                <div
                    class="w-full h-[80px] rounded-lg mt-2 flex flex-row justify-center items-center gap-6 bg-gradient-to-r from-violet-500 to-fuchsia-500">
                    <button id="startButton" class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/play_3.png') }}')">
                    </button>
                    <button id="pauseButton" class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/pause_1.png') }}')">
                    </button>
                    <button id="resumeButton"
                        class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/resume_1.png') }}'); display:none">
                    </button>
                    <button id="stopButton" class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/stop_1.png') }}')">
                    </button>
                    <button id="restartButton"
                        class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/restart_1.png') }}'); display:none">
                    </button>
                </div>
            </div>
        </div>
    </section>

    <style>
        #canva_chess {
            background-color: #fff;
            border: 2px solid #000;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('canva_chess');
            const ctx = canvas.getContext('2d');
            const turnIndicator = document.getElementById('current_turn');
            const startButton = document.getElementById('startButton');
            const pauseButton = document.getElementById('pauseButton');
            const resumeButton = document.getElementById('resumeButton');
            const stopButton = document.getElementById('stopButton');
            const restartButton = document.getElementById('restartButton');

            let board, selectedPiece, currentTurn, isPaused;

            const colors = {
                white: '#fff',
                black: '#000',
                highlight: '#ff0',
                selected: '#0f0'
            };

            const pieces = {
                wP: '♙',
                wR: '♖',
                wN: '♘',
                wB: '♗',
                wQ: '♕',
                wK: '♔',
                bP: '♟',
                bR: '♜',
                bN: '♞',
                bB: '♝',
                bQ: '♛',
                bK: '♚'
            };

            const defaultBoard = [
                ['bR', 'bN', 'bB', 'bQ', 'bK', 'bB', 'bN', 'bR'],
                ['bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP'],
                [null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null],
                ['wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP'],
                ['wR', 'wN', 'wB', 'wQ', 'wK', 'wB', 'wN', 'wR']
            ];

            function drawBoard() {
                const size = canvas.width / 8;
                for (let row = 0; row < 8; row++) {
                    for (let col = 0; col < 8; col++) {
                        ctx.fillStyle = (row + col) % 2 === 0 ? colors.white : colors.black;
                        ctx.fillRect(col * size, row * size, size, size);
                    }
                }
            }

            function drawPieces() {
                const size = canvas.width / 8;
                board.forEach((row, rowIndex) => {
                    row.forEach((piece, colIndex) => {
                        if (piece) {
                            ctx.fillStyle = piece[0] === 'w' ? colors.white : colors.black;
                            ctx.font = `${size - 10}px Arial`;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(pieces[piece], colIndex * size + size / 2, rowIndex *
                                size + size / 2);
                        }
                    });
                });
            }

            function initializeBoard() {
                board = JSON.parse(JSON.stringify(defaultBoard));
                currentTurn = 'Blancas';
                turnIndicator.textContent = currentTurn;
                selectedPiece = null;
                isPaused = false;
            }

            function switchTurn() {
                currentTurn = currentTurn === 'Blancas' ? 'Negras' : 'Blancas';
                turnIndicator.textContent = currentTurn;
            }

            function startGame() {
                initializeBoard();
                drawBoard();
                drawPieces();
            }

            function pauseGame() {
                isPaused = true;
                pauseButton.style.display = 'none';
                resumeButton.style.display = 'block';
            }

            function resumeGame() {
                isPaused = false;
                pauseButton.style.display = 'block';
                resumeButton.style.display = 'none';
            }

            function stopGame() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawBoard();
            }

            function restartGame() {
                stopGame();
                startGame();
            }

            function getMousePosition(event) {
                const rect = canvas.getBoundingClientRect();
                return {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
            }

            function getBoardPosition(mousePos) {
                const size = canvas.width / 8;
                return {
                    col: Math.floor(mousePos.x / size),
                    row: Math.floor(mousePos.y / size)
                };
            }

            function isValidMove(piece, start, end) {
                // Implement the logic to check if a move is valid according to chess rules
                // This is a simplified version and should be replaced with full chess rules
                return true;
            }

            function handlePieceClick(event) {
                if (isPaused) return;
                const mousePos = getMousePosition(event);
                const boardPos = getBoardPosition(mousePos);

                if (selectedPiece) {
                    const [startRow, startCol] = selectedPiece.position;
                    const [endRow, endCol] = [boardPos.row, boardPos.col];

                    if (isValidMove(selectedPiece.piece, {
                            row: startRow,
                            col: startCol
                        }, {
                            row: endRow,
                            col: endCol
                        })) {
                        board[endRow][endCol] = selectedPiece.piece;
                        board[startRow][startCol] = null;
                        switchTurn();
                    }
                    selectedPiece = null;
                } else {
                    const piece = board[boardPos.row][boardPos.col];
                    if (piece && ((currentTurn === 'Blancas' && piece[0] === 'w') || (currentTurn === 'Negras' &&
                            piece[0] === 'b'))) {
                        selectedPiece = {
                            piece,
                            position: [boardPos.row, boardPos.col]
                        };
                    }
                }
                drawBoard();
                drawPieces();
            }

            canvas.addEventListener('click', handlePieceClick);
            startButton.addEventListener('click', startGame);
            pauseButton.addEventListener('click', pauseGame);
            resumeButton.addEventListener('click', resumeGame);
            stopButton.addEventListener('click', stopGame);
            restartButton.addEventListener('click', restartGame);

            drawBoard();
        });
    </script>
</x-guest-layout>
