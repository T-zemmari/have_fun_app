<x-guest-layout>
    @section('title', 'HAVE FUN - Juegos Ajedrez')
    @include('layouts.partials.navbar')
    <section class="w-full h-screen flex flex-col items-center justify-center">
        <div class="w-full max-w-4xl p-4 flex flex-col justify-center items-center gap-4">
            <span id="current_turn" class="flex space-x-4 w-full h-[80px] rounded-lg mt-2 flex-row justify-center items-center gap-6 bg-gradient-to-r from-violet-500 to-fuchsia-500"><b>Blancas</b></span>
            <canvas id="canva_chess" width="400" height="400"></canvas>
            <div class="w-full mt-4 flex justify-between items-center">
                <div class="flex space-x-4 w-full h-[80px] rounded-lg mt-2  flex-row justify-center items-center gap-6 bg-gradient-to-r from-violet-500 to-fuchsia-500 ">
                    <button id="playButton" class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/play_1.png') }}')" aria-label="Play">
                    </button>
                    <button id="stopButton" class="w-[3em] h-[3em] flex justify-center items-center bg-center bg-cover"
                        style="background-image: url('{{ asset('assets/icons/stop_1.png') }}')" aria-label="Stop">
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
            class ChessGame {
                constructor() {
                    this.canvas = document.getElementById('canva_chess');
                    this.ctx = this.canvas.getContext('2d');
                    this.turnIndicator = document.getElementById('current_turn');
                    this.playButton = document.getElementById('playButton');
                    this.stopButton = document.getElementById('stopButton');

                    this.colors = {
                        white: '#fff',
                        black: '#000',
                        brown: '#8B4513',
                        highlight: '#ff0',
                        selected: '#0f0'
                    };

                    this.pieces = {
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

                    this.defaultBoard = [
                        ['bR', 'bN', 'bB', 'bQ', 'bK', 'bB', 'bN', 'bR'],
                        ['bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP'],
                        [null, null, null, null, null, null, null, null],
                        [null, null, null, null, null, null, null, null],
                        [null, null, null, null, null, null, null, null],
                        [null, null, null, null, null, null, null, null],
                        ['wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP'],
                        ['wR', 'wN', 'wB', 'wQ', 'wK', 'wB', 'wN', 'wR']
                    ];

                    this.initializeGame();
                }

                initializeGame() {
                    this.board = JSON.parse(JSON.stringify(this.defaultBoard));
                    this.currentTurn = 'Blancas';
                    this.turnIndicator.textContent = this.currentTurn;
                    this.selectedPiece = null;
                    this.isPaused = false;
                    this.draggingPiece = null;

                    this.playButton.addEventListener('click', () => this.startGame());
                    this.stopButton.addEventListener('click', () => this.stopGame());

                    this.canvas.addEventListener('mousedown', (event) => this.handlePieceDragStart(event));
                    this.canvas.addEventListener('mousemove', (event) => this.handlePieceDrag(event));
                    this.canvas.addEventListener('mouseup', (event) => this.handlePieceDrop(event));

                    this.drawBoard();
                }

                drawBoard() {
                    const size = this.canvas.width / 8;
                    for (let row = 0; row < 8; row++) {
                        for (let col = 0; col < 8; col++) {
                            this.ctx.fillStyle = (row + col) % 2 === 0 ? this.colors.white : this.colors.brown;
                            this.ctx.fillRect(col * size, row * size, size, size);
                        }
                    }
                    this.drawPieces();
                }

                drawPieces() {
                    const size = this.canvas.width / 8;
                    this.board.forEach((row, rowIndex) => {
                        row.forEach((piece, colIndex) => {
                            if (piece) {
                                this.ctx.fillStyle = piece[0] === 'w' ? this.colors.black : this.colors.white;
                                this.ctx.font = `${size - 10}px Arial`;
                                this.ctx.textAlign = 'center';
                                this.ctx.textBaseline = 'middle';
                                this.ctx.fillText(this.pieces[piece], colIndex * size + size / 2, rowIndex * size + size / 2);
                            }
                        });
                    });
                }

                startGame() {
                    this.initializeGame();
                }

                stopGame() {
                    this.isPaused = true;
                    this.board = JSON.parse(JSON.stringify(this.defaultBoard));
                    this.drawBoard();
                }

                handlePieceDragStart(event) {
                    if (this.isPaused) return;

                    const { row, col } = this.getMousePosition(event);
                    const piece = this.board[row][col];

                    if (piece && piece[0] === (this.currentTurn === 'Blancas' ? 'w' : 'b')) {
                        this.draggingPiece = { piece, row, col };
                    }
                }

                handlePieceDrag(event) {
                    if (this.isPaused || !this.draggingPiece) return;

                    const { offsetX, offsetY } = event;
                    const size = this.canvas.width / 8;

                    this.drawBoard();
                    this.ctx.fillStyle = this.draggingPiece.piece[0] === 'w' ? this.colors.black : this.colors.white;
                    this.ctx.font = `${size - 10}px Arial`;
                    this.ctx.textAlign = 'center';
                    this.ctx.textBaseline = 'middle';
                    this.ctx.fillText(this.pieces[this.draggingPiece.piece], offsetX, offsetY);
                }

                handlePieceDrop(event) {
                    if (this.isPaused || !this.draggingPiece) return;

                    const { row, col } = this.getMousePosition(event);
                    const start = { row: this.draggingPiece.row, col: this.draggingPiece.col };
                    const end = { row, col };

                    if (isValidMove(this.draggingPiece.piece, start, end, this.board)) {
                        this.board[end.row][end.col] = this.draggingPiece.piece;
                        this.board[start.row][start.col] = null;

                        this.draggingPiece = null;
                        this.drawBoard();
                        this.drawPieces();

                        this.switchTurn();
                    } else {
                        this.draggingPiece = null;
                        this.drawBoard();
                        this.drawPieces();
                    }
                }

                getMousePosition(event) {
                    const rect = this.canvas.getBoundingClientRect();
                    const scaleX = this.canvas.width / rect.width;
                    const scaleY = this.canvas.height / rect.height;

                    const x = (event.clientX - rect.left) * scaleX;
                    const y = (event.clientY - rect.top) * scaleY;

                    const size = this.canvas.width / 8;
                    return {
                        row: Math.floor(y / size),
                        col: Math.floor(x / size)
                    };
                }

                switchTurn() {
                    this.currentTurn = this.currentTurn === 'Blancas' ? 'Negras' : 'Blancas';
                    this.turnIndicator.textContent = this.currentTurn;

                    if (this.currentTurn === 'Negras') {
                        setTimeout(() => this.computerMove(), 500); // Allow some time for the player's move to be seen
                    }
                }

                computerMove() {
                    const possibleMoves = [];

                    this.board.forEach((row, rowIndex) => {
                        row.forEach((piece, colIndex) => {
                            if (piece && piece[0] === 'b') { // AI is black
                                for (let r = 0; r < 8; r++) {
                                    for (let c = 0; c < 8; c++) {
                                        const start = { row: rowIndex, col: colIndex };
                                        const end = { row: r, col: c };
                                        if (isValidMove(piece, start, end, this.board)) {
                                            possibleMoves.push({ piece, start, end });
                                        }
                                    }
                                }
                            }
                        });
                    });

                    if (possibleMoves.length > 0) {
                        const move = possibleMoves[Math.floor(Math.random() * possibleMoves.length)];
                        this.board[move.end.row][move.end.col] = move.piece;
                        this.board[move.start.row][move.start.col] = null;

                        this.drawBoard();
                        this.drawPieces();
                        this.switchTurn();
                    }
                }
            }

            function isValidMove(piece, start, end, board) {
                const pieceType = piece[1];
                const [startRow, startCol] = [start.row, start.col];
                const [endRow, endCol] = [end.row, end.col];

                switch (pieceType) {
                    case 'P': // Peón
                        return isValidPawnMove(piece, start, end, board);
                    case 'R': // Torre
                        return isValidRookMove(start, end, board);
                    case 'N': // Caballo
                        return isValidKnightMove(start, end);
                    case 'B': // Alfil
                        return isValidBishopMove(start, end, board);
                    case 'Q': // Reina
                        return isValidQueenMove(start, end, board);
                    case 'K': // Rey
                        return isValidKingMove(start, end);
                    default:
                        return false;
                }
            }

            function isValidPawnMove(piece, start, end, board) {
                const direction = piece[0] === 'w' ? -1 : 1;
                const startRow = start.row;
                const endRow = end.row;
                const startCol = start.col;
                const endCol = end.col;

                if (startCol === endCol) {
                    // Movimiento hacia adelante
                    if (board[endRow][endCol] === null) {
                        if (endRow === startRow + direction) {
                            return true;
                        }
                        if ((startRow === 6 && piece[0] === 'w') || (startRow === 1 && piece[0] === 'b')) {
                            return endRow === startRow + 2 * direction && board[startRow + direction][startCol] === null;
                        }
                    }
                } else if (Math.abs(startCol - endCol) === 1 && endRow === startRow + direction) {
                    // Captura
                    return board[endRow][endCol] !== null && board[endRow][endCol][0] !== piece[0];
                }

                return false;
            }

            function isValidRookMove(start, end, board) {
                const [startRow, startCol] = [start.row, start.col];
                const [endRow, endCol] = [end.row, end.col];

                if (startRow !== endRow && startCol !== endCol) {
                    return false;
                }

                const rowIncrement = startRow === endRow ? 0 : startRow < endRow ? 1 : -1;
                const colIncrement = startCol === endCol ? 0 : startCol < endCol ? 1 : -1;

                let currentRow = startRow + rowIncrement;
                let currentCol = startCol + colIncrement;

                while (currentRow !== endRow || currentCol !== endCol) {
                    if (board[currentRow][currentCol] !== null) {
                        return false;
                    }
                    currentRow += rowIncrement;
                    currentCol += colIncrement;
                }

                return board[endRow][endCol] === null || board[endRow][endCol][0] !== board[startRow][startCol][0];
            }

            function isValidKnightMove(start, end) {
                const [startRow, startCol] = [start.row, start.col];
                const [endRow, endCol] = [end.row, end.col];
                const rowDiff = Math.abs(startRow - endRow);
                const colDiff = Math.abs(startCol - endCol);

                return (rowDiff === 2 && colDiff === 1) || (rowDiff === 1 && colDiff === 2);
            }

            function isValidBishopMove(start, end, board) {
                const [startRow, startCol] = [start.row, start.col];
                const [endRow, endCol] = [end.row, end.col];

                if (Math.abs(startRow - endRow) !== Math.abs(startCol - endCol)) {
                    return false;
                }

                const rowIncrement = startRow < endRow ? 1 : -1;
                const colIncrement = startCol < endCol ? 1 : -1;

                let currentRow = startRow + rowIncrement;
                let currentCol = startCol + colIncrement;

                while (currentRow !== endRow && currentCol !== endCol) {
                    // Check if coordinates are within board boundaries
                    if (currentRow < 0 || currentRow > 7 || currentCol < 0 || currentCol > 7 || board[currentRow][currentCol] !== null) {
                        return false;
                    }
                    currentRow += rowIncrement;
                    currentCol += colIncrement;
                }

                // Check if end coordinates are within board boundaries and the destination piece is not of the same color
                return endRow >= 0 && endRow <= 7 && endCol >= 0 && endCol <= 7 &&
                    (board[endRow][endCol] === null || board[endRow][endCol][0] !== board[startRow][startCol][0]);
            }

            function isValidQueenMove(start, end, board) {
                return isValidRookMove(start, end, board) || isValidBishopMove(start, end, board);
            }

            function isValidKingMove(start, end) {
                const [startRow, startCol] = [start.row, start.col];
                const [endRow, endCol] = [end.row, end.col];
                const rowDiff = Math.abs(startRow - endRow);
                const colDiff = Math.abs(startCol - endCol);

                return rowDiff <= 1 && colDiff <= 1;
            }

            new ChessGame();
        });
    </script>
</x-guest-layout>
