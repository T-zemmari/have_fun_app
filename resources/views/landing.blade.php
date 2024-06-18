<x-guest-layout>
    @section('title', 'HaveFun - Página de inicio')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen"
        style="background: radial-gradient(circle at 24.1% 68.8%, rgb(50, 50, 50) 0%, rgb(0, 0, 0) 99.4%);">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-5 mt-[145px]">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none md:text-5xl xl:text-6xl text-white">
                    HaveFun</h1>
                <p class="max-w-2xl mb-6 font-light text-white lg:mb-8 md:text-lg lg:text-xl">
                    Bienvenido a HAVE FUN, el lugar perfecto para todos los apasionados de los juegos casuales. 
                </p>
                <p class="max-w-2xl mb-6 font-light text-white lg:mb-8 md:text-lg lg:text-xl">
                    Aquí podrás jugar a tus juegos favoritos como Tetris, juegos de memoria y muchos más. Descubre nuevos títulos y disfruta de horas de entretenimiento en un solo lugar.
                </p>
                <a href="{{ route('tetris_one') }}"
                    class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                    Jugar Ahora
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-[50px] lg:col-span-7 lg:flex lg:mt-[200px] flex justify-end items-center">
                <video src="{{ asset('assets/vids/tetris_vid_2.mp4') }}" autoplay loop muted
                    class="rounded-lg shadow-lg"></video>
            </div>
        </div>
    </section>
</x-guest-layout>
