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
        let trap = "{{ asset('assets/imgs/adventure_one/trap.png') }}";
        let platform = "{{ asset('assets/imgs/adventure_one/platform.png') }}";
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

        let player, cursors, groundLayer, background, clouds, stars, bombs, traps, platforms, bullets;
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
            this.load.image('trap', trap);
            this.load.image('platform', platform);
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

            player = this.physics.add.sprite(100, 450, 'dude');
            player.setBounce(0.2);
            player.setCollideWorldBounds(true);

            platforms = this.physics.add.staticGroup();


            bullets = this.physics.add.group({
                defaultKey: 'bullet',
                maxSize: 10
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



            traps = this.physics.add.group();
            bombs = this.physics.add.group();

            configureLevel.call(this, currentLevel);

            this.physics.add.collider(player, platforms);
            this.physics.add.collider(stars, platforms);
            this.physics.add.collider(stars, groundLayer);
            this.physics.add.collider(player, groundLayer);
            this.physics.add.collider(bullets, bombs, destroyBomb, null, this);
            this.physics.add.collider(bombs, groundLayer);
            this.physics.add.collider(bombs, platforms);
            this.physics.add.collider(traps, platforms)
            this.physics.add.collider(player, bombs, hitBomb, null, this);
            this.physics.add.collider(player, traps, hitTrap, null, this);

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


        const levelConfigurations = [
            // Configuración para el nivel 1
            {
                platforms: [ { x: 400, y: 400 },
                 { x: 700, y: 250 },
                 { x: 1200, y: 100 },
                 { x: 1600, y: 300 },
                 { x: 1850, y: 450 },
                 { x: 2500, y: 200 },
                 { x: 3200, y: 300 },
                 { x: 3800, y: 150 },
                 { x: 4400, y: 400 },
                 { x: 5000, y: 250 },
                 { x: 5800, y: 350 },
                 { x: 6400, y: 100 },
                 { x: 7000, y: 300 },
                 { x: 7600, y: 450 },
                 { x: 8200, y: 200 },
                 { x: 8800, y: 300 },
                 { x: 9400, y: 150 },
                 { x: 10000, y: 400 }
                     ],
                traps: [{
                        x: 300,
                        y: 350
                    },
                    {
                        x: 500,
                        y: 250
                    }
                ]
            },
            // Configuración para el nivel 2
            {
                platforms: [{
                        x: 150,
                        y: 250
                    },
                    {
                        x: 350,
                        y: 200
                    },
                    {
                        x: 550,
                        y: 150
                    },
                    {
                        x: 750,
                        y: 100
                    }
                ],
                traps: [{
                        x: 400,
                        y: 270
                    },
                    {
                        x: 600,
                        y: 220
                    }
                ]
            },
            // ... agrega configuraciones para niveles hasta el nivel 25
        ];

        
        let bombsCount = 0; // Contador de bombas actuales
        let maxBombs = 5; // Máximo de bombas por nivel
        let bombsLimitReached = false; // Bandera para saber si se alcanzó el límite de bombas

        function configureLevel(level) {
            // Asegúrate de que el nivel esté dentro del rango válido
            if (level < 1 || level > levelConfigurations.length) {
                console.error('Nivel no válido:', level);
                return;
            }

            const levelConfig = levelConfigurations[level - 1]; // Obtener la configuración para el nivel actual

            // Limpiar trampas y plataformas existentes
            traps.clear(true, true);
            platforms.clear(true, true);

            // Configuración de trampas
            levelConfig.traps.forEach(trapPos => {
                let trap = traps.create(trapPos.x, trapPos.y, 'trap');
                trap.setImmovable(true);
                this.physics.add.collider(trap, groundLayer);
                this.physics.add.collider(trap, platforms);
            });

            // Configuración de plataformas
            levelConfig.platforms.forEach(platformPos => {
                let platform = platforms.create(platformPos.x, platformPos.y, 'platform');
                platform.setImmovable(true);
            });

            // Configuración de bombas
            bombsCount = 0; // Reinicia el contador de bombas
            bombsLimitReached = false; // Reinicia la bandera de límite
            this.time.addEvent({
                delay: 1000,
                callback: () => {
                    if (!bombsLimitReached) {
                        dropBomb();
                    }
                },
                callbackScope: this,
                loop: true
            });
        }


        function shootBullet() {
            let bullet = bullets.create(player.x, player.y, 'bullet'); // Crea una nueva bala
            bullet.setActive(true);
            bullet.setVisible(true);
            bullet.setVelocityY(-400); // La bala se mueve hacia arriba
            bullet.body.allowGravity = false; // Evita que las balas sean afectadas por la gravedad
        }

        function destroyBomb(bullet, bomb) {
            bullet.destroy(); // Asegúrate de destruir la bala
            bomb.destroy(); // Asegúrate de destruir la bomba
        }

        let minX = 0;

        function update() {
            if (cursors.left.isDown) {
                if (player.x > minX) {
                    player.setVelocityX(-160);
                    player.anims.play('left', true);
                }
            } else if (cursors.right.isDown) {
                player.setVelocityX(160);
                player.anims.play('right', true);
            } else {
                player.setVelocityX(0);
                player.anims.play('turn');
            }

            if (cursors.up.isDown && (player.body.touching.down || player.body.touching.platform)) {
                player.setVelocityY(-330);
            }
            background.tilePositionX = this.cameras.main.scrollX * 0.5;

            clouds.children.iterate(child => {
                child.x += 0.5;
                if (child.x > levelWidth) {
                    child.x = -child.width;
                }
            });

            minX = Math.max(minX, player.x - 400);

            // Eliminar balas fuera de la pantalla
            bullets.children.each(function(bullet) {
                // Verifica si la bala sale de los límites superiores o inferiores
                if (bullet.active && (bullet.y < 0 || bullet.y > config.height)) {
                    bullet.setActive(false);
                    bullet.setVisible(false);
                    bullet.destroy(); // Destruye la bala para liberar recursos
                }
            });


            if (player.x > levelWidth - 100 && !levelCompleted) {
                levelCompleted = true;

                this.physics.pause();
                this.input.enabled = false;
                this.cameras.main.stopFollow();
                this.cameras.main.fade(500);
                setTimeout(() => {
                    Swal.fire({
                        html: `<h4>¡Enhorabuena! Has completado el nivel ${currentLevel}.<br><br>¿Quieres continuar al nivel ${currentLevel + 1}?</h4>`,
                        showDenyButton: true,
                        confirmButtonText: "Continuar",
                        denyButtonText: "Cancelar",
                        icon: 'question'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (currentLevel < 25) {
                                updateGameProgress(currentLevel + 1, score);
                                localStorage.setItem('currentLevel', currentLevel + 1);
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    html: "<h4>¡Has completado todos los niveles!<br><br>¡Felicidades!</h4>",
                                    confirmButtonText: "Reiniciar"
                                }).then(() => {
                                    updateGameProgress(1, 0);
                                    localStorage.setItem('currentLevel', 1);
                                    localStorage.setItem('score', 0);
                                    window.location.href = "/juegos/adventure_one";
                                });
                            }
                        } else if (result.isDenied) {
                            window.location.href = "/juegos";
                        }
                    });
                }, 500);
            }
        }


        function collectStar(player, star) {
            star.disableBody(true, true);

            score += 10;
            localStorage.setItem('score', score);
            scoreText.setText('Score: ' + score);

            if (stars.countActive(true) === 0) {
                stars.children.iterate(child => {
                    child.enableBody(true, child.x, 0, true, true);
                });
            }
        }

        function dropBomb() {
            return false
            if (bombsCount >= maxBombs) {
                bombsLimitReached = true; // Marca el límite como alcanzado
                return; // No crea más bombas si ya se alcanzó el límite
            }

            let x = Phaser.Math.Between(0, levelWidth);
            let bomb = bombs.create(x, 6, 'bomb');
            bomb.setBounce(1);
            bomb.setCollideWorldBounds(true);
            bomb.setVelocity(Phaser.Math.Between(-200, 200), 20);

            bombsCount++; // Incrementa el contador de bombas
        }

        function hitBomb(player, bomb) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            Swal.fire({
                html: "<h4>¡Perdiste!<br><br>¿Quieres reiniciar el juego?</h4>",
                confirmButtonText: "Reiniciar",
                icon: 'error',
            }).then(() => {
                //localStorage.setItem('currentLevel', currentLevel);
                //localStorage.setItem('score', score);
                window.location.href = "/juegos/adventure_one";
            });
        }

        function hitTrap(player, trap) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            Swal.fire({
                html: "<h4>¡Has caído en una trampa!<br><br>Intenta de nuevo</h4>",
                confirmButtonText: "Reiniciar",
                icon: 'error',
            }).then(() => {
                //localStorage.setItem('currentLevel', currentLevel);
                //localStorage.setItem('score', score);
                window.location.reload();
            });
        }

        function updateGameProgress(level, score) {
            if (userId) {
                axios.patch('/dashboard/edit-level-score/', {
                        game_id: gameId,
                        level: level,
                        score: score
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        console.log('Datos sincronizados:', response.data);
                    })
                    .catch(error => {
                        console.error('Error al sincronizar datos:', error);
                    });
            }
        }

        document.getElementById('next-level-btn').addEventListener('click', () => {
            localStorage.setItem('currentLevel', currentLevel + 1);
            updateGameProgress(currentLevel + 1, score);
            window.location.reload();
        });

        document.getElementById('reset-btn').addEventListener('click', () => {
            localStorage.setItem('currentLevel', 1);
            localStorage.setItem('score', 0);
            updateGameProgress(scoreDb, currentLevelDb);
            window.location.href = "/juegos/adventure_one";
        });
    });
</script>
