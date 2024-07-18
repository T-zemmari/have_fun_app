<x-guest-layout>
    @section('title', 'HaveFun - Página de inicio')
    @include('layouts.partials.navbar')

    <section class="h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">Bienvenido a</span>
                    <span class="block text-indigo-600 xl:inline">HaveFun</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    HaveFun es tu destino para disfrutar de juegos sencillos y divertidos como Tetris y muchos más. 
                    Disfruta de horas de entretenimiento de manera gratuita. Algunos juegos requieren que tengas una cuenta y estés logueado para jugar.
                </p>
                <div class="mt-5 max-w-md mx-auto flex justify-center md:mt-8">
                    @guest
                        <div class="rounded-md shadow">
                            <a href="{{ route('register') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                Regístrate
                            </a>
                        </div>
                        <div class="ml-3 rounded-md shadow">
                            <a href="{{ route('login') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                Inicia Sesión
                            </a>
                        </div>
                    @else
                        <div class="rounded-md shadow">
                            <a href="{{ route('coleccion') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                Ir a la colección de juegos
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
