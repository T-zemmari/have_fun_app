<style>
    #div_canvas {
        height: 600px;
        border: 1px dashed black;
        max-width: 800px;
        overflow-x: scroll;
        position: relative;
        width: 10000px;
        /* Empezamos con 10000px de ancho pero se puede ajustar dinámicamente */
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
                <div class="platform" draggable="true" data-type-id="1"
                    style="border:none;width: 85px; height: 32px; background-color: rgb(22, 138, 231);"></div>
                <div class="platform" draggable="true" data-type-id="2"
                    style="border:none;width: 150px; height: 32px; background-color: rgb(255, 99, 71);"></div>
                <div class="platform" draggable="true" data-type-id="3"
                    style="border:none;width: 50px; height: 32px; background-color: rgb(129, 50, 36);"></div>
                <div class="platform" draggable="true" data-type-id="4"
                    style="border:none;width: 85px; height: 32px; background-color: rgb(63, 89, 110);"></div>
                <div class="platform" draggable="true" data-type-id="5"
                    style="border:none;width: 100px; height: 32px; background-color: rgb(34, 110, 27);"></div>
                <div class="platform" draggable="true" data-type-id="6"
                    style="border:none;width: 200px; height: 32px; background-color: rgb(138, 140, 168);"></div>
                <div class="platform" draggable="true" data-type-id="7"
                    style="border:none;width: 300px; height: 32px; background-color: rgb(21, 26, 107);"></div>
                <div class="platform" draggable="true" data-type-id="8"
                    style="border:none;width: 400px; height: 32px; background-color: rgb(183, 185, 21);"></div>
                <div class="platform" draggable="true" data-type-id="9"
                    style="border:none;width: 50px; height: 32px; background-color: rgb(138, 140, 168);"></div>
                <div class="platform" draggable="true" data-type-id="10"
                    style="border:none;width: 9999px; height: 32px; background-color: rgb(138, 140, 168);"></div>
            </div>
        </div>
        <button onclick="generateJSON()">Generar JSON</button>
        <div id="coords_display">Coordenadas: (x: 0, y: 0)</div>
    </div>
</x-admin-base>

<script>
    let isDraggingFromCanvas = false;
    const maxCanvasWidth = 10000; // El máximo ancho permitido para el div_canvas

    function allowDrop(event) {
        event.preventDefault(); // Permite el drop
    }

    function drag(event) {
        isDraggingFromCanvas = event.target.parentElement.id === 'div_canvas';
        event.dataTransfer.setData("text", event.target.dataset.uniqueId || event.target.dataset
        .typeId); // Utiliza el ID único si está disponible, de lo contrario el tipo de ID
        event.target.classList.add('dragging');
    }

    function drop(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado
        const id = event.dataTransfer.getData("text"); // Obtiene el ID del elemento arrastrado

        const canvas = document.getElementById('div_canvas');
        const canvasRect = canvas.getBoundingClientRect();
        const xOffset = event.clientX - canvasRect.left + canvas.scrollLeft;
        const yOffset = event.clientY - canvasRect.top;

        if (xOffset > canvas.offsetWidth) {
            canvas.style.width = `${Math.min(xOffset, maxCanvasWidth)}px`;
        }

        if (isDraggingFromCanvas) {
            // Si el arrastre es desde el div_canvas, simplemente mueve la plataforma existente
            const platformInCanvas = document.querySelector(`#div_canvas .platform[data-unique-id="${id}"]`);
            if (platformInCanvas) {
                platformInCanvas.style.left = `${xOffset - platformInCanvas.offsetWidth / 2}px`;
                platformInCanvas.style.top = `${yOffset - platformInCanvas.offsetHeight / 2}px`;
            }
        } else {
            // Si el arrastre es desde el contenedor_plataformas, clona y añade una nueva plataforma al div_canvas
            const platform = document.querySelector(`.platform[data-type-id="${id}"]`);
            if (platform) {
                const clone = platform.cloneNode(true); // Clona la plataforma
                const uniqueId = `platform_${Date.now()}`; // Asigna un ID único
                clone.dataset.uniqueId = uniqueId; // Establece un data-unique-id para la plataforma clonada
                clone.classList.remove('dragging'); // Elimina la clase de arrastre
                clone.style.position = 'absolute'; // Asegura que se pueda mover libremente
                clone.style.left = `${xOffset - clone.offsetWidth / 2}px`;
                clone.style.top = `${yOffset - clone.offsetHeight / 2}px`;
                clone.setAttribute('draggable', 'true');
                clone.addEventListener('dragstart', drag);
                clone.addEventListener('dragend', () => clone.classList.remove('dragging'));
                clone.addEventListener('mousemove', updateCoords); // Actualiza coordenadas al mover
                canvas.appendChild(clone); // Añade al div_canvas
            }
        }
    }

    function updateCoords(event) {
        if (event.target.classList.contains('platform')) {
            const x = parseInt(event.target.style.left, 10) || 0;
            const y = parseInt(event.target.style.top, 10) || 0;
            document.getElementById('coords_display').textContent = `Coordenadas: (x: ${x}, y: ${y})`;
        }
    }

    function autoScrollAndExpandCanvas(event) {
        const canvas = document.getElementById('div_canvas');
        const canvasRect = canvas.getBoundingClientRect();

        // Auto-scroll si te acercas al borde derecho
        if (event.clientX > canvasRect.right - 50) {
            canvas.scrollLeft += 20; // Desplaza a la derecha
            // Expande el canvas si el cursor está cerca del borde derecho
            if (canvas.scrollLeft + canvas.clientWidth >= canvas.scrollWidth && canvas.offsetWidth < maxCanvasWidth) {
                canvas.style.width = `${Math.min(canvas.scrollWidth + 100, maxCanvasWidth)}px`;
            }
        }

        // Auto-scroll si te acercas al borde izquierdo
        if (event.clientX < canvasRect.left + 50) {
            canvas.scrollLeft -= 20; // Desplaza a la izquierda
        }
    }

    function generateJSON() {
        const platforms = Array.from(document.querySelectorAll('#div_canvas .platform'));
        const data = platforms.map(p => ({
            id: p.dataset.uniqueId,
            originalId: p.dataset.typeId, // Incluye el ID de la plataforma original
            x: parseInt(p.style.left, 10),
            y: parseInt(p.style.top, 10),
            width: p.offsetWidth,
            height: p.offsetHeight
        }));
        console.log(JSON.stringify(data, null, 2));
    }


    document.getElementById('div_canvas').addEventListener('dragover', autoScrollAndExpandCanvas);

    document.querySelectorAll('.platform').forEach(platform => {
        platform.addEventListener('dragstart', drag);
        platform.addEventListener('dragend', () => platform.classList.remove('dragging'));
        platform.addEventListener('mousemove', updateCoords);
    });
</script>
