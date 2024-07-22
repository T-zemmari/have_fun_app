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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let levelCompleted = false;

        let background_img = "{{ asset('assets/imgs/adventure_one/sky.png') }}";
        let ground = "{{ asset('assets/imgs/adventure_one/background_2.png') }}";
        let dude = "{{ asset('assets/imgs/adventure_one/player.png') }}";
        let treasure = "{{ asset('assets/imgs/adventure_one/treasure.png') }}";
        let bomb = "{{ asset('assets/imgs/adventure_one/bomb.png') }}";
        let star = "{{ asset('assets/imgs/adventure_one/star.png') }}";
        let trap = "{{ asset('assets/imgs/adventure_one/trap_1.png') }}";

        let nube_1 = "{{ asset('assets/imgs/adventure_one/nubes/nube_1.png') }}";
        let nube_2 = "{{ asset('assets/imgs/adventure_one/nubes/nube_2.png') }}";
        let nube_3 = "{{ asset('assets/imgs/adventure_one/nubes/nube_3.png') }}";
        let nube_4 = "{{ asset('assets/imgs/adventure_one/nubes/nube_4.png') }}";
        let nube_5 = "{{ asset('assets/imgs/adventure_one/nubes/nube_5.png') }}";
        let nube_6 = "{{ asset('assets/imgs/adventure_one/nubes/nube_6.png') }}";

        //let array_nubes = [nube_1, nube_2, nube_3, nube_4, nube_5, nube_6];
        let array_nubes = [nube_1, nube_6];

        let currentLevel = parseInt(localStorage.getItem('currentLevel')) || 1;

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

        let player, cursors, groundLayer, background, clouds;
        let levelWidth = 1000; // Ancho del nivel
        
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

            background.tilePositionX = this.cameras.main.scrollX * 0.5;

            clouds.children.iterate(child => {
                child.x += 0.5;
                if (child.x > levelWidth) {
                    child.x = -child.width;
                }
            });

            if (player.x > levelWidth - 100 && !levelCompleted) {

                levelCompleted = true;

                // Fin del nivel
                this.cameras.main.stopFollow();
                this.cameras.main.fade(500);
                setTimeout(() => {
                    Swal.fire({
                        html: `<h4>¡Enhorabuena Has subido de nivel!<br><br>Quieres continuar</h4>`,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Continuar",
                        denyButtonText: `Cancelar`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            localStorage.setItem('currentLevel', currentLevel + 1);
                            window.location
                                .reload(); // Recargar la página para cargar el siguiente nivel
                        }
                    });
                }, 500);
                return;
            }

            let playerY = player.y;
            let groundY = 568;

            if (playerY > groundY) {
                player.setY(groundY - player.height / 2);
            }
        }

        document.getElementById('next-level-btn').addEventListener('click', () => {
            localStorage.setItem('currentLevel', currentLevel + 1);
            window.location.reload(); // Recargar la página para cargar el siguiente nivel
        });
        document.getElementById('reset-btn').addEventListener('click', () => {
            localStorage.setItem('currentLevel', 1);
            window.location.href = "/juegos/adventure_one";
        })

    });
</script>
