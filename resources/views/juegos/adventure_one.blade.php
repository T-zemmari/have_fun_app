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
        let bullet = "{{ asset('assets/imgs/adventure_one/bullet_3.png') }}";

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

        let player, cursors, groundLayer, background, clouds, stars, bombs, traps, platforms;
        let levelWidth = 1000;

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
            this.physics.add.collider(player, groundLayer);

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

            this.physics.add.collider(stars, groundLayer);
            this.physics.add.overlap(player, stars, collectStar, null, this);

            this.physics.add.collider(player, platforms);
            this.physics.add.collider(stars, platforms);

            traps = this.physics.add.group();
            bombs = this.physics.add.group();

            configureLevel.call(this, currentLevel);

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

        function configureLevel(level) {
            let bombDelay = 1000 - (level - 1) * 100; // Bombas más rápidas con cada nivel
            let trapCount = Math.min(level, 5); // Máximo 5 trampas
            let platformCount = Math.min(level + 1, 3); // Máximo 3 plataformas

            this.time.addEvent({
                delay: Math.max(bombDelay, 500),
                callback: dropBomb,
                callbackScope: this,
                loop: true
            });

            traps.clear(true, true);
            platforms.clear(true, true); // Limpiar plataformas existentes

            // Configuración de trampas
            for (let i = 0; i < trapCount; i++) {
                let x = Phaser.Math.Between(200, levelWidth - 200);
                let trap = traps.create(x, 548, 'trap');
                trap.setImmovable(true);

                // Ajustar la posición vertical de la trampa para que esté en el suelo o en una plataforma
                this.physics.add.collider(trap, groundLayer);
                this.physics.add.collider(trap, platforms);
            }

            // Configuración de plataformas
            let platformPositions = []; // Array para almacenar las posiciones de las plataformas
            let candidatePositions = [];

            // Generar posiciones candidatas
            for (let i = 0; i < platformCount * 2; i++) { // Generar el doble de posiciones necesarias
                let x = Phaser.Math.Between(100, levelWidth - 100);
                let y = Phaser.Math.Between(150, 400);
                candidatePositions.push({
                    x,
                    y
                });
            }

            // Filtrar posiciones válidas
            candidatePositions.forEach(pos => {
                let isPositionValid = platformPositions.every(existingPos => {
                    let distanceX = Math.abs(pos.x - existingPos.x);
                    let distanceY = Math.abs(pos.y - existingPos.y);
                    return distanceX >= 100 && distanceY >= 150;
                });

                if (isPositionValid) {
                    platformPositions.push(pos);
                }

                // Parar si ya hemos colocado suficientes plataformas
                if (platformPositions.length >= platformCount) return;
            });

            // Crear plataformas
            platformPositions.forEach(pos => {
                let platform = platforms.create(pos.x, pos.y, 'platform');
                platform.setImmovable(true);
            });
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
            let x = Phaser.Math.Between(0, levelWidth);
            let bomb = bombs.create(x, 6, 'bomb');
            let levelDifficulty = currentLevel;
            bomb.setBounce(1);
            bomb.setCollideWorldBounds(true);
            bomb.setVelocity(Phaser.Math.Between(-200, 200) * Math.min(levelDifficulty, 5), 20 +
                levelDifficulty * 10);
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
