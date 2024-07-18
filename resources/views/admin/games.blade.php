<x-admin-base>
    <div class="w-full min-h-[100%] mt-[5rem]">
        <div class="overflow-x-auto shadow-md sm:rounded-lg p-[30px]">
            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                <label for="table-search" class="sr-only">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
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
                            <th scope="col" class="px-6 py-3">Gratis</th>
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
                                <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                    <label for="image_game_{{ $game->id }}"
                                        class="cursor-pointer text-blue-600 hover:underline">
                                        <img class="w-10 h-10 rounded-full" id="img_game_{{ $game->id }}"
                                            src="{{ asset($game->url_img) }}" alt="game">
                                    </label>
                                    <input type="file" id="image_game_{{ $game->id }}" name="image_game"
                                        class="hidden" onchange="update_game_image('{{ $game->id }}')">
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
                                        <label class="inline-flex items-center mb-5 cursor-pointer"
                                            for="show_in_web_{{ $game->id }}">
                                            <input type="checkbox" value="1" class="sr-only peer"
                                                id="show_in_web_{{ $game->id }}" name="show_in_web"
                                                {{ $game->show_in_web == 1 ? 'checked' : '' }}
                                                onchange="fn_update_show_in_web('{{ $game->id }}', {{ $game->show_in_web }})">
                                            <div
                                                class="relative ml-2 mt-4 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                            </div>
                                        </label>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center mb-5 cursor-pointer"
                                            for="active_{{ $game->id }}">
                                            <input type="checkbox" value="1" class="sr-only peer"
                                                id="active_{{ $game->id }}" name="active"
                                                {{ $game->active == 1 ? 'checked' : '' }}
                                                onchange="fn_update_active('{{ $game->id }}', {{ $game->active }})">
                                            <div
                                                class="relative ml-2 mt-4 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                            </div>
                                        </label>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center mb-5 cursor-pointer"
                                            for="free_or_paid_{{ $game->id }}">
                                            <input type="checkbox" value="1" class="sr-only peer"
                                                id="free_or_paid_{{ $game->id }}" name="free_or_paid"
                                                {{ $game->free_or_paid == 1 ? 'checked' : '' }}
                                                onchange="fn_update_free_or_paid('{{ $game->id }}', {{ $game->free_or_paid }})">
                                            <div
                                                class="relative ml-2 mt-4 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                            </div>
                                        </label>
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

<script>
    function fn_update_active(id, active) {
        $.ajax({
            url: '/dashboard/games/modificar-estado/' + id,
            type: 'PATCH',
            data: {
                active: active ? 0 : 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response.message);
                Swal.fire({
                    html: `<h4><b>Operación realizada correctamente.</b></h4>`,
                    icon: `success`,
                });
            },
            error: function(xhr, status, error) {
                console.error("Error estado:", error);
                let errors = xhr.responseJSON.errors;
                let errorMessages = '';
                for (let field in errors) {
                    errorMessages += `${errors[field].join('<br>')}<br>`;
                }
                Swal.fire({
                    html: `<h4><b>Operación fallida</b></h4><p>${errorMessages}</p>`,
                    icon: `error`,
                });
            }
        });
    }

    function fn_update_show_in_web(id, show_in_web) {
        $.ajax({
            url: '/dashboard/games/modificar-show-in-web/' + id,
            type: 'PATCH',
            data: {
                show_in_web: show_in_web ? 0 : 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response.message);
                Swal.fire({
                    html: `<h4><b>Operación realizada correctamente.</b></h4>`,
                    icon: `success`,
                });
            },
            error: function(xhr, status, error) {
                console.error("Error show_in_web:", error);
                let errors = xhr.responseJSON.errors;
                let errorMessages = '';
                for (let field in errors) {
                    errorMessages += `${errors[field].join('<br>')}<br>`;
                }
                Swal.fire({
                    html: `<h4><b>Operación fallida</b></h4><p>${errorMessages}</p>`,
                    icon: `error`,
                });
            }
        });
    }

    function fn_update_free_or_paid(id, free_or_paid) {
        $.ajax({
            url: '/dashboard/games/modificar-free-or-paid/' + id,
            type: 'PATCH',
            data: {
                free_or_paid: free_or_paid ? 0 : 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response.message);
                Swal.fire({
                    html: `<h4><b>Operación realizada correctamente.</b></h4>`,
                    icon: `success`,
                });
            },
            error: function(xhr, status, error) {
                console.error("Error free_or_paid:", error);
                let errors = xhr.responseJSON.errors;
                let errorMessages = '';
                for (let field in errors) {
                    errorMessages += `${errors[field].join('<br>')}<br>`;
                }
                Swal.fire({
                    html: `<h4><b>Operación fallida</b></h4><p>${errorMessages}</p>`,
                    icon: `error`,
                });
            }
        });
    }

    function update_game_image(gameId) {
        let formData = new FormData();
        let input = document.getElementById('image_game_' + gameId);
        formData.append('image_game', input.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '/dashboard/change-img-game/' + gameId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response.message);
                Swal.fire({
                    html: `<h4><b>Imagen actualizada correctamente.</b></h4>`,
                    icon: `success`,
                });

                // Actualizar la imagen en la interfaz
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector(`#tr_game_${gameId} img`).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            },
            error: function(xhr, status, error) {
                console.error("Error al actualizar la imagen:", error);
                let errors = xhr.responseJSON.errors;
                let errorMessages = '';
                for (let field in errors) {
                    errorMessages += `${errors[field].join('<br>')}<br>`;
                }
                Swal.fire({
                    html: `<h4><b>Error al actualizar la imagen</b></h4><p>${errorMessages}</p>`,
                    icon: `error`,
                });
            }
        });
    }
</script>
