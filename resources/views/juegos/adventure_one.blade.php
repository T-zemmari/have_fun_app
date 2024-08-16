<x-guest-layout>
    @section('title', 'Adventure one')
    @include('layouts.partials.navbar')

    <section class="w-full h-screen flex flex-col justify-center items-center bg-gray-100 mt-[20px]">
        <div class="w-[100%] max-w-4xl flex justify-start items-center mt-10">
            @include('layouts.partials.menu_nav')
        </div>
        <div class="w-full max-w-4xl p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Adventure one</h1>
            <div id="phaser-game" style="width: 800px; height: 600px;"></div>
            <button id="reset-btn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Restablecer</button>
            <button id="next-level-btn" class="mt-4 px-4 py-2 bg-green-500 text-white rounded"
                style="display: none;">Siguiente Nivel</button>
        </div>
    </section>
</x-guest-layout>

<script src="{{ asset('assets/js/phaser.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let levelCompleted = false;
        let userId = "{{ $user_id }}";
        let gameId = "{{ $gameId }}";
        let scoreDb = parseInt("{{ $score }}") || 0;
        let currentLevelDb = parseInt("{{ $currentLevel }}") || 1;

        localStorage.setItem('currentLevel', currentLevelDb);
        localStorage.setItem('score', scoreDb);

        console.log('user_id', userId);
        console.log('gameId', gameId);

        let background_img = "{{ asset('assets/imgs/adventure_one/sky.png') }}";
        let ground = "{{ asset('assets/imgs/adventure_one/background_2.png') }}";
        let dude = "{{ asset('assets/imgs/adventure_one/player.png') }}";
        let treasure = "{{ asset('assets/imgs/adventure_one/treasure.png') }}";
        let bomb = "{{ asset('assets/imgs/adventure_one/bomb.png') }}";
        let star = "{{ asset('assets/imgs/adventure_one/star.png') }}";
        let bullet = "{{ asset('assets/imgs/adventure_one/bullet_2.png') }}";

        let nube_1 = "{{ asset('assets/imgs/adventure_one/nubes/nube_1.png') }}";
        let nube_6 = "{{ asset('assets/imgs/adventure_one/nubes/nube_6.png') }}";

        let array_nubes = [nube_1, nube_6];

        currentLevel = parseInt(localStorage.getItem('currentLevel')) || 1;
        score = parseInt(localStorage.getItem('score')) || 0;

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
        let scoreText;
        let levelText;

        let player, cursors, groundLayer, background, clouds, stars, bombs, bullets;
        let lastFired = 0;
        let levelWidth = 10000;

        function preload() {
            this.load.image('background', background_img);
            this.load.image('ground', ground);
            this.load.spritesheet('dude', dude, {
                frameWidth: 32,
                frameHeight: 48
            });
            this.load.image('star', star);
            this.load.image('bomb', bomb);
            this.load.image('treasure', treasure);
            this.load.image('bullet', bullet);

            array_nubes.forEach((nube, index) => {
                this.load.image('nube_' + index, nube);
            });
        }

        function create() {
            background = this.add.tileSprite(0, 0, config.width, config.height, 'background').setOrigin(0, 0)
                .setScrollFactor(0);
            this.cameras.main.setBounds(0, 0, levelWidth, config.height);
            this.physics.world.setBounds(0, 0, levelWidth, config.height);

            groundLayer = this.physics.add.staticGroup();
            for (let i = 0; i <= levelWidth; i += 64) {
                groundLayer.create(i, 568, 'ground').setScale(2).refreshBody();
            }

            let platformGraphics = this.add.graphics();
            let platforms = this.physics.add.staticGroup();

            const platformData = [{
                    id: "platform_1723796671477",
                    x: 131,
                    y: 465,
                    width: 400,
                    height: 32
                },
                {
                    id: "platform_1723796691798",
                    x: 506,
                    y: 364,
                    width: 200,
                    height: 32
                },
                {
                    id: "platform_1723796702728",
                    x: 730,
                    y: 262,
                    width: 150,
                    height: 32
                },
                {
                    id: "platform_1723796723707",
                    x: 987,
                    y: 213,
                    width: 100,
                    height: 32
                }
            ];

            platformData.forEach(data => {
                // Dibujar la plataforma usando gráficos
                platformGraphics.fillStyle(0x0000ff, 1); // Color de la plataforma (azul)
                platformGraphics.fillRect(data.x, data.y, data.width, data.height);

                // Añadir la plataforma al grupo de plataformas físicas
                platforms.create(data.x + data.width / 2, data.y + data.height / 2, null)
                    .setSize(data.width, data.height)
                    .setOrigin(0.5, 0.5)
                    .refreshBody();
            });

            player = this.physics.add.sprite(100, 450, 'dude');
            player.setBounce(0.2);
            player.setCollideWorldBounds(true);

            bullets = this.physics.add.group({
                defaultKey: 'bullet',
                maxSize: 100,
                physics: {
                    gravity: {
                        y: 0
                    }
                }
            });

            this.input.keyboard.on('keydown-SPACE', shootBullet, this);

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

            cursors = this.input.keyboard.createCursorKeys();

            stars = this.physics.add.group({
                key: 'star',
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

            this.physics.add.overlap(player, stars, collectStar, null, this);

            bombs = this.physics.add.group();

            configureLevel.call(this, currentLevel);

            this.physics.add.collider(player, groundLayer);
            this.physics.add.collider(stars, groundLayer);
            this.physics.add.collider(bullets, bombs, destroyBomb, null, this);
            this.physics.add.collider(bombs, groundLayer);
            this.physics.add.collider(player, platforms);


            let minDistanceX = 200;
            let minDistanceY = 50;
            let minY = 50;
            let maxY = 158;
            let positions = [];

            for (let x = 0; x <= levelWidth; x += minDistanceX) {
                for (let y = minY; y <= maxY; y += minDistanceY) {
                    positions.push({
                        x,
                        y
                    });
                }
            }

            Phaser.Utils.Array.Shuffle(positions);

            clouds = this.add.group();

            for (let i = 0; i < 10; i++) {
                let randomIndex = Phaser.Math.Between(0, array_nubes.length - 1);
                let pos = positions[i];
                if (pos) {
                    let cloud = this.add.image(pos.x, pos.y, 'nube_' + randomIndex);
                    cloud.setScrollFactor(0);
                    clouds.add(cloud);
                }
            }

            this.cameras.main.startFollow(player, true, 0.08, 0.08);
            this.cameras.main.setDeadzone(this.scale.width / 4, this.scale.height / 4);

            scoreText = this.add.text(16, 16, 'Score: ' + score, {
                fontSize: '32px',
                fill: '#000'
            }).setScrollFactor(0);

            levelText = this.add.text(16, 60, 'Nivel: ' + currentLevel, {
                fontSize: '32px',
                fill: '#000'
            }).setScrollFactor(0);
        }

        function configureLevel(level) {
            if (level < 1) {
                console.error('Nivel no válido:', level);
                return;
            }

            let bombsCount = 5 + (level - 1) * 2; // Incrementar el número de bombas por nivel
            let speed = 200 + (level - 1) * 50; // Incrementar la velocidad de las bombas por nivel

            bombs.clear(true, true); // Limpiar bombas existentes

            for (let i = 0; i < bombsCount; i++) {
                let x = Phaser.Math.Between(0, levelWidth);
                let y = Phaser.Math.Between(0, config.height - 64);
                let bomb = bombs.create(x, y, 'bomb');
                bomb.setBounce(1);
                bomb.setCollideWorldBounds(true);
                bomb.setVelocity(Phaser.Math.Between(-speed, speed), 20);
                bomb.allowGravity = false;
            }
        }

        function shootBullet() {
            if (this.time.now - lastFired > 200) {
                let bullet = bullets.get();
                if (bullet) {
                    bullet.setActive(true).setVisible(true);
                    bullet.setPosition(player.x, player.y - 20);
                    bullet.setVelocityY(-800); // Disparo hacia arriba
                    bullet.body.gravity.y = 0; // Asegúrate de que no haya gravedad
                    bullet.setCollideWorldBounds(false); // No hacer colisiones con los límites del mundo
                    bullet.setBounce(0); // No hacer rebote
                    // Destruir la bala después de 1 segundo
                    this.time.delayedCall(1000, () => {
                        bullet.setActive(false).setVisible(false); // Ocultar y desactivar la bala
                        bullet.setPosition(-100, -100); // Mover la bala fuera de la pantalla
                    });
                    lastFired = this.time.now;
                }
            }
        }


        function update() {
            if (!levelCompleted) {
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

                stars.children.iterate(child => {
                    if (child.y > config.height) {
                        child.setY(0);
                        child.setX(Phaser.Math.Between(0, levelWidth));
                    }
                });

                if (bombs.getLength() === 0) {
                    levelCompleted = true;
                    document.getElementById('next-level-btn').style.display = 'block';
                }
            }
        }

        function collectStar(player, star) {
            star.disableBody(true, true);
            score += 10;
            scoreText.setText('Score: ' + score);
        }

        function destroyBomb(bullet, bomb) {
            bullet.disableBody(true, true);
            bomb.disableBody(true, true);
        }

        document.getElementById('reset-btn').addEventListener('click', () => {
            location.reload();
        });

        document.getElementById('next-level-btn').addEventListener('click', () => {
            if (levelCompleted) {
                currentLevel++;
                localStorage.setItem('currentLevel', currentLevel);
                configureLevel.call(game.scene.getScene('default'), currentLevel);
                levelText.setText('Nivel: ' + currentLevel);
                levelCompleted = false;
                document.getElementById('next-level-btn').style.display = 'none';
            }
        });
    });
</script>
