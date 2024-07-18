<x-guest-layout>
    @section('title', 'HAVEFUN - Coleccion')
    @include('layouts.partials.navbar')

    <section class="w-full min-h-screen flex justify-center">

        <div class="w-full md:p-10 max-w-7xl flex flex-row flex-wrap justify-start items-start mt-[10em] gap-4">
            @foreach ($games as $game)
                @php
                    $ruta = route($game['route_name']);
                @endphp
                @if ($game['show_in_web'] == 1 && $ruta && file_exists(public_path($game['url_img'])))
                    <div
                        class="card_game w-[350px] h-[300px] bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-center items-center">
                        <a href="{{ $ruta }}" class="h-[200px]">
                            <img class="p-8 rounded-t-lg w-[100%] h-[100%] object-cover"
                                src="{{ asset($game['url_img']) }}" alt="{{ $game['nombre'] }}" />
                        </a>
                        <div class="w-full px-5 pb-5 h-[100px]">
                            <a href="{{ $ruta }}">
                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    {{ $game['name'] }}</h5>
                            </a>

                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">Gratis</span>
                                <a href="{{ $ruta }}"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jugar</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </section>

</x-guest-layout>
