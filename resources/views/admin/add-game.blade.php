<x-admin-base>
    <div class="w-full">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-[100px]" role="alert">
                <strong class="font-bold">Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-[100px]" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Hay algunos problemas con tu entrada.</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="new_game" class="max-w-lg mx-auto mt-[100px] border border-gray-200 p-16" method="POST" action="{{ url('/dashboard/new_game') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del juego</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Escribe el nombre del juego..." required />
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                <textarea id="description" name="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Escribe una breve descripción...">{{ old('description') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="route_name" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la ruta</label>
                <input type="text" id="route_name" name="route_name" value="{{ old('route_name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Escribe el nombre de la ruta..." required />
            </div>
            <div class="mb-5">
                <label for="url_img" class="block mb-2 text-sm font-medium text-gray-900">Imagen</label>
                <input type="file" id="url_img" name="url_img" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>
            <div class="mb-5">
                <div class="w-full flex justify-between items-center">
                    <label class="inline-flex items-center mb-5 cursor-pointer" for="active">
                        <span class="ms-3 text-sm font-medium text-gray-900">Activo</span>
                        <input type="checkbox" value="1" class="sr-only peer" id="active" name="active" {{ old('active', 1) ? 'checked' : '' }}>
                        <div class="relative ml-2 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    </label>
                    <label class="inline-flex items-center mb-5 cursor-pointer" for="show_in_web">
                        <span class="ms-3 text-sm font-medium text-gray-900">Mostrar En Web</span>
                        <input type="checkbox" value="1" class="sr-only peer" id="show_in_web" name="show_in_web" {{ old('show_in_web', 1) ? 'checked' : '' }}>
                        <div class="relative ml-2 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    </label>
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Guardar</button>
        </form>
    </div>
</x-admin-base>
