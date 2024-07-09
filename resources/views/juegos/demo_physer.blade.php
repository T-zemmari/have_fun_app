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
            physics: {
                default: 'arcade',
                arcade: {
                    gravity: {
                        y: 300
                    },
                    debug: false,
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

            this.load.spritesheet('munieco', munieco, {
                frameWidth: 32,
                frameHeight: 48
            });

        }

        function create() {
            this.add.image(400, 300, 'fondo');
            //this.add.image(400, 300, 'estrella');

            let platforms = this.physics.add.staticGroup();

            platforms.create(400, 568, 'barra').setScale(2).refreshBody();

            platforms.create(600, 400, 'barra');
            platforms.create(50, 250, 'barra');
            platforms.create(750, 220, 'barra');

            let player = this.physics.add.sprite(100, 450, 'munieco');
            player.setCollideWorldBounds(true);
            player.setBounce(0.2);

            this.anims.create({
                key: 'left',
                frame: this.anims.generateFrameNumbers('munieco', {
                    start: 0,
                    end: 3
                }),
                frameRate: 10,
                repeate: -1,
            });
            this.anims.create({
                key: 'turn',
                frame: [{
                    key: 'munieco',
                    frame: 4
                }],
                frameRate: 20,
            });
            this.anims.create({
                key: 'right',
                frame: this.anims.generateFrameNumbers('munieco', {
                    start: 5,
                    end: 8
                }),
                frameRate: 10,
                repeate: -1,
            });

            player.body.setGravityY(300);

            this.physics.add.collider(player,platforms)
        }

        function update() {}
    });
</script>
