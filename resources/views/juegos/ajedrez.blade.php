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

<x-guest-layout>
    @section('title', 'HAVE FUN - Juegos Ajedrez')
    @include('layouts.partials.navbar')

    <section class="w-full h-[91.1vh] flex-col flex justify-center items-center">
        <section class="container-turn">
            <img id="imgTurn" src="" alt="">
            <h2 id="turn"></h2>
        </section>

        <h1>Chess Game</h1>
        <div class="w-full max-w-2xl flex justify-between items-center px-4 mt-10">
            <button id="modeIndividual"
                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-purple-200 ">
                <span
                    class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Modo Individual
                </span>
            </button>
            <button id="modeMachine"
                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white  focus:ring-4 focus:outline-none focus:ring-pink-200 ">
                <span
                    class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Modo Contra la Máquina
                </span>
            </button>
        </div>

        <div class="w-[100%] flex justify-center items-center">
            <table>
                <tbody>
                    @php
                        $filas = ['8', '7', '6', '5', '4', '3', '2', '1'];
                        $columnas = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
                        $piezasBlancas = [
                            'Wrook',
                            'Wknight',
                            'Wbishop',
                            'Wqueen',
                            'Wking',
                            'Wbishop',
                            'Wknight',
                            'Wrook',
                        ];
                        $piezasNegras = [
                            'Brook',
                            'Bknight',
                            'Bbishop',
                            'Bqueen',
                            'Bking',
                            'Bbishop',
                            'Bknight',
                            'Brook',
                        ];
                        $peonBlanco = 'Wpawn';
                        $peonNegro = 'Bpawn';
                    @endphp

                    @foreach ($filas as $fila)
                        <tr>
                            <td class="{{ $loop->index % 2 == 0 ? 'color1' : 'color2' }}">{{ $fila }}</td>
                            @foreach ($columnas as $columna)
                                @php
                                    $id = $fila . $columna;
                                    $clase =
                                        ($loop->parent->index % 2 == 0 && $loop->index % 2 == 0) ||
                                        ($loop->parent->index % 2 != 0 && $loop->index % 2 != 0)
                                            ? 'color1'
                                            : 'color2';
                                @endphp
                                <td class="bloque {{ $clase }}" id="{{ $id }}">
                                    @if ($fila == '8')
                                        {{ $piezasNegras[$loop->index] }}
                                    @elseif($fila == '7')
                                        {{ $peonNegro }}
                                    @elseif($fila == '2')
                                        {{ $peonBlanco }}
                                    @elseif($fila == '1')
                                        {{ $piezasBlancas[$loop->index] }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td style="background-color: black;"></td>
                        @foreach ($columnas as $columna)
                            <td class="{{ $loop->index % 2 == 0 ? 'color2' : 'color1' }}">{{ $columna }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

    </section>

</x-guest-layout>


<script>
    const pieceSelected = "#f4f774"
    let turn = "W";
    let gameMode = 'individual';
    // Function to set game mode
    document.getElementById("modeIndividual").addEventListener("click", () => {
        gameMode = "individual";
        alert("Modo Individual seleccionado");
    });

    document.getElementById("modeMachine").addEventListener("click", () => {
        gameMode = "machine";
        alert("Modo Contra la Máquina seleccionado");
        if (turn === "B") {
            // Si es el turno de la máquina, que juegue automáticamente
            setTimeout(machineMove, 1000); // Llamada a la función para mover la máquina después de un segundo
        }
    });

    function machineMove() {
        machineTurn = true;
        const bloques = document.querySelectorAll('.bloque');
        const validMoves = [];

        // Recolectar todos los movimientos válidos para la máquina
        bloques.forEach(bloque => {
            if (bloque.innerText.length !== 0 && bloque.innerText[0] === turn) {
                const pieceName = bloque.innerText.slice(1);
                const position = bloque.id;
                const moves = hintMoves(pieceName, position);
                validMoves.push(...moves.map(move => [position, move]));
            }
        });

        // Seleccionar un movimiento aleatorio de los movimientos válidos
        const randomMove = validMoves[Math.floor(Math.random() * validMoves.length)];
        const currentPosition = randomMove[0];
        const targetPosition = randomMove[1];

        // Ejecutar el movimiento en la interfaz
        const currentBlock = document.getElementById(currentPosition);
        const targetBlock = document.getElementById(targetPosition);
        const pieceName = currentBlock.innerText.slice(1);

        targetBlock.innerText = pieceName;
        targetBlock.innerHTML =
            `${turn + pieceName}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turn + pieceName}.png?raw=true" alt="${turn + pieceName}">`;
        targetBlock.style.cursor = 'pointer';

        currentBlock.innerText = '';
        currentBlock.style.cursor = 'default';

        // Verificar si hay ganador después del movimiento
        const winnerResult = winner();
        if (winnerResult === 1) {
            alert("Black Wins", true);
        } else if (winnerResult === 2) {
            alert("White Wins", true);
        } else {
            toggleTurn();
            machineTurn = false;
        }
    }

    //Color the bloques and remove hint moves
    function coloring() {
        const bloques = document.querySelectorAll('.bloque');
        let isEvenRow = false;
        let counter = 0;

        bloques.forEach(bloque => {
            if (counter % 8 === 0) {
                isEvenRow = !isEvenRow;
            }
            if ((isEvenRow && counter % 2 === 0) || (!isEvenRow && counter % 2 !== 0)) {
                bloque.style.backgroundColor = '#eaebc8';
            } else {
                bloque.style.backgroundColor = '#638644';
            }
            if (bloque.classList.contains('hintMove')) {
                bloque.classList.remove('hintMove');
            }
            if (bloque.classList.contains('hintEat')) {
                bloque.classList.remove('hintEat');
            }
            counter++;
        });
    }
    coloring();

    //Inserting the Images
    function insertImage() {
        document.querySelectorAll('.bloque').forEach(image => {
            if (image.innerText.length !== 0) {
                image.innerHTML =
                    `${image.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${image.innerText}.png?raw=true" alt="${image.innerText}">`;
                image.style.cursor = 'pointer';
            }
        });
    }
    insertImage();


    document.querySelectorAll('.bloque').forEach(bloque => {
        bloque.addEventListener('click', function() {
            coloring();
            if (bloque.innerText.length !== 0) {
                if (bloque.innerText[0] === turn) {
                    bloque.style.backgroundColor = pieceSelected;
                    const pieceName = bloque.innerText.slice(1);
                    const position = bloque.id;
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
                //can move one or two bloques forward
                if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row + 1, col]);
                }
                if (checkForPiece(`${row + 2}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row + 2, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
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
                //can move one bloque forward
                if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row + 1, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
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
                //can move one or two bloques forward
                if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row - 1, col]);
                }
                if (checkForPiece(`${row - 2}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row - 2, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
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
                //can move one bloque forward
                if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) === "noPiece") {
                    moves.push([row - 1, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
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
            //can move two bloques up and one bloque to the right
            try {
                if (checkForPiece(`${row + 2}${letters[col]}`, turn) !== "pieceTeam") {
                    moves.push([row + 2, col + 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques up and one bloque to the left
            try {
                if (checkForPiece(`${row + 2}${letters[col - 2]}`, turn) !== "pieceTeam") {
                    moves.push([row + 2, col - 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques down and one bloque to the right
            try {
                if (checkForPiece(`${row - 2}${letters[col]}`, turn) !== "pieceTeam") {
                    moves.push([row - 2, col + 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques down and one bloque to the left
            try {
                if (checkForPiece(`${row - 2}${letters[col - 2]}`, turn) !== "pieceTeam") {
                    moves.push([row - 2, col - 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque up and two bloques to the right
            try {
                if (checkForPiece(`${row + 1}${letters[col + 1]}`, turn) !== "pieceTeam") {
                    moves.push([row + 1, col + 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque up and two bloques to the left
            try {
                if (checkForPiece(`${row + 1}${letters[col - 3]}`, turn) !== "pieceTeam") {
                    moves.push([row + 1, col - 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque down and two bloques to the right
            try {
                if (checkForPiece(`${row - 1}${letters[col + 1]}`, turn) !== "pieceTeam") {
                    moves.push([row - 1, col + 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque down and two bloques to the left
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
            //can move one bloque to the top right
            if (row + 1 <= 8 && col + 1 <= 8) {
                if (checkForPiece(`${row + 1}${letters[col]}`, turn) !== "pieceTeam") {
                    moves.push([row + 1, col + 1]);
                }
            }
            //can move one bloque to the top left
            if (row + 1 <= 8 && col - 1 >= 1) {
                if (checkForPiece(`${row + 1}${letters[col - 2]}`, turn) !== "pieceTeam") {
                    moves.push([row + 1, col - 1]);
                }
            }
            //can move one bloque to the bottom right
            if (row - 1 >= 1 && col + 1 <= 8) {
                if (checkForPiece(`${row - 1}${letters[col]}`, turn) !== "pieceTeam") {
                    moves.push([row - 1, col + 1]);
                }
            }
            //can move one bloque to the bottom left
            if (row - 1 >= 1 && col - 1 >= 1) {
                if (checkForPiece(`${row - 1}${letters[col - 2]}`, turn) !== "pieceTeam") {
                    moves.push([row - 1, col - 1]);
                }
            }
            //can move one bloque to the top
            if (row + 1 <= 8) {
                if (checkForPiece(`${row + 1}${letters[col - 1]}`, turn) !== "pieceTeam") {
                    moves.push([row + 1, col]);
                }
            }
            //can move one bloque to the bottom
            if (row - 1 >= 1) {
                if (checkForPiece(`${row - 1}${letters[col - 1]}`, turn) !== "pieceTeam") {
                    moves.push([row - 1, col]);
                }
            }
            //can move one bloque to the right
            if (col + 1 <= 8) {
                if (checkForPiece(`${row}${letters[col]}`, turn) !== "pieceTeam") {
                    moves.push([row, col + 1]);
                }
            }
            //can move one bloque to the left
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

    //Check if there is a piece on the bloque and if it is an enemy piece
    function checkForPiece(position, myColor) {
        const bloque = document.getElementById(position);
        if (bloque.innerText.length !== 0) {
            if (bloque.innerText[0] !== myColor) {
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
            const bloque = document.getElementById(move);
            if (bloque.innerText.length !== 0) {
                bloque.classList.add('hintEat');
            } else {
                bloque.classList.add('hintMove');
            }
        });
    }

    //Moves the piece to the selected bloque
    function movePiece(moves, pieceName, position) {
        if (gameMode === "machine" && turn === "B") {
            // Si es el turno de la máquina, seleccionar un movimiento aleatorio de los movimientos válidos
            const randomIndex = Math.floor(Math.random() * moves.length);
            const selectedMove = moves[randomIndex];
            const selectedBlock = document.getElementById(selectedMove);
            selectedBlock.innerText = pieceName;
            selectedBlock.innerHTML =
                `${turn + selectedBlock.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turn + selectedBlock.innerText}.png?raw=true" alt="${turn + selectedBlock.innerText}">`;
            selectedBlock.style.cursor = 'pointer';

            const previousBlock = document.getElementById(position);
            previousBlock.innerText = "";
            previousBlock.style.cursor = "default";
            
            if (winner() === 1) {
                alert("Black Wins", true);
            } else if (winner() === 2) {
                alert("White Wins", true);
            } else {
                toggleTurn();
            }
        } else {
            // Si no es el turno de la máquina, esperar al clic del usuario
            document.querySelectorAll('.bloque').forEach(bloque => {
                bloque.addEventListener('click', function() {
                    moves.forEach(move => {
                        if (bloque.id === move) {
                            bloque.innerText = pieceName;
                            bloque.innerHTML =
                                `${turn + bloque.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turn + bloque.innerText}.png?raw=true" alt="${turn + bloque.innerText}">`;
                            bloque.style.cursor = 'pointer';
                            const previousBlock = document.getElementById(position);
                            previousBlock.innerText = "";
                            previousBlock.style.cursor = "default";
                            if (winner() === 1) {
                                alert("Black Wins", true);
                            } else if (winner() === 2) {
                                alert("White Wins", true);
                            } else {
                                toggleTurn();
                            }
                            moves = [];
                        } else {
                            moves = [];
                        }
                    });
                });
            });
        }
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
        document.querySelectorAll('.bloque').forEach(bloque => {
            if (bloque.innerText === "Wking") {
                winnerW = true;
            }
            if (bloque.innerText === "Bking") {
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
