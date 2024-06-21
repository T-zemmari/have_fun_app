// document.addEventListener('DOMContentLoaded', () => {
//     const canvas = document.getElementById('canva_tetris_one');
//     const ctx = canvas.getContext('2d');
//     const scoreElement = document.getElementById('score_tetris_one');
//     const levelElement = document.getElementById('span_tetris_one_actual_level');
//     const startButton = document.getElementById('startButton');
//     const pauseButton = document.getElementById('pauseButton');
//     const resumeButton = document.getElementById('resumeButton');
//     const stopButton = document.getElementById('stopButton');
//     const restartButton = document.getElementById('restartButton');
//     const previewNextPiece = document.getElementById('preview_next_piece');

//     const ROWS = 20;
//     const COLS = 10;
//     const BLOCK_SIZE = 30;

//     const PIECES = {
//         I: [
//             [1, 1, 1, 1]
//         ],
//         O: [
//             [1, 1],
//             [1, 1],
//         ],
//         T: [
//             [0, 1, 0],
//             [1, 1, 1],
//         ],
//         S: [
//             [0, 1, 1],
//             [1, 1, 0],
//         ],
//         Z: [
//             [1, 1, 0],
//             [0, 1, 1],
//         ],
//         J: [
//             [1, 0, 0],
//             [1, 1, 1],
//         ],
//         L: [
//             [0, 0, 1],
//             [1, 1, 1],
//         ],
//     };

//     let board;
//     let currentPiece;
//     let nextPiece;
//     let score;
//     let level;
//     let speed;
//     let gameInterval;
//     let isPaused = false;

//     function createEmptyBoard() {
//         return Array.from({
//             length: ROWS
//         }, () => Array(COLS).fill(0));
//     }

//     function generateRandomPiece() {
//         const pieceTypes = Object.keys(PIECES);
//         const randomType = pieceTypes[Math.floor(Math.random() * pieceTypes.length)];
//         return {
//             type: randomType,
//             shape: PIECES[randomType],
//             x: 3,
//             y: 0
//         };
//     }

//     function drawBoard() {
//         ctx.clearRect(0, 0, canvas.width, canvas.height);
//         for (let row = 0; row < ROWS; row++) {
//             for (let col = 0; col < COLS; col++) {
//                 ctx.fillStyle = board[row][col] ? 'cyan' : 'black';
//                 ctx.fillRect(col * BLOCK_SIZE, row * BLOCK_SIZE, BLOCK_SIZE, BLOCK_SIZE);
//                 ctx.strokeRect(col * BLOCK_SIZE, row * BLOCK_SIZE, BLOCK_SIZE, BLOCK_SIZE);
//             }
//         }
//     }

//     function drawPiece(piece) {
//         ctx.fillStyle = 'cyan';
//         piece.shape.forEach((row, y) => {
//             row.forEach((value, x) => {
//                 if (value) {
//                     ctx.fillRect((piece.x + x) * BLOCK_SIZE, (piece.y + y) * BLOCK_SIZE,
//                         BLOCK_SIZE, BLOCK_SIZE);
//                     ctx.strokeRect((piece.x + x) * BLOCK_SIZE, (piece.y + y) * BLOCK_SIZE,
//                         BLOCK_SIZE, BLOCK_SIZE);
//                 }
//             });
//         });
//     }

//     function drawNextPiecePreview(piece) {
//         const previewCtx = previewNextPiece.getContext('2d');
//         previewCtx.clearRect(0, 0, previewNextPiece.width, previewNextPiece.height);

//         const scale = Math.min(
//             previewNextPiece.width / (piece.shape[0].length * BLOCK_SIZE),
//             previewNextPiece.height / (piece.shape.length * BLOCK_SIZE)
//         );

//         previewCtx.fillStyle = 'cyan';
//         piece.shape.forEach((row, y) => {
//             row.forEach((value, x) => {
//                 if (value) {
//                     previewCtx.fillRect(x * BLOCK_SIZE * scale, y * BLOCK_SIZE * scale,
//                         BLOCK_SIZE * scale, BLOCK_SIZE * scale);
//                     previewCtx.strokeRect(x * BLOCK_SIZE * scale, y * BLOCK_SIZE * scale,
//                         BLOCK_SIZE * scale, BLOCK_SIZE * scale);
//                 }
//             });
//         });
//     }

//     function movePieceDown() {
//         if (!collision(currentPiece, 0, 1)) {
//             currentPiece.y += 1;
//         } else {
//             mergePiece(currentPiece);
//             currentPiece = nextPiece;
//             nextPiece = generateRandomPiece();
//             drawNextPiecePreview(nextPiece);
//             if (collision(currentPiece, 0, 0)) {
//                 alert("Game Over");
//                 stopGame();
//             }
//         }
//     }

//     function collision(piece, dx, dy) {
//         for (let y = 0; y < piece.shape.length; y++) {
//             for (let x = 0; x < piece.shape[y].length; x++) {
//                 if (piece.shape[y][x]) {
//                     let newX = piece.x + x + dx;
//                     let newY = piece.y + y + dy;
//                     if (newX < 0 || newX >= COLS || newY >= ROWS || board[newY] && board[newY][newX]) {
//                         return true;
//                     }
//                 }
//             }
//         }
//         return false;
//     }

//     function mergePiece(piece) {
//         piece.shape.forEach((row, y) => {
//             row.forEach((value, x) => {
//                 if (value) {
//                     board[piece.y + y][piece.x + x] = value;
//                 }
//             });
//         });
//         removeFullRows();
//     }

//     function removeFullRows() {
//         let linesCleared = 0;
//         for (let y = ROWS - 1; y >= 0; y--) {
//             if (board[y].every(value => value)) {
//                 linesCleared++;
//                 board.splice(y, 1);
//                 board.unshift(new Array(COLS).fill(0));
//             }
//         }
//         updateScore(linesCleared);
//     }

//     function updateScore(lines) {
//         score += lines * 10;
//         scoreElement.textContent = score;
//         if (score >= level * 50) {
//             level++;
//             levelElement.textContent = level;
//             speed *= 0.9;
//             clearInterval(gameInterval);
//             gameInterval = setInterval(gameLoop, speed);
//         }
//     }

//     function handleKey(event) {
//         if (!isPaused) {
//             switch (event.key) {
//                 case 'ArrowLeft':
//                     if (!collision(currentPiece, -1, 0)) {
//                         currentPiece.x -= 1;
//                     }
//                     break;
//                 case 'ArrowRight':
//                     if (!collision(currentPiece, 1, 0)) {
//                         currentPiece.x += 1;
//                     }
//                     break;
//                 case 'ArrowDown':
//                     movePieceDown();
//                     break;
//                 case 'ArrowUp':
//                     rotatePiece();
//                     break;
//             }
//             drawBoard();
//             drawPiece(currentPiece);
//         }
//     }

//     function rotatePiece() {
//         const newShape = currentPiece.shape[0].map((_, index) =>
//             currentPiece.shape.map(row => row[index]).reverse()
//         );
//         if (!collision({
//                 ...currentPiece,
//                 shape: newShape
//             }, 0, 0)) {
//             currentPiece.shape = newShape;
//         }
//     }

//     function gameLoop() {
//         if (!isPaused) {
//             movePieceDown();
//             drawBoard();
//             drawPiece(currentPiece);
//         }
//     }

//     function startGame() {
//         board = createEmptyBoard();
//         currentPiece = generateRandomPiece();
//         nextPiece = generateRandomPiece();
//         drawNextPiecePreview(nextPiece);
//         score = 0;
//         level = 1;
//         speed = 500;
//         scoreElement.textContent = score;
//         levelElement.textContent = level;
//         clearInterval(gameInterval);
//         gameInterval = setInterval(gameLoop, speed);
//     }

//     function pauseGame() {
//         isPaused = true;
//         pauseButton.style.display = 'none';
//         resumeButton.style.display = 'block';
//     }

//     function resumeGame() {
//         isPaused = false;
//         pauseButton.style.display = 'block';
//         resumeButton.style.display = 'none';
//     }

//     function stopGame() {
//         clearInterval(gameInterval);
//         board = createEmptyBoard();
//         drawBoard();
//     }

//     function restartGame() {
//         stopGame();
//         startGame();
//     }

//     startButton.addEventListener('click', startGame);
//     pauseButton.addEventListener('click', pauseGame);
//     resumeButton.addEventListener('click', resumeGame);
//     stopButton.addEventListener('click', stopGame);
//     restartButton.addEventListener('click', restartGame);
//     document.addEventListener('keydown', handleKey);

//     drawBoard();
// });