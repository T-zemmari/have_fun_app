<x-admin-base>
    <div class="w-full min-h-[90vh] border border-blue-200 p-2">

        @if (!isset($users) || !is_array($users) || count($users) == 0)
            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                role="alert">
                <span class="font-medium">Info usuarios: </span> Lista de usuarios vacia.
            </div>
        @else
            <div class="overflow-x-auto shadow-md sm:rounded-lg p-4">
                <h2>Lista de usuarios</h2>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dirección
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Teléfono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <!--<?php echo '<pre>';
                            print_r($user);
                            echo '</pre>';
                            ?>-->
                            <tr id="tr_user_{{ $user->id }}"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox_table_user_{{ $user->id }}" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox_table_user_{{ $user->id }}" class="sr-only"></label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    @if (isset($user->userProfile->avatar) && $user->userProfile->avatar != '')
                                        <img class="w-10 h-10 rounded-full" src="{{ $user->userProfile->avatar }}"
                                            alt="img_avatar">
                                    @else
                                        <img class="w-10 h-10 rounded-full"
                                            src="{{ asset('/assets/imgs/img_scrap_1.png') }}" alt="img_avatar">
                                    @endif

                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user->userProfile->adress ?? '--- ---' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->userProfile->phone ?? '--- ---' }}
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    {{ $user->user_type }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                        {{ $user->active ? 'Sí' : 'No' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href=""
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-admin-base>
