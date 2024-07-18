<x-guest-layout>
    @section('title', 'Caza del Tesoro con Phaser')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100 mt-[20px]">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-10">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Caza del Tesoro con Phaser</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
            <button id="reset-btn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Restablecer</button>
        </div>
    </section>
</x-guest-layout>

<script src="{{ asset('assets/js/phaser.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fondo = "{{ asset('assets/imgs/treasure_hunt/background.png') }}";
        const tesoro = "{{ asset('assets/imgs/treasure_hunt/treasure.png') }}";
        const trampa = "{{ asset('assets/imgs/treasure_hunt/trap.png') }}";
        const plataforma = "{{ asset('assets/imgs/treasure_hunt/platform.png') }}";
        const jugador = "{{ asset('assets/imgs/treasure_hunt/player.png') }}";

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

        var game = new Phaser.Game(config);
        var score = 0;
        var scoreText;
        var gameOver = false;
        var player, cursors, treasures, traps;

        function preload() {
            this.load.image('fondo', fondo);
            this.load.image('tesoro', tesoro);
            this.load.image('plataforma', plataforma);
            this.load.image('trampa', trampa);

            this.load.spritesheet('jugador', jugador, {
                frameWidth: 32,
                frameHeight: 48
            });
        }

        function create() {
            this.add.image(400, 300, 'fondo');

            let platforms = this.physics.add.staticGroup();
            platforms.create(400, 568, 'plataforma').setScale(2).refreshBody();
            platforms.create(600, 400, 'plataforma');
            platforms.create(50, 250, 'plataforma');
            platforms.create(750, 220, 'plataforma');

            player = this.physics.add.sprite(100, 450, 'jugador');
            player.setCollideWorldBounds(true);
            player.setBounce(0.2);

            this.anims.create({
                key: 'left',
                frames: this.anims.generateFrameNumbers('jugador', {
                    start: 0,
                    end: 3
                }),
                frameRate: 10,
                repeat: -1
            });
            this.anims.create({
                key: 'turn',
                frames: [{
                    key: 'jugador',
                    frame: 4
                }],
                frameRate: 20
            });
            this.anims.create({
                key: 'right',
                frames: this.anims.generateFrameNumbers('jugador', {
                    start: 5,
                    end: 8
                }),
                frameRate: 10,
                repeat: -1
            });

            this.physics.add.collider(player, platforms);
            cursors = this.input.keyboard.createCursorKeys();

            treasures = this.physics.add.group({
                key: 'tesoro',
                repeat: 11,
                setXY: {
                    x: 12,
                    y: 0,
                    stepX: 70
                }
            });
            treasures.children.iterate(child => {
                child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
            });
            this.physics.add.collider(treasures, platforms);
            this.physics.add.overlap(player, treasures, collectTreasure, null, this);

            traps = this.physics.add.group();
            createTraps(this);

            scoreText = this.add.text(16, 16, 'Score: 0', {
                fontSize: '32px',
                fill: '#000'
            });

            this.physics.add.collider(player, traps, hitTrap, null, this);

            document.getElementById('reset-btn').addEventListener('click', () => resetGame(this));
        }

        function update() {
            if (gameOver) {
                return;
            }

            if (cursors.left.isDown) {
                player.setVelocityX(-150);
                player.anims.play('left', true);
            } else if (cursors.right.isDown) {
                player.setVelocityX(150);
                player.anims.play('right', true);
            } else {
                player.setVelocityX(0);
                player.anims.play('turn');
            }

            if (cursors.up.isDown && player.body.touching.down) {
                player.setVelocityY(-330);
            }
        }

        function createTraps(scene) {
            for (let i = 0; i < 5; i++) {
                const trap = traps.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 300), 'trampa');
                trap.setCollideWorldBounds(true);

                // Añadir temporizador para desactivar la trampa después de un rato
                scene.time.addEvent({
                    delay: 5000, // tiempo en milisegundos (5 segundos)
                    callback: () => {
                        trap.disableBody(true, true);
                    },
                    callbackScope: scene
                });
            }
        }

        function collectTreasure(player, treasure) {
            treasure.disableBody(true, true);
            score += 10;
            scoreText.setText('Score: ' + score);

            if (treasures.countActive(true) === 0) {
                treasures.children.iterate(child => {
                    child.enableBody(true, child.x, 0, true, true);
                });

                createTraps(this);
            }
        }

        function hitTrap(player, trap) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
        }

        function resetGame(scene) {
            gameOver = false;
            score = 0;
            scoreText.setText('Score: ' + score);

            treasures.children.iterate(child => {
                child.enableBody(true, child.x, 0, true, true);
            });

            traps.clear(true, true);
            createTraps(scene);

            player.clearTint();
            player.setPosition(100, 450);
            player.anims.play('turn');

            scene.physics.resume();
        }
    });
</script>
