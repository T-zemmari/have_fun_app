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
                    gravity: { y: 300 },
                    debug: false
                }
            },
            parent: 'phaser-game',
            scene: { preload, create, update }
        };

        const game = new Phaser.Game(config);
        let scoreText;
        let levelText;

        let player, cursors, groundLayer, background, clouds, stars, bombs, traps, platforms, bullets;
        let lastFired = 0;
        let levelWidth = 1000;

        function preload() {
            this.load.image('background', background_img);
            this.load.image('ground', ground);
            this.load.spritesheet('dude', dude, { frameWidth: 32, frameHeight: 48 });
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
            background = this.add.tileSprite(0, 0, config.width, config.height, 'background').setOrigin(0, 0).setScrollFactor(0);
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
            bullets = this.physics.add.group({ defaultKey: 'bullet', maxSize: 10 });
            this.input.keyboard.on('keydown-SPACE', shootBullet, this);

            this.anims.create({ key: 'left', frames: this.anims.generateFrameNumbers('dude', { start: 0, end: 3 }), frameRate: 10, repeat: -1 });
            this.anims.create({ key: 'turn', frames: [{ key: 'dude', frame: 4 }], frameRate: 20 });
            this.anims.create({ key: 'right', frames: this.anims.generateFrameNumbers('dude', { start: 5, end: 8 }), frameRate: 10, repeat: -1 });

            cursors = this.input.keyboard.createCursorKeys();

            stars = this.physics.add.group({ key: 'star', repeat: 11, setXY: { x: 12, y: 0, stepX: 70 } });
            stars.children.iterate(child => child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8)));

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
            this.physics.add.collider(traps, platforms);
            this.physics.add.collider(player, bombs, hitBomb, null, this);
            this.physics.add.collider(player, traps, hitTrap, null, this);

            let minDistanceX = 200;
            let minDistanceY = 50;
            let minY = 50;
            let maxY = 158;
            let positions = [];

            for (let x = 0; x <= levelWidth; x += minDistanceX) {
                for (let y = minY; y <= maxY; y += minDistanceY) {
                    positions.push({ x, y });
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

            scoreText = this.add.text(16, 16, 'Score: ' + score, { fontSize: '32px', fill: '#000' }).setScrollFactor(0);
            levelText = this.add.text(16, 60, 'Nivel: ' + currentLevel, { fontSize: '32px', fill: '#000' }).setScrollFactor(0);
        }

        let bombsCount = 0; // Contador de bombas actuales
        let maxBombs = 5; // Máximo de bombas por nivel
        let bombsLimitReached = false; // Bandera para saber si se alcanzó el límite de bombas

        function configureLevel(level) {
            bombsCount = 0; // Reinicia el contador de bombas al configurar un nuevo nivel
            bombsLimitReached = false; // Reinicia la bandera para saber si se alcanzó el límite

            maxBombs = 5 + (level - 1) * 2; // Aumenta el número máximo de bombas por nivel
            let trapCount = Math.min(level, 5); // Máximo 5 trampas
            let platformCount = Math.min(level + 1, 3); // Máximo 3 plataformas

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
            for (let i = 0; i < platformCount; i++) {
                let x = Phaser.Math.Between(200, levelWidth - 200);
                let platform = platforms.create(x, Phaser.Math.Between(200, 400), 'platform');
                platform.setImmovable(true);

                this.physics.add.collider(platform, groundLayer);
            }
        }

        function dropBomb() {
            if (bombsCount >= maxBombs) {
                bombsLimitReached = true; // No permitir más bombas
                return;
            }

            let x = Phaser.Math.Between(200, levelWidth - 200);
            let bomb = bombs.create(x, -50, 'bomb');
            bomb.setBounce(1);
            bomb.setCollideWorldBounds(true);
            bomb.setGravityY(Phaser.Math.Between(100, 300));

            bombsCount++;
        }

        function shootBullet() {
            if (game.time.now - lastFired < 300) {
                return;
            }

            lastFired = game.time.now;

            let bullet = bullets.get(player.x + 50, player.y - 20);

            if (bullet) {
                bullet.setActive(true);
                bullet.setVisible(true);
                bullet.setVelocityX(600);
            }
        }

        function collectStar(player, star) {
            star.disableBody(true, true);
            score += 10;
            scoreText.setText('Score: ' + score);
        }

        function hitBomb(player, bomb) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
        }

        function hitTrap(player, trap) {
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
        }

        function destroyBomb(bullet, bomb) {
            bomb.setAlpha(0);
            bullet.setAlpha(0);
            bombsCount--;
            if (bombsCount < maxBombs) {
                bombsLimitReached = false; // Permitir más bombas si se han destruido algunas
            }
        }

        function update() {
            if (gameOver) return;

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

            if (player.x >= levelWidth) {
                currentLevel++;
                localStorage.setItem('currentLevel', currentLevel);
                configureLevel.call(this, currentLevel);
            }

            if (player.y > config.height) {
                hitTrap(player, null);
            }

            if (cursors.space.isDown) {
                shootBullet();
            }
        }
    });
</script>
