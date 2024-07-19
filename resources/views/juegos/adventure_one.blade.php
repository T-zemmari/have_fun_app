<x-guest-layout>
    @section('title', 'Fake Mario')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100 mt-[20px]">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-10">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Adventure one</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
            <button id="reset-btn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Restablecer</button>
        </div>
    </section>
</x-guest-layout>

<script src="{{ asset('assets/js/phaser.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let background_img = "{{ asset('assets/imgs/adventure_one/sky.png') }}";
        let ground = "{{ asset('assets/imgs/adventure_one/ground.png') }}";
        let dude = "{{ asset('assets/imgs/adventure_one/player.png') }}";

        let nube_1 = "{{ asset('assets/imgs/adventure_one/nubes/nube_1.png') }}";
        let nube_2 = "{{ asset('assets/imgs/adventure_one/nubes/nube_2.png') }}";
        let nube_3 = "{{ asset('assets/imgs/adventure_one/nubes/nube_3.png') }}";
        let nube_4 = "{{ asset('assets/imgs/adventure_one/nubes/nube_4.png') }}";
        let nube_5 = "{{ asset('assets/imgs/adventure_one/nubes/nube_5.png') }}";
        let nube_6 = "{{ asset('assets/imgs/adventure_one/nubes/nube_6.png') }}";

        let array_nubes = [nube_1, nube_2, nube_3, nube_4, nube_5, nube_6];

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
                    debug: false
                }
            },
            parent: 'phaser-game',
            scene: {
                preload: preload,
                create: create,
                update: update
            }
        };

        const game = new Phaser.Game(config);

        let player;
        let cursors;
        let groundLayer;
        let background;
        let clouds;

        function preload() {
            this.load.image('background', background_img);
            this.load.image('ground', ground);
            this.load.spritesheet('dude', dude, {
                frameWidth: 32,
                frameHeight: 48
            });

            array_nubes.forEach((nube, index) => {
                this.load.image('nube_' + index, nube);
            });
        }

        function create() {
            // Fondo del juego (crea un tile sprite para que se repita)
            background = this.add.tileSprite(0, 0, 800, 600, 'background').setOrigin(0, 0).setScrollFactor(0);

            // Crear un mundo más ancho que la pantalla
            this.cameras.main.setBounds(0, 0, 1600, 600);
            this.physics.world.setBounds(0, 0, 1600, 600);

            // Suelo
            groundLayer = this.physics.add.staticGroup();
            groundLayer.create(400, 568, 'ground').setScale(2).refreshBody();
            groundLayer.create(1200, 568, 'ground').setScale(2).refreshBody();

            // Jugador
            player = this.physics.add.sprite(100, 450, 'dude');
            player.setBounce(0.2);
            player.setCollideWorldBounds(true);

            this.anims.create({
                key: 'left',
                frames: this.anims.generateFrameNumbers('dude', {
                    start: 0,
                    end: 3
                }),
                frameRate: 10,
                repeat: -1
            });

            this.anims.create({
                key: 'turn',
                frames: [{
                    key: 'dude',
                    frame: 4
                }],
                frameRate: 20
            });

            this.anims.create({
                key: 'right',
                frames: this.anims.generateFrameNumbers('dude', {
                    start: 5,
                    end: 8
                }),
                frameRate: 10,
                repeat: -1
            });

            this.physics.add.collider(player, groundLayer);

            cursors = this.input.keyboard.createCursorKeys();

            // Generar posiciones válidas para las nubes
            let minDistanceX = 300; // Distancia mínima en X
            let minDistanceY = 50; // Distancia mínima en Y
            let positions = [];

            // Crear una cuadrícula de posiciones válidas
            for (let x = 0; x <= 1600; x += minDistanceX) {
                for (let y = 100; y <= 300; y += minDistanceY) {
                    positions.push({
                        x,
                        y
                    });
                }
            }

            // Barajar las posiciones
            Phaser.Utils.Array.Shuffle(positions);

            // Crear las nubes usando posiciones pre-calculadas
            clouds = this.add.group();

            for (let i = 0; i < 10; i++) {
                let randomIndex = Phaser.Math.Between(0, array_nubes.length - 1);
                let pos = positions[i]; // Seleccionar una posición pre-calculada

                if (pos) {
                    let cloud = this.add.image(pos.x, pos.y, 'nube_' + randomIndex);
                    cloud.setScrollFactor(0);
                    clouds.add(cloud);
                }
            }

            // Hacer que la cámara siga al jugador
            this.cameras.main.startFollow(player);
            this.cameras.main.setDeadzone(this.scale.width * 1.5, this.scale.height);
        }


        function update() {
            if (cursors.left.isDown) {
                player.setVelocityX(-160);
                player.anims.play('left', true);
            } else if (cursors.right.isDown) {
                player.setVelocityX(160);
                player.anims.play('right', true);
            } else {
                player.setVelocityX(0);
                player.anims.play('turn');
            }

            if (cursors.up.isDown && player.body.touching.down) {
                player.setVelocityY(-330);
            }

            // Mover el fondo para que siga al jugador y se repita
            background.tilePositionX = this.cameras.main.scrollX * 0.5;

            // Mover las nubes lentamente
            clouds.children.iterate(function(child) {
                child.x += 0.5;
                if (child.x > 1600) {
                    child.x = -child.width;
                }
            });
        }
    });
</script>
