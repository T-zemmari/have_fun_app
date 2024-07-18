<x-admin-base>
    <div class="w-full min-h-[100%] mt-[5rem]">
        <div class="overflow-x-auto shadow-md sm:rounded-lg p-[30px]">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                <label for="table-search" class="sr-only">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-users"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Buscar un juego">
                </div>
            </div>

            @if (!isset($games) || count($games) == 0)
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">La lista de juegos está vacía</span>.
                </div>
            @else
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="checkbox-all-search" class="sr-only"></label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">Juego</th>
                            <th scope="col" class="px-6 py-3">Ruta</th>
                            <th scope="col" class="px-6 py-3">Mostrar En Web</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                            <tr class="bg-white border-b hover:bg-gray-50 " id="tr_game_{{ $game->id }}">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="chkbox_search_game_{{ $game->id }}" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="chkbox_search_game_{{ $game->id }}" class="sr-only"></label>
                                    </div>
                                </td>
                                <td scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap ">
                                    <form id="game-form-{{ $game->id }}"
                                        action="{{ route('change-img-game') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <label for="avatar"
                                            class="cursor-pointer text-blue-600 hover:underline">
                                            @if ($game->url_img)
                                                <img class="w-10 h-10 rounded-full"
                                                    src="{{ asset($game->url_img) }}" alt="game">
                                            @else
                                                <img class="w-10 h-10 rounded-full"
                                                    src="{{ asset('/assets/imgs/admin_1.png') }}"
                                                    alt="placeholder">
                                            @endif
                                        </label>
                                        <input type="file" id="image_game" name="image_game"
                                            class="hidden"
                                            onchange="document.getElementById('game-form-{{ $game->id }}').submit()">
                                    </form>
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $game->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $game->created_at }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        {{ $game->route_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        {{ $game->show_in_web && $game->show_in_web == 1 ? 'Si' : 'No' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-2.5 w-2.5 rounded-full {{ $game->active && $game->active == 1 ? 'bg-green-500 me-2' : 'bg-red-500 me-2' }}">
                                        </div>
                                        {{ $game->active && $game->active == 1 ? 'Activo' : 'Inactivo' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form id="delete-form-{{ $game->id }}"
                                        action="{{ route('delete-game', ['id' => $game->id]) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este juego?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-medium text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-admin-base>
