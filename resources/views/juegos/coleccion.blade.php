<x-guest-layout>
    @section('title', 'HAVEFUN - Coleccion')
    @include('layouts.partials.navbar')

    <section class="w-full min-h-screen flex justify-center">

        <div class="w-full md:p-10 max-w-7xl flex flex-row flex-wrap justify-start items-start mt-[10em] gap-4">
            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('tetris_one') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/tetris_1.png') }}" alt="tetris_1" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('tetris_one') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Tetris</h5>
                    </a>

                    <div class="w-full flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('tetris_one') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>

            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('ajedrez') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/chess_1.png') }}" alt="chess_1" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('ajedrez') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Ajedrez</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('ajedrez') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>

            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('sudoku_one') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/img_sudoku/sudoku_1.png') }}" alt="sudoku_1" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('sudoku_one') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Sudoku</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('sudoku_one') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>

            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('memo_1') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/img_memo_1/memo_1.png') }}" alt="memo_1" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('memo_1') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Memo 1</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('memo_1') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>

            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('damas') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/img_damas/damas_1.png') }}" alt="damas" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('damas') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Damas</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('damas') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>


            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('demo_physer') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/img_physer/img_1.png') }}" alt="img4" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('demo_physer') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Physer demo</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('demo_physer') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>

            <div
                class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                <a href="{{ route('bullet_game') }}" class="h-[200px]">
                    <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                        src="{{ asset('assets/imgs/img_bullet_game/img_1.png') }}" alt="img4" />
                </a>
                <div class="w-full px-5 pb-5 h-[100px]">
                    <a href="{{ route('bullet_game') }}">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Physer demo</h5>
                    </a>

                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                        <a href="{{ route('bullet_game') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</x-guest-layout>
