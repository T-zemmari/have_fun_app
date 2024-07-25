    <style>
        #div_canvas {
            width: 10000px;
            height: 600px;
            border: 1px dashed black;
            max-width: 800px;
            overflow-x: scroll;
            position: relative;
        }

        #contenedor_plataformas {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 10px;
        }

        .platform {
            width: 85px;
            height: 32px;
            background-color: rgb(22, 138, 231);
            border: 1px solid black;
            cursor: grab;
        }

        .platform.dragging {
            opacity: 0.5;
        }

        #coords_display {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>

    <x-admin-base>
        <div class="w-full p-8 bg-white shadow-lg rounded-lg mb-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">Generador de Coordenadas</h1>
            <div class="w-full flex flex-row justify-center items-center gap-10">
                <div id="div_canvas" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                <div style="width: 400px; height: 600px; border: 1px dashed black; padding: 10px;"
                    id="contenedor_plataformas">
                    <div class="platform" draggable="true" data-id="1"
                        style="width: 85px; height: 32px; background-color: rgb(22, 138, 231);"></div>
                    <div class="platform" draggable="true" data-id="2"
                        style="width: 150px; height: 32px; background-color: rgb(255, 99, 71);"></div>
                    <div class="platform" draggable="true" data-id="3"
                        style="width: 50px; height: 32px; background-color: rgb(129, 50, 36);"></div>
                    <div class="platform" draggable="true" data-id="4"
                        style="width: 85px; height: 32px; background-color: rgb(63, 89, 110);"></div>
                    <div class="platform" draggable="true" data-id="5"
                        style="width: 100px; height: 32px; background-color: rgb(34, 110, 27);"></div>
                    <div class="platform" draggable="true" data-id="6"
                        style="width: 200px; height: 32px; background-color: rgb(138, 140, 168);"></div>
                    <div class="platform" draggable="true" data-id="7"
                        style="width: 300px; height: 32px; background-color: rgb(21, 26, 107);"></div>
                    <div class="platform" draggable="true" data-id="8"
                        style="width: 400px; height: 32px; background-color: rgb(183, 185, 21);"></div>
                    <div class="platform" draggable="true" data-id="9"
                        style="width: 50px; height: 32px; background-color: rgb(138, 140, 168);"></div>
                </div>
            </div>
            <button onclick="generateJSON()">Generar JSON</button>
            <div id="coords_display">Coordenadas: (x: 0, y: 0)</div>
        </div>
    </x-admin-base>


    <script>
        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.dataset.id);
            event.target.classList.add('dragging');
        }

        function drop(event) {
            event.preventDefault();
            const id = event.dataTransfer.getData("text");

            const canvasRect = document.getElementById('div_canvas').getBoundingClientRect();
            const xOffset = event.clientX - canvasRect.left;
            const yOffset = event.clientY - canvasRect.top;

       
            const platformInCanvas = document.querySelector(`#div_canvas .platform[data-id="${id}"]`);
            if (platformInCanvas) {
             
                const offsetX = xOffset - platformInCanvas.offsetWidth / 2;
                const offsetY = yOffset - platformInCanvas.offsetHeight / 2;

                platformInCanvas.style.left = `${offsetX}px`;
                platformInCanvas.style.top = `${offsetY}px`;

            } else {
              
                const platform = document.querySelector(`.platform[data-id="${id}"]`);
                if (platform) {
                    const clone = platform.cloneNode(true); 
                    clone.id = `platform_${Date.now()}`; 
                    clone.classList.remove('dragging'); 
                    clone.style.position = 'absolute'; 
                    clone.style.left = `${xOffset - clone.offsetWidth / 2}px`;
                    clone.style.top = `${yOffset - clone.offsetHeight / 2}px`;
                    clone.setAttribute('draggable', 'true');
                    clone.addEventListener('dragstart', drag);
                    document.getElementById('div_canvas').appendChild(clone);
                }
            }
        }

        function generateJSON() {
            const platforms = Array.from(document.querySelectorAll('#div_canvas .platform'));
            const data = platforms.map(p => ({
                id: p.id,
                x: parseInt(p.style.left, 10),
                y: parseInt(p.style.top, 10),
                width: p.offsetWidth,
                height: p.offsetHeight
            }));
            console.log(JSON.stringify(data, null, 2));
        }

        document.querySelectorAll('.platform').forEach(platform => {
            platform.addEventListener('dragstart', drag);
        });
    </script>
