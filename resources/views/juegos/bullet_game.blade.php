<x-guest-layout>
    @section('title', 'Juego Mejorado con Phaser')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-10">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Juego Mejorado con Phaser</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
            <button id="reset-btn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Restablecer</button>
        </div>
    </section>
</x-guest-layout>

<script src="{{ asset('assets/js/phaser.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fondo = "{{ asset('assets/imgs/img_bullet_game/background_3.png') }}";
        const estrella = "{{ asset('assets/imgs/img_bullet_game/star.png') }}";
        const plataforma = "{{ asset('assets/imgs/img_bullet_game/platform.png') }}";
        const jugador = "{{ asset('assets/imgs/img_bullet_game/player.png') }}";
        const enemigo = "{{ asset('assets/imgs/img_bullet_game/enemy_1.png') }}";
        const bala = "{{ asset('assets/imgs/img_bullet_game/bullet_3.png') }}";

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
        var player, cursors, stars, enemies, bullets;

        function preload() {
            this.load.image('fondo', fondo);
            this.load.image('estrella', estrella);
            this.load.image('plataforma', plataforma);
            this.load.image('enemigo', enemigo);
            this.load.image('bala', bala);

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
            this.input.keyboard.on('keydown-SPACE', shoot, this);

            stars = this.physics.add.group({
                key: 'estrella',
                repeat: 11,
                setXY: {
                    x: 12,
                    y: 0,
                    stepX: 70
                }
            });
            stars.children.iterate(child => {
                child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
            });
            this.physics.add.collider(stars, platforms);
            this.physics.add.overlap(player, stars, collectStar, null, this);

            enemies = this.physics.add.group();
            createEnemies(this);

            bullets = this.physics.add.group({
                classType: Phaser.Physics.Arcade.Image,
                defaultKey: 'bala',
                maxSize: 10
            });

            scoreText = this.add.text(16, 16, 'Score: 0', {
                fontSize: '32px',
                fill: '#000'
            });

            this.physics.add.collider(enemies, platforms);
            this.physics.add.collider(player, enemies, hitEnemy, null, this);
            this.physics.add.collider(bullets, enemies, destroyEnemy, null, this);
            this.physics.add.collider(bullets, platforms, destroyBullet, null, this);

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

            bullets.children.each(bullet => {
                if (bullet.active && bullet.y < 0) {
                    bullet.disableBody(true, true);
                }
            });
        }

        function shoot() {
            const bullet = bullets.get(player.x, player.y - 25); // Ajustamos la posición inicial para que salga desde la cabeza

            if (bullet) {
                bullet.enableBody(true, bullet.x, bullet.y, true, true);
                bullet.setActive(true);
                bullet.setVisible(true);
                bullet.body.velocity.y = -400; // La bala siempre se moverá hacia arriba

                this.time.addEvent({
                    delay: 2000,
                    callback: () => {
                        bullet.disableBody(true, true);
                    },
                    callbackScope: this
                });
            }
        }

        function createEnemies(scene) {
            for (let i = 0; i < 2; i++) {
                const enemy = enemies.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 300), 'enemigo');
                enemy.setBounce(1);
                enemy.setCollideWorldBounds(true);
                enemy.setVelocity(Phaser.Math.Between(-200, 200), 20);
            }
        }

        function collectStar(player, star) {
            star.disableBody(true, true);
            score += 10;
            scoreText.setText('Score: ' + score);

            if (stars.countActive(true) === 0) {
                stars.children.iterate(child => {
                    child.enableBody(true, child.x, 0, true, true);
                });

                createEnemies(this);
            }
        }

        function hitEnemy(player, enemy) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
        }

        function destroyEnemy(bullet, enemy) {
            bullet.disableBody(true, true);
            enemy.disableBody(true, true);
            score += 20;
            scoreText.setText('Score: ' + score);
        }

        function destroyBullet(bullet, platform) {
            bullet.disableBody(true, true);
        }

        function resetGame(scene) {
            gameOver = false;
            score = 0;
            scoreText.setText('Score: ' + score);

            stars.children.iterate(child => {
                child.enableBody(true, child.x, 0, true, true);
            });

            enemies.clear(true, true);
            createEnemies(scene);

            bullets.clear(true, true);

            player.clearTint();
            player.setPosition(100, 450);
            player.anims.play('turn');

            scene.physics.resume();
        }
    });
</script>
