<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap');

    .container-turno {
        width: 350px;
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

    .container-turno img {
        width: 50px;
        height: 50px;
    }

    #turno {
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
        posicion: relative;
        bottom: 5px;
    }

    .hintMove {
        background: url(/assets/imgs/Piezas_ajedrez/HintMove.png);
    }

    .hintEat {
        background: url(/assets/imgs/Piezas_ajedrez/HintEat.png);
    }

    @media (max-width:650px) {
        h1 {
            margin-bottom: 0;
            font-size: 2.5rem;
        }

        table {
            transform: scale(0.8);
        }

        .container-turno {
            width: 200px;
            height: 110px;
        }

        .container-turno img {
            width: 40px;
            height: 40px;
        }

        #turno {
            font-size: 25px;
        }
    }

    @media (max-width:550px) {
        table {
            transform: scale(0.6);
        }

        .container-turno {
            width: 180px;
            height: 100px;
        }

        .container-turno img {
            width: 35px;
            height: 35px;
        }

        #turno {
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
        <section class="container-turno">
            <img id="imgTurn" src="" alt="">
            <h2 id="turno"></h2>
        </section>

        <h1>Ajedrez</h1>
        <div class="w-[100%] flex justify-center items-center flex-col">
            <table class="mt-12">
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
            <div class="w-full max-w-2xl flex justify-between items-center px-4 -mt-5">
                <button id="modo_individual"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-purple-200 ">
                    <span
                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Modo Individual
                    </span>
                </button>
                <button id="modo_machine"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white  focus:ring-4 focus:outline-none focus:ring-pink-200 ">
                    <span
                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Modo Contra la Máquina
                    </span>
                </button>
            </div>
        </div>



    </section>

</x-guest-layout>


<script>
    const pieza_seleccionada = "#f4f774"
    let turno = "W";
    let modo_de_juego = 'individual';
    // Function to set game mode
    document.getElementById("modo_individual").addEventListener("click", () => {
        modo_de_juego = "individual";
        Swal.fire({
            html: `<h4>Modo Individual seleccionado</h4>`,
            icon: 'info',
        })
    });

    document.getElementById("modo_machine").addEventListener("click", () => {
        modo_de_juego = "machine";
        Swal.fire({
            html: `<h4>Modo Contra la Máquina seleccionado</h4>`,
            icon: 'info',
        })
        if (turno === "B") {
            // Si es el turno de la máquina, que juegue automáticamente
            setTimeout(movimientos_de_la_maquina,
                1000); // Llamada a la función para mover la máquina después de un segundo
        }
    });


    //Color the bloques and remove hint movimientos
    function fn_colorear_bloques() {
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
    fn_colorear_bloques();

    //Inserting the Images
    function insertar_imagen() {
        document.querySelectorAll('.bloque').forEach(image => {
            if (image.innerText.length !== 0) {
                image.innerHTML =
                    `${image.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${image.innerText}.png" alt="${image.innerText}">`;
                image.style.cursor = 'pointer';
            }
        });
    }
    insertar_imagen();


    document.querySelectorAll('.bloque').forEach(bloque => {
        bloque.addEventListener('click', function() {
            fn_colorear_bloques();
            if (bloque.innerText.length !== 0) {
                if (bloque.innerText[0] === turno) {
                    bloque.style.backgroundColor = pieza_seleccionada;
                    const nombre_de_la_piez = bloque.innerText.slice(1);
                    const posicion = bloque.id;
                    console.log(nombre_de_la_piez, posicion);
                    const movimientos = movimientos_de_golpeo(nombre_de_la_piez, posicion);
                    fn_mover_pieza(movimientos, nombre_de_la_piez, posicion);

                }
            }
        });
    });

    //Give the hints to where the pieces can move
    function movimientos_de_golpeo(nombre_de_la_piez, posicion) {
        const movimientos = [];
        //convert posicion to coordinates
        const lettras = ["a", "b", "c", "d", "e", "f", "g", "h"];
        const row = parseInt(posicion[0]);
        const col = lettras.indexOf(posicion[1]) + 1;
        console.log(row, col);
        console.log(nombre_de_la_piez);

        //PAWN
        if (nombre_de_la_piez === "pawn") {
            //check if pawn is on starting posicion
            let isFirstMove = false;
            if (row === 2 && turno === "W") {
                isFirstMove = true;
            } else if (row === 7 && turno === "B") {
                isFirstMove = true;
            }

            //calculate possible movimientos
            if (isFirstMove && turno === "W") {
                //can move one or two bloques forward
                if (fn_buscar_pieza(`${row + 1}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row + 1, col]);
                }
                if (fn_buscar_pieza(`${row + 2}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row + 2, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
                try {
                    if (fn_buscar_pieza(`${row + 1}${lettras[col - 2]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row + 1, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                try {
                    if (fn_buscar_pieza(`${row + 1}${lettras[col]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row + 1, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }

            } else if (turno === "W") {
                //can move one bloque forward
                if (fn_buscar_pieza(`${row + 1}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row + 1, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
                try {
                    if (fn_buscar_pieza(`${row + 1}${lettras[col - 2]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row + 1, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                try {
                    if (fn_buscar_pieza(`${row + 1}${lettras[col]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row + 1, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
            }
            if (isFirstMove && turno === "B") {
                //can move one or two bloques forward
                if (fn_buscar_pieza(`${row - 1}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row - 1, col]);
                }
                if (fn_buscar_pieza(`${row - 2}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row - 2, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
                try {
                    if (fn_buscar_pieza(`${row - 1}${lettras[col - 2]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row - 1, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                try {
                    if (fn_buscar_pieza(`${row - 1}${lettras[col]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row - 1, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
            } else if (turno === "B") {
                //can move one bloque forward
                if (fn_buscar_pieza(`${row - 1}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row - 1, col]);
                }

                //can move one bloque diagonally forward if there is an enemy piece to eat
                try {
                    if (fn_buscar_pieza(`${row - 1}${lettras[col - 2]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row - 1, col - 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
                try {
                    if (fn_buscar_pieza(`${row - 1}${lettras[col]}`, turno) === "pieza_enemiga") {
                        movimientos.push([row - 1, col + 1]);
                    }
                } catch (err) {
                    console.log(err);
                }
            }
        }

        //ROOK
        if (nombre_de_la_piez === "rook") {
            //can move to the top
            for (let i = row + 1; i <= 8; i++) {
                if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, col]);
                } else if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, col]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom
            for (let i = row - 1; i >= 1; i--) {
                if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, col]);
                } else if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, col]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the right
            for (let i = col + 1; i <= 8; i++) {
                if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row, i]);
                } else if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([row, i]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the left
            for (let i = col - 1; i >= 1; i--) {
                if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row, i]);
                } else if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([row, i]);
                    break;
                } else {
                    break;
                }
            }
            //castling
        }

        //KNIGHT
        if (nombre_de_la_piez === "knight") {
            //can move two bloques up and one bloque to the right
            try {
                if (fn_buscar_pieza(`${row + 2}${lettras[col]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 2, col + 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques up and one bloque to the left
            try {
                if (fn_buscar_pieza(`${row + 2}${lettras[col - 2]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 2, col - 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques down and one bloque to the right
            try {
                if (fn_buscar_pieza(`${row - 2}${lettras[col]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 2, col + 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move two bloques down and one bloque to the left
            try {
                if (fn_buscar_pieza(`${row - 2}${lettras[col - 2]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 2, col - 1]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque up and two bloques to the right
            try {
                if (fn_buscar_pieza(`${row + 1}${lettras[col + 1]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 1, col + 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque up and two bloques to the left
            try {
                if (fn_buscar_pieza(`${row + 1}${lettras[col - 3]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 1, col - 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque down and two bloques to the right
            try {
                if (fn_buscar_pieza(`${row - 1}${lettras[col + 1]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 1, col + 2]);
                }
            } catch (err) {
                console.log(err);
            }
            //can move one bloque down and two bloques to the left
            try {
                if (fn_buscar_pieza(`${row - 1}${lettras[col - 3]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 1, col - 2]);
                }
            } catch (err) {
                console.log(err);
            }
        }

        //BISHOP
        if (nombre_de_la_piez === "bishop") {
            //can move to the top right
            for (let i = row + 1, j = col + 1; i <= 8 && j <= 8; i++, j++) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the top left
            for (let i = row + 1, j = col - 1; i <= 8 && j >= 1; i++, j--) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom right
            for (let i = row - 1, j = col + 1; i >= 1 && j <= 8; i--, j++) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom left
            for (let i = row - 1, j = col - 1; i >= 1 && j >= 1; i--, j--) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
        }

        //QUEEN
        if (nombre_de_la_piez === "queen") {
            //can move to the top right
            for (let i = row + 1, j = col + 1; i <= 8 && j <= 8; i++, j++) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the top left
            for (let i = row + 1, j = col - 1; i <= 8 && j >= 1; i++, j--) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom right
            for (let i = row - 1, j = col + 1; i >= 1 && j <= 8; i--, j++) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom left
            for (let i = row - 1, j = col - 1; i >= 1 && j >= 1; i--, j--) {
                if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, j]);
                } else if (fn_buscar_pieza(`${i}${lettras[j - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, j]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the top
            for (let i = row + 1; i <= 8; i++) {
                if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, col]);
                } else if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, col]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the bottom
            for (let i = row - 1; i >= 1; i--) {
                if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([i, col]);
                } else if (fn_buscar_pieza(`${i}${lettras[col - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([i, col]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the right
            for (let i = col + 1; i <= 8; i++) {
                if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row, i]);
                } else if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([row, i]);
                    break;
                } else {
                    break;
                }
            }
            //can move to the left
            for (let i = col - 1; i >= 1; i--) {
                if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "no_hay_pieza") {
                    movimientos.push([row, i]);
                } else if (fn_buscar_pieza(`${row}${lettras[i - 1]}`, turno) === "pieza_enemiga") {
                    movimientos.push([row, i]);
                    break;
                } else {
                    break;
                }
            }
        }

        //KING
        if (nombre_de_la_piez === "king") {
            //can move one bloque to the top right
            if (row + 1 <= 8 && col + 1 <= 8) {
                if (fn_buscar_pieza(`${row + 1}${lettras[col]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 1, col + 1]);
                }
            }
            //can move one bloque to the top left
            if (row + 1 <= 8 && col - 1 >= 1) {
                if (fn_buscar_pieza(`${row + 1}${lettras[col - 2]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 1, col - 1]);
                }
            }
            //can move one bloque to the bottom right
            if (row - 1 >= 1 && col + 1 <= 8) {
                if (fn_buscar_pieza(`${row - 1}${lettras[col]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 1, col + 1]);
                }
            }
            //can move one bloque to the bottom left
            if (row - 1 >= 1 && col - 1 >= 1) {
                if (fn_buscar_pieza(`${row - 1}${lettras[col - 2]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 1, col - 1]);
                }
            }
            //can move one bloque to the top
            if (row + 1 <= 8) {
                if (fn_buscar_pieza(`${row + 1}${lettras[col - 1]}`, turno) !== "mi_pieza") {
                    movimientos.push([row + 1, col]);
                }
            }
            //can move one bloque to the bottom
            if (row - 1 >= 1) {
                if (fn_buscar_pieza(`${row - 1}${lettras[col - 1]}`, turno) !== "mi_pieza") {
                    movimientos.push([row - 1, col]);
                }
            }
            //can move one bloque to the right
            if (col + 1 <= 8) {
                if (fn_buscar_pieza(`${row}${lettras[col]}`, turno) !== "mi_pieza") {
                    movimientos.push([row, col + 1]);
                }
            }
            //can move one bloque to the left
            if (col - 1 >= 1) {
                if (fn_buscar_pieza(`${row}${lettras[col - 2]}`, turno) !== "mi_pieza") {
                    movimientos.push([row, col - 1]);
                }
            }
        }

        //convert coordinates back to posicion format
        const validar_movimientos = [];
        movimientos.forEach(move => {
            const row = move[0];
            const col = move[1];
            const posicion = `${row}${lettras[col - 1]}`;
            validar_movimientos.push(posicion);
        });
        sugerencias_de_golpeo(validar_movimientos);
        console.log(validar_movimientos);
        return validar_movimientos;
    }

    //Check if there is a piece on the bloque and if it is an enemy piece
    function fn_buscar_pieza(posicion, myColor) {
        const bloque = document.getElementById(posicion);
        if (bloque.innerText.length !== 0) {
            if (bloque.innerText[0] !== myColor) {
                return "pieza_enemiga";
            } else {
                return "mi_pieza";
            }
        } else {
            return "no_hay_pieza";
        }
    }

    //Give hints to the valid movimientos
    function sugerencias_de_golpeo(validar_movimientos) {
        validar_movimientos.forEach(move => {
            const bloque = document.getElementById(move);
            if (bloque.innerText.length !== 0) {
                bloque.classList.add('hintEat');
            } else {
                bloque.classList.add('hintMove');
            }
        });
    }


    function movimientos_de_la_maquina() {
        turno_de_la_maquina = true;
        const bloques = document.querySelectorAll('.bloque');
        const validar_movimientos = [];

        // Recolectar todos los movimientos válidos para la máquina
        bloques.forEach(bloque => {
            if (bloque.innerText.length !== 0 && bloque.innerText[0] === turno) {
                const nombre_de_la_piez = bloque.innerText.slice(1);
                const posicion = bloque.id;
                const movimientos = movimientos_de_golpeo(nombre_de_la_piez, posicion);
                validar_movimientos.push(...movimientos.map(move => [posicion, move]));
            }
        });

        // Seleccionar un movimiento aleatorio de los movimientos válidos
        const movimiento_random = validar_movimientos[Math.floor(Math.random() * validar_movimientos.length)];
        const posicion_actual = movimiento_random[0];
        const movimiento_futuro = movimiento_random[1];

        // Ejecutar el movimiento en la interfaz
        const bloque_actual = document.getElementById(posicion_actual);
        const bloque_futuro = document.getElementById(movimiento_futuro);
        const nombre_de_la_piez = bloque_actual.innerText.slice(1);

        bloque_futuro.innerText = nombre_de_la_piez;
        bloque_futuro.innerHTML =
            `${turno + nombre_de_la_piez}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turno + nombre_de_la_piez}.png" alt="${turno + nombre_de_la_piez}">`;
        bloque_futuro.style.cursor = 'pointer';

        bloque_actual.innerText = '';
        bloque_actual.style.cursor = 'default';

        // Verificar si hay ganador después del movimiento
        const resultado_ganador = fn_ganador();
        if (resultado_ganador === 1) {
            fn_alert("Ganan las Negras", true);
        } else if (resultado_ganador === 2) {
            fn_alert("Ganan las Blancas", true);
        } else {
            fn_toggle_turno();
            turno_de_la_maquina = false;
        }
    }


    //Moves the piece to the selected bloque
    function fn_mover_pieza(movimientos, nombre_de_la_piez, posicion) {
        if (modo_de_juego === "machine" && turno === "B") {
            // Si es el turno de la máquina, seleccionar un movimiento aleatorio de los movimientos válidos
            const random_index = Math.floor(Math.random() * movimientos.length);
            const movimiento_seleccionado = movimientos[random_index];
            const bloque_seleccionado = document.getElementById(movimiento_seleccionado);
            bloque_seleccionado.innerText = nombre_de_la_piez;
            bloque_seleccionado.innerHTML =
                `${turno + bloque_seleccionado.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turno + bloque_seleccionado.innerText}.png" alt="${turno + bloque_seleccionado.innerText}">`;
            bloque_seleccionado.style.cursor = 'pointer';

            const bloque_anterior = document.getElementById(posicion);
            bloque_anterior.innerText = "";
            bloque_anterior.style.cursor = "default";

            if (fn_ganador() === 1) {
                fn_alert("Ganan las Negras", true);
            } else if (fn_ganador() === 2) {
                fn_alert("Ganan las Blancas", true);
            } else {
                fn_toggle_turno();
            }
        } else {
            // Si no es el turno de la máquina, esperar al clic del usuario
            document.querySelectorAll('.bloque').forEach(bloque => {
                bloque.addEventListener('click', function() {
                    movimientos.forEach(move => {
                        if (bloque.id === move) {
                            bloque.innerText = nombre_de_la_piez;
                            bloque.innerHTML =
                                `${turno + bloque.innerText}<img class='img' src="/assets/imgs/Piezas_ajedrez/${turno + bloque.innerText}.png" alt="${turno + bloque.innerText}">`;
                            bloque.style.cursor = 'pointer';
                            const bloque_anterior = document.getElementById(posicion);
                            bloque_anterior.innerText = "";
                            bloque_anterior.style.cursor = "default";
                            if (fn_ganador() === 1) {
                                fn_alert("Ganan las Negras", true);
                            } else if (fn_ganador() === 2) {
                                fn_alert("Ganan las Blancas", true);
                            } else {
                                fn_toggle_turno();
                            }
                            movimientos = [];
                        } else {
                            movimientos = [];
                        }
                    });
                });
            });
        }
    }

    //Creates an fn_alert
    function fn_alert(text, end) {
        const alert = document.querySelector('.container-turno');
        alert.style.visibility = 'visible';
        alert.style.opacity = '1';

        const imgTurn = document.getElementById('imgTurn');
        if (text === "Turno Blancas" || text === "Ganan las Blancas") {
            imgTurn.src = "/assets/imgs/Piezas_ajedrez/Wking.png";
            imgTurn.alt = "Wking";
        } else {
            imgTurn.src = "/assets/imgs/Piezas_ajedrez/Bking.png";
            imgTurn.alt = "Bking";
        }

        const turnElement = document.getElementById('turno');
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

    //Toggles the turno
    function fn_toggle_turno() {
        if (turno === "W") {
            turno = "B";
            fn_alert("Turno Negras", false)
        } else {
            turno = "W";
            fn_alert("Turno Blancas", false)
        }
    }

    //Checks if there is a fn_ganador
    function fn_ganador() {
        let ganador_blancas = false;
        let ganador_negras = false;
        document.querySelectorAll('.bloque').forEach(bloque => {
            if (bloque.innerText === "Wking") {
                ganador_blancas = true;
            }
            if (bloque.innerText === "Bking") {
                ganador_negras = true;
            }
        });
        if (ganador_blancas === false) {
            return 1;
        } else if (ganador_negras === false) {
            return 2;
        }
    }
</script>
