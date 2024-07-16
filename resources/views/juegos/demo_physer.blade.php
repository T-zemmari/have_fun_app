<x-guest-layout>
    @section('title', 'Demo juego con Phaser')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100 mt-[20px]">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-10">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Demo juego con Phaser</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
            <button id="reset-btn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Restablecer</button>
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

        var game = new Phaser.Game(config);
        var score = 0;
        var scoreText;
        var gameOver = false;
        var player, cursors, stars, bombs;

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

            let platforms = this.physics.add.staticGroup();

            platforms.create(400, 568, 'barra').setScale(2).refreshBody();

            platforms.create(600, 400, 'barra');
            platforms.create(50, 250, 'barra');
            platforms.create(750, 220, 'barra');

            player = this.physics.add.sprite(100, 450, 'munieco');
            player.setCollideWorldBounds(true);
            player.setBounce(0.2);

            this.anims.create({
                key: 'left',
                frames: this.anims.generateFrameNumbers('munieco', {
                    start: 0,
                    end: 3
                }),
                frameRate: 10,
                repeat: -1,
            });
            this.anims.create({
                key: 'turn',
                frames: [{
                    key: 'munieco',
                    frame: 4
                }],
                frameRate: 20,
            });
            this.anims.create({
                key: 'right',
                frames: this.anims.generateFrameNumbers('munieco', {
                    start: 5,
                    end: 8
                }),
                frameRate: 10,
                repeat: -1,
            });

            this.physics.add.collider(player, platforms);
            cursors = this.input.keyboard.createCursorKeys();

            stars = this.physics.add.group({
                key: 'estrella',
                repeat: 11,
                setXY: {
                    x: 12,
                    y: 0,
                    stepX: 70
                }
            });

            stars.children.iterate(function(child) {
                child.setBounce(Phaser.Math.FloatBetween(0.4, 0.8));
            });

            this.physics.add.collider(stars, platforms);
            this.physics.add.overlap(player, stars, collectStar, null, this);

            scoreText = this.add.text(16, 16, 'Score: 0', {
                fontSize: '32px',
                fill: '#000'
            });

            bombs = this.physics.add.group();
            this.physics.add.collider(bombs, platforms);
            this.physics.add.collider(player, bombs, hitBomb, null, this);

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

        function collectStar(player, star) {
            star.disableBody(true, true);

            score += 10;
            scoreText.setText('Score: ' + score);

            if (stars.countActive(true) === 0) {
                stars.children.iterate(function(child) {
                    child.enableBody(true, child.x, 0, true, true);
                });

                var x = (player.x < 400) ? Phaser.Math.Between(400, 800) : Phaser.Math.Between(0, 400);
                var bomb = bombs.create(x, 16, 'bombita');
                bomb.setBounce(1);
                bomb.setCollideWorldBounds(true);
                bomb.setVelocity(Phaser.Math.Between(-200, 200), 20);
            }
        }

        function hitBomb(player, bomb) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
        }

        function resetGame(scene) {
            gameOver = false;
            score = 0;
            scoreText.setText('Score: ' + score);

            stars.children.iterate(function(child) {
                child.enableBody(true, child.x, 0, true, true);
            });

            bombs.clear(true, true);

            player.clearTint();
            player.setPosition(100, 450);
            player.anims.play('turn');

            scene.physics.resume();
        }
    });
</script>
