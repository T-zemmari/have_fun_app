<x-guest-layout>
    @section('title', 'Juego de Memoria')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-[60px]">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-h-[780px] max-w-4xl p-8 bg-white shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Juego de Memoria</h1>

            <div id="gameBoard" class="grid grid-cols-4 gap-4 max-w-lg mx-auto mb-8"></div>

            <button id="startGameBtn" class="btn-action">Comenzar Juego</button>
            <div class="w-full flex justify-center items-center " id="resetBtn" style="display: none">
                <a href="{{ route('memo_1') }}" 
                    class=" w-[150px] text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Resetear</a>
            </div>
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

    .card {
        width: 100px;
        height: 140px;
        background-color: #2b6cb0;
        color: transparent;
        /* Hacer el texto transparente por defecto */
        font-size: 48px;
        /* Aumentar el tamaño del texto para que los emojis sean visibles */
        text-align: center;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .card.flipped {
        background-color: #2c5282;
        color: white;
        /* Mostrar texto blanco cuando la carta está volteada */
    }

    .card.matched {
        background-color: #38a169;
        cursor: default;
    }

    .game-complete {
        text-align: center;
        margin-top: 20px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #38a169;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const gameBoard = document.getElementById('gameBoard');
        const startGameBtn = document.getElementById('startGameBtn');
        const cards = ['🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓']; // Pares de cartas

        let firstCard = null;
        let secondCard = null;
        let flippedCards = [];
        let matchedCards = [];

        // Generar cartas aleatorias
        function generateCards() {
            const shuffledCards = [...cards, ...cards].sort(() => Math.random() - 0.5);

            gameBoard.innerHTML = '';
            flippedCards = [];
            matchedCards = [];

            shuffledCards.forEach(card => {
                const cardElement = document.createElement('div');
                cardElement.classList.add('card');
                cardElement.innerHTML = '<span class="hidden">' + card +
                    '</span>'; // Emojis dentro de un span oculto
                cardElement.addEventListener('click', () => flipCard(cardElement));
                gameBoard.appendChild(cardElement);
            });
        }

        // Voltear carta
        function flipCard(card) {
            if (card.classList.contains('flipped') || card.classList.contains('matched')) {
                return;
            }

            card.classList.add('flipped');
            card.querySelector('span').classList.remove('hidden'); // Mostrar el emoji al voltear
            flippedCards.push(card);

            if (flippedCards.length === 2) {
                checkMatch();
            }
        }

        // Comprobar si hay coincidencia
        function checkMatch() {
            firstCard = flippedCards[0].querySelector('span').textContent;
            secondCard = flippedCards[1].querySelector('span').textContent;

            if (firstCard === secondCard) {
                flippedCards.forEach(card => card.classList.add('matched'));
                matchedCards.push(...flippedCards);
                flippedCards = [];

                if (matchedCards.length === cards.length * 2) {
                    setTimeout(() => {
                        Swal.fire({
                            title: '¡Felicitaciones!',
                            text: 'Has encontrado todos los pares. ¡Juego completado!',
                            icon: 'success',
                            confirmButtonText: 'Reiniciar Juego'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                generateCards();
                            }
                        });
                    }, 500);
                }
            } else {
                setTimeout(() => {
                    flippedCards.forEach(card => {
                        card.classList.remove('flipped');
                        card.querySelector('span').classList.add(
                            'hidden'); // Ocultar el emoji no coincidente
                    });
                    flippedCards = [];
                }, 1000);
            }
        }

        // Evento para comenzar juego
        startGameBtn.addEventListener('click', () => {
            generateCards();
            $(`#resetBtn`).toggle();
            $(`#startGameBtn`).toggle();
        });
    });
</script>
