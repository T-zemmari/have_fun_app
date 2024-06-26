<x-guest-layout>
    @section('title', 'HAVE FUN - Juegos Ajedrez')
    @include('layouts.partials.navbar')

    <section class="w-full h-[91.1vh] flex justify-center items-center">
        <section class="container-turn">
            <img id="imgTurn" src="" alt="">
            <h2 id="turn"></h2>
        </section>

        <h1>Chess Game</h1>
        <div class="w-[100%] flex justify-center items-center mt-24">
            <table>
                <tbody>
                    <tr>
                        <td class="color1">8</td>
                        <td class="tile" id="8a">Brook</td>
                        <td class="tile" id="8b">Bknight</td>
                        <td class="tile" id="8c">Bbishop</td>
                        <td class="tile" id="8d">Bqueen</td>
                        <td class="tile" id="8e">Bking</td>
                        <td class="tile" id="8f">Bbishop</td>
                        <td class="tile" id="8g">Bknight</td>
                        <td class="tile" id="8h">Brook</td>
                    </tr>
                    <tr>
                        <td class="color2">7</td>
                        <td class="tile" id="7a">Bpawn</td>
                        <td class="tile" id="7b">Bpawn</td>
                        <td class="tile" id="7c">Bpawn</td>
                        <td class="tile" id="7d">Bpawn</td>
                        <td class="tile" id="7e">Bpawn</td>
                        <td class="tile" id="7f">Bpawn</td>
                        <td class="tile" id="7g">Bpawn</td>
                        <td class="tile" id="7h">Bpawn</td>
                    </tr>
                    <tr>
                        <td class="color1">6</td>
                        <td class="tile" id="6a"></td>
                        <td class="tile" id="6b"></td>
                        <td class="tile" id="6c"></td>
                        <td class="tile" id="6d"></td>
                        <td class="tile" id="6e"></td>
                        <td class="tile" id="6f"></td>
                        <td class="tile" id="6g"></td>
                        <td class="tile" id="6h"></td>
                    </tr>
                    <tr>
                        <td class="color2">5</td>
                        <td class="tile" id="5a"></td>
                        <td class="tile" id="5b"></td>
                        <td class="tile" id="5c"></td>
                        <td class="tile" id="5d"></td>
                        <td class="tile" id="5e"></td>
                        <td class="tile" id="5f"></td>
                        <td class="tile" id="5g"></td>
                        <td class="tile" id="5h"></td>
                    </tr>
                    <tr>
                        <td class="color1">4</td>
                        <td class="tile" id="4a"></td>
                        <td class="tile" id="4b"></td>
                        <td class="tile" id="4c"></td>
                        <td class="tile" id="4d"></td>
                        <td class="tile" id="4e"></td>
                        <td class="tile" id="4f"></td>
                        <td class="tile" id="4g"></td>
                        <td class="tile" id="4h"></td>
                    </tr>
                    <tr>
                        <td class="color2">3</td>
                        <td class="tile" id="3a"></td>
                        <td class="tile" id="3b"></td>
                        <td class="tile" id="3c"></td>
                        <td class="tile" id="3d"></td>
                        <td class="tile" id="3e"></td>
                        <td class="tile" id="3f"></td>
                        <td class="tile" id="3g"></td>
                        <td class="tile" id="3h"></td>
                    </tr>
                    <tr>
                        <td class="color1">2</td>
                        <td class="tile" id="2a">Wpawn</td>
                        <td class="tile" id="2b">Wpawn</td>
                        <td class="tile" id="2c">Wpawn</td>
                        <td class="tile" id="2d">Wpawn</td>
                        <td class="tile" id="2e">Wpawn</td>
                        <td class="tile" id="2f">Wpawn</td>
                        <td class="tile" id="2g">Wpawn</td>
                        <td class="tile" id="2h">Wpawn</td>
                    </tr>
                    <tr>
                        <td class="color2">1</td>
                        <td class="tile" id="1a">Wrook</td>
                        <td class="tile" id="1b">Wknight</td>
                        <td class="tile" id="1c">Wbishop</td>
                        <td class="tile" id="1d">Wqueen</td>
                        <td class="tile" id="1e">Wking</td>
                        <td class="tile" id="1f">Wbishop</td>
                        <td class="tile" id="1g">Wknight</td>
                        <td class="tile" id="1h">Wrook</td>
                    </tr>
                    <tr>
                        <td style="background-color: black;"></td>
                        <td class="color2">a</td>
                        <td class="color1">b</td>
                        <td class="color2">c</td>
                        <td class="color1">d</td>
                        <td class="color2">e</td>
                        <td class="color1">f</td>
                        <td class="color2">g</td>
                        <td class="color1">h</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap');

        .container-turn {
            width: 250px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 3;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            visibility: hidden;
            opacity: 0;
            background-color: #242220;
            border: 3px solid #c9c9c9;
            border-radius: 10px;
            color: #c9c9c9;
            transition: visibility 0.3s linear, opacity 0.3s linear;
        }

        .container-turn img {
            width: 50px;
            height: 50px;
        }

        #turn {
            font-size: 30px;
        }

        h1 {
            text-align: center;
            color: white;
            font-size: 3rem;
            margin-bottom: 2rem;
            margin-top: 3rem;
        }

        table {
            border-collapse: collapse;
            width: 640px;
            height: 640px;
            margin-bottom: 3rem;
        }

        td {
            width: 75px;
            height: 75px;
            border: 1px solid black;
            text-align: center;
            font-size: 0px;
        }

        table tr td:first-child {
            width: 30px;
            font-size: 1rem;
        }

        table tr:last-child td {
            height: 30px;
            font-size: 1rem;
        }

        .color1 {
            background-color: #638644;
            color: #eaebc8;
        }

        .color2 {
            background-color: #eaebc8;
            color: #638644;
        }

        .img {
            width: 60px;
            position: relative;
            bottom: 5px;
        }

        .hintMove {
            background: url(https://github.com/TwickE/ChessGame/blob/main/images/HintMove.png?raw=true);
        }

        .hintEat {
            background: url(https://github.com/TwickE/ChessGame/blob/main/images/HintEat.png?raw=true);
        }

        @media (max-width:650px) {
            h1 {
                margin-bottom: 0;
                font-size: 2.5rem;
            }

            table {
                transform: scale(0.8);
            }

            .container-turn {
                width: 200px;
                height: 110px;
            }

            .container-turn img {
                width: 40px;
                height: 40px;
            }

            #turn {
                font-size: 25px;
            }
        }

        @media (max-width:550px) {
            table {
                transform: scale(0.6);
            }

            .container-turn {
                width: 180px;
                height: 100px;
            }

            .container-turn img {
                width: 35px;
                height: 35px;
            }

            #turn {
                font-size: 20px;
            }
        }

        @media (max-width:400px) {
            table {
                transform: scale(0.5);
            }
        }
    </style>

    <script>
        const pieceSelected = "#f4f774"
        let turn = "W";

        //Color the tiles and remove hint moves
        function coloring() {
            const tiles = document.querySelectorAll('.tile');
            let isEvenRow = false;
            let counter = 0;

            tiles.forEach(tile => {
                if (counter % 8 === 0) {
                    isEvenRow = !isEvenRow;
                }
                if ((isEvenRow && counter % 2 === 0) || (!isEvenRow && counter % 2 !== 0)) {
                    tile.style.backgroundColor = '#eaebc8';
                } else {
                    tile.style.backgroundColor = '#638644';
                }
                if (tile.classList.contains('hintMove')) {
                    tile.classList.remove('hintMove');
                }
                if (tile.classList.contains('hintEat')) {
                    tile.classList.remove('hintEat');
                }
                counter++;
            });
        }
        coloring();

        //Inserting the Images
        function insertImage() {
            document.querySelectorAll('.tile').forEach(image => {
                if (image.innerText.length !== 0) {
                    image.innerHTML =
                        `${image.innerText}<img class='img' src="https://github.com/TwickE/ChessGame/blob/main/images/${image.innerText}.png?raw=true" alt="${image.innerText}">`;
                    image.style.cursor = 'pointer';
                }
            });
        }
        insertImage();


        document.querySelectorAll('.tile').forEach(tile => {
            tile.addEventListener('click', function() {
                coloring();
                if (tile.innerText.length !== 0) {
                    if (tile.innerText[0] === turn) {
                        tile.style.backgroundColor = pieceSelected;
                        const pieceName = tile.innerText.slice(1);
                        const position = tile.id;
                        console.log(pieceName, position);
                        const moves = hintMoves(pieceName, position);
                        movePiece(moves, pieceName, position);
                    }
                }
            });
        });

        //Give the hints to where the pieces can move
        function hintMoves(pieceName, position) {
            const moves = [];
            //convert position to coordinates
            const letters = ["a", "b", "c", "d", "e", "f", "g", "h"];
            const row = parseInt(position[0]);
            const col = letters.indexOf(position[1]) + 1;
            console.log(row, col);
            console.log(pieceName);

            //PAWN
            if (pieceName === "pawn") {
                //check if pawn is on starting position
                let isFirstMove = false;
                if (row === 2 && turn === "W") {
                    isFirstMove = true;
                } else if (row === 7 && turn === "B") {
                    isFirstMove = true;
                }

                //calculate possible moves
                if (isFirstMove && turn === "W") {
                    //can move one or two tiles forward
                    if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row + 1, col]);
                    }
                    if (checkForPiece(`${row + 2}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row + 2, col]);
                    }

                    //can move one tile diagonally forward if there is an enemy piece to eat
                    try {
                        if (checkForPiece(`${row + 1}${letters[col - 2]}`, turn) === "pieceEnemy") {
                            moves.push([row + 1, col - 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                    try {
                        if (checkForPiece(`${row + 1}${letters[col]}`, turn) === "pieceEnemy") {
                            moves.push([row + 1, col + 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }

                } else if (turn === "W") {
                    //can move one tile forward
                    if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row + 1, col]);
                    }

                    //can move one tile diagonally forward if there is an enemy piece to eat
                    try {
                        if (checkForPiece(`${row + 1}${letters[col - 2]}`, turn) === "pieceEnemy") {
                            moves.push([row + 1, col - 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                    try {
                        if (checkForPiece(`${row + 1}${letters[col]}`, turn) === "pieceEnemy") {
                            moves.push([row + 1, col + 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                }
                if (isFirstMove && turn === "B") {
                    //can move one or two tiles forward
                    if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row - 1, col]);
                    }
                    if (checkForPiece(`${row - 2}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row - 2, col]);
                    }

                    //can move one tile diagonally forward if there is an enemy piece to eat
                    try {
                        if (checkForPiece(`${row - 1}${letters[col - 2]}`, turn) === "pieceEnemy") {
                            moves.push([row - 1, col - 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                    try {
                        if (checkForPiece(`${row - 1}${letters[col]}`, turn) === "pieceEnemy") {
                            moves.push([row - 1, col + 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                } else if (turn === "B") {
                    //can move one tile forward
                    if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([row - 1, col]);
                    }

                    //can move one tile diagonally forward if there is an enemy piece to eat
                    try {
                        if (checkForPiece(`${row - 1}${letters[col - 2]}`, turn) === "pieceEnemy") {
                            moves.push([row - 1, col - 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                    try {
                        if (checkForPiece(`${row - 1}${letters[col]}`, turn) === "pieceEnemy") {
                            moves.push([row - 1, col + 1]);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                }
            }

            //ROOK
            if (pieceName === "rook") {
                //can move to the top
                for (let i = row + 1; i <= 8; i++) {
                    if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([i, col]);
                    } else if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, col]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom
                for (let i = row - 1; i >= 1; i--) {
                    if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([i, col]);
                    } else if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, col]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the right
                for (let i = col + 1; i <= 8; i++) {
                    if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "noPiece") {
                        moves.push([row, i]);
                    } else if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "pieceEnemy") {
                        moves.push([row, i]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the left
                for (let i = col - 1; i >= 1; i--) {
                    if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "noPiece") {
                        moves.push([row, i]);
                    } else if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "pieceEnemy") {
                        moves.push([row, i]);
                        break;
                    } else {
                        break;
                    }
                }
                //castling
            }

            //KNIGHT
            if (pieceName === "knight") {
                //can move two tiles up and one tile to the right
                try {
                    if (checkForPiece(`${row + 2}${letters[col]}`, turn) !== "pieceTeam") {
                        moves.push([row + 2, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move two tiles up and one tile to the left
                try {
                    if (checkForPiece(`${row + 2}${letters[col - 2]}`, turn) !== "pieceTeam") {
                        moves.push([row + 2, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move two tiles down and one tile to the right
                try {
                    if (checkForPiece(`${row - 2}${letters[col]}`, turn) !== "pieceTeam") {
                        moves.push([row - 2, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move two tiles down and one tile to the left
                try {
                    if (checkForPiece(`${row - 2}${letters[col - 2]}`, turn) !== "pieceTeam") {
                        moves.push([row - 2, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move one tile up and two tiles to the right
                try {
                    if (checkForPiece(`${row + 1}${letters[col + 1]}`, turn) !== "pieceTeam") {
                        moves.push([row + 1, col + 2]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move one tile up and two tiles to the left
                try {
                    if (checkForPiece(`${row + 1}${letters[col - 3]}`, turn) !== "pieceTeam") {
                        moves.push([row + 1, col - 2]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move one tile down and two tiles to the right
                try {
                    if (checkForPiece(`${row - 1}${letters[col + 1]}`, turn) !== "pieceTeam") {
                        moves.push([row - 1, col + 2]);
                    }
                } catch (err) {
                    console.log(err);
                }
                //can move one tile down and two tiles to the left
                try {
                    if (checkForPiece(`${row - 1}${letters[col - 3]}`, turn) !== "pieceTeam") {
                        moves.push([row - 1, col - 2]);
                    }
                } catch (err) {
                    console.log(err);
                }
            }

            //BISHOP
            if (pieceName === "bishop") {
                //can move to the top right
                for (let i = row + 1, j = col + 1; i <= 8 && j <= 8; i++, j++) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the top left
                for (let i = row + 1, j = col - 1; i <= 8 && j >= 1; i++, j--) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom right
                for (let i = row - 1, j = col + 1; i >= 1 && j <= 8; i--, j++) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom left
                for (let i = row - 1, j = col - 1; i >= 1 && j >= 1; i--, j--) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
            }

            //QUEEN
            if (pieceName === "queen") {
                //can move to the top right
                for (let i = row + 1, j = col + 1; i <= 8 && j <= 8; i++, j++) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the top left
                for (let i = row + 1, j = col - 1; i <= 8 && j >= 1; i++, j--) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom right
                for (let i = row - 1, j = col + 1; i >= 1 && j <= 8; i--, j++) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom left
                for (let i = row - 1, j = col - 1; i >= 1 && j >= 1; i--, j--) {
                    if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "noPiece") {
                        moves.push([i, j]);
                    } else if (checkForPiece(`${i}${letters[j - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, j]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the top
                for (let i = row + 1; i <= 8; i++) {
                    if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([i, col]);
                    } else if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, col]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the bottom
                for (let i = row - 1; i >= 1; i--) {
                    if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "noPiece") {
                        moves.push([i, col]);
                    } else if (checkForPiece(`${i}${letters[col - 1]}`, turn) === "pieceEnemy") {
                        moves.push([i, col]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the right
                for (let i = col + 1; i <= 8; i++) {
                    if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "noPiece") {
                        moves.push([row, i]);
                    } else if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "pieceEnemy") {
                        moves.push([row, i]);
                        break;
                    } else {
                        break;
                    }
                }
                //can move to the left
                for (let i = col - 1; i >= 1; i--) {
                    if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "noPiece") {
                        moves.push([row, i]);
                    } else if (checkForPiece(`${row}${letters[i - 1]}`, turn) === "pieceEnemy") {
                        moves.push([row, i]);
                        break;
                    } else {
                        break;
                    }
                }
            }

            //KING
            if (pieceName === "king") {
                //can move one tile to the top right
                if (row + 1 <= 8 && col + 1 <= 8) {
                    if (checkForPiece(`${row + 1}${letters[col]}`, turn) !== "pieceTeam") {
                        moves.push([row + 1, col + 1]);
                    }
                }
                //can move one tile to the top left
                if (row + 1 <= 8 && col - 1 >= 1) {
                    if (checkForPiece(`${row + 1}${letters[col - 2]}`, turn) !== "pieceTeam") {
                        moves.push([row + 1, col - 1]);
                    }
                }
                //can move one tile to the bottom right
                if (row - 1 >= 1 && col + 1 <= 8) {
                    if (checkForPiece(`${row - 1}${letters[col]}`, turn) !== "pieceTeam") {
                        moves.push([row - 1, col + 1]);
                    }
                }
                //can move one tile to the bottom left
                if (row - 1 >= 1 && col - 1 >= 1) {
                    if (checkForPiece(`${row - 1}${letters[col - 2]}`, turn) !== "pieceTeam") {
                        moves.push([row - 1, col - 1]);
                    }
                }
                //can move one tile to the top
                if (row + 1 <= 8) {
                    if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) !== "pieceTeam") {
                        moves.push([row + 1, col]);
                    }
                }
                //can move one tile to the bottom
                if (row - 1 >= 1) {
                    if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) !== "pieceTeam") {
                        moves.push([row - 1, col]);
                    }
                }
                //can move one tile to the right
                if (col + 1 <= 8) {
                    if (checkForPiece(`${row}${letters[col]}`, turn) !== "pieceTeam") {
                        moves.push([row, col + 1]);
                    }
                }
                //can move one tile to the left
                if (col - 1 >= 1) {
                    if (checkForPiece(`${row}${letters[col - 2]}`, turn) !== "pieceTeam") {
                        moves.push([row, col - 1]);
                    }
                }
            }

            //convert coordinates back to position format
            const validMoves = [];
            moves.forEach(move => {
                const row = move[0];
                const col = move[1];
                const position = `${row}${letters[col - 1]}`;
                validMoves.push(position);
            });
            giveHints(validMoves);
            console.log(validMoves);
            return validMoves;
        }

        //Check if there is a piece on the tile and if it is an enemy piece
        function checkForPiece(position, myColor) {
            const tile = document.getElementById(position);
            if (tile.innerText.length !== 0) {
                if (tile.innerText[0] !== myColor) {
                    return "pieceEnemy";
                } else {
                    return "pieceTeam";
                }
            } else {
                return "noPiece";
            }
        }

        //Give hints to the valid moves
        function giveHints(validMoves) {
            validMoves.forEach(move => {
                const tile = document.getElementById(move);
                if (tile.innerText.length !== 0) {
                    tile.classList.add('hintEat');
                } else {
                    tile.classList.add('hintMove');
                }
            });
        }

        //Moves the piece to the selected tile
        function movePiece(moves, pieceName, position) {
            document.querySelectorAll('.tile').forEach(tile => {
                tile.addEventListener('click', function() {
                    moves.forEach(move => {
                        if (tile.id === move) {
                            tile.innerText = pieceName;
                            tile.innerHTML =
                                `${turn + tile.innerText}<img class='img' src="https://github.com/TwickE/ChessGame/blob/main/images/${turn + tile.innerText}.png?raw=true" alt="${turn + tile.innerText}">`;
                            tile.style.cursor = 'pointer';
                            const previousTile = document.getElementById(position);
                            previousTile.innerText = "";
                            previousTile.style.cursor = "default";
                            if (winner() === 1) {
                                alert("Black Wins", true);
                            } else if (winner() === 2) {
                                alert("White Wins", true);
                            } else {
                                toggleTurn(turn);
                            }
                            moves = [];
                        } else {
                            moves = [];
                        }
                    });
                });
            });
        }

        //Creates an alert
        function alert(text, end) {
            const alert = document.querySelector('.container-turn');
            alert.style.visibility = 'visible';
            alert.style.opacity = '1';

            const imgTurn = document.getElementById('imgTurn');
            if (text === "White's Turn" || text === "White Wins") {
                imgTurn.src = "https://github.com/TwickE/ChessGame/blob/main/images/Wking.png?raw=true";
                imgTurn.alt = "Wking";
            } else {
                imgTurn.src = "https://github.com/TwickE/ChessGame/blob/main/images/Bking.png?raw=true";
                imgTurn.alt = "Bking";
            }

            const turnElement = document.getElementById('turn');
            turnElement.innerText = text;

            if (end === true) {
                setTimeout(function() {
                    alert.style.visibility = 'hidden';
                    alert.style.opacity = '0';
                    window.location.reload();
                }, 3000);
            } else {
                setTimeout(function() {
                    alert.style.visibility = 'hidden';
                    alert.style.opacity = '0';
                }, 1000);
            }
        }

        //Toggles the turn
        function toggleTurn() {
            if (turn === "W") {
                turn = "B";
                alert("Black's Turn", false)
            } else {
                turn = "W";
                alert("White's Turn", false)
            }
        }

        //Checks if there is a winner
        function winner() {
            let winnerW = false;
            let winnerB = false;
            document.querySelectorAll('.tile').forEach(tile => {
                if (tile.innerText === "Wking") {
                    winnerW = true;
                }
                if (tile.innerText === "Bking") {
                    winnerB = true;
                }
            });
            if (winnerW === false) {
                return 1;
            } else if (winnerB === false) {
                return 2;
            }
        }
    </script>

</x-guest-layout>
