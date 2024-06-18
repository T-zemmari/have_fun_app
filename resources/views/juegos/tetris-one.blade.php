<x-guest-layout>
    @section('title', 'HAVE FUN - Juegos tetris One')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen">
        <div class="w-full h-[100%] flex flex-col justify-center items-center">
            <canvas id="canva_tetris_one" width="300" height="600"></canvas>
            <div id="score_tetris_one">0</div>
        </div>
    </section>

</x-guest-layout>
