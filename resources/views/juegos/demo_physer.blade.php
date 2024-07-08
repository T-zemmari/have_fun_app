<x-guest-layout>
    @section('title', 'Demo juego con Phaser')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Demo juego con Phaser</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
        </div>
    </section>
</x-guest-layout>

<script src="{{ asset('assets/js/phaser.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const fondo = "{{ asset('assets/imgs/img_physer/sky.png') }}";
        const estrella = "{{ asset('assets/imgs/img_physer/star.png') }}";
        const barra = "{{ asset('assets/imgs/img_physer/platform.png') }}";
        const munieco = "{{ asset('assets/imgs/img_physer/dude.png') }}";
        const bombita = "{{ asset('assets/imgs/img_physer/bomb.png') }}";

        const config = {
            type: Phaser.AUTO,
            width: 800,
            height: 600,
            physics:{
                default:'arcade',
                arcade:{
                    gravity:{y:300},
                    debug:false,
                }

            },
            parent: 'phaser-game',
            scene: {
                preload: preload,
                create: create,
                update: update
            }
        };

        let game = new Phaser.Game(config);

        function preload() {
            this.load.image('fondo', fondo);
            this.load.image('estrella', estrella);
            this.load.image('barra', barra);
            this.load.image('bombita', bombita);

            this.load.spritesheet('munieco', munieco,{frameWidth:32,frameHeight:48});

        }

        function create() {
            this.add.image(400, 300, 'fondo');
            //this.add.image(400, 300, 'estrella');

            let platforme=this.physics.add.staticGroup();

            platforme.create(400,568,'barra').setScale(2).refreshBody();

            platforme.create(600,400,'barra');
            platforme.create(50,250,'barra');
            platforme.create(750,220,'barra');
        }

        function update() {
        }
    });
</script>
