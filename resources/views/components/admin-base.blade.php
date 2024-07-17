@if (!Auth::check() || Auth::user()->user_type !== 'super_user')
    <script>
        window.location.href = "/";
    </script>
@else
    <x-app-layout>

        @section('title', 'Dashboard - Mi panel')
        @include('layouts.partials.navbar')

        <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
            aria-controls="sidebar-multi-level-sidebar" type="button"
            class="mt-[64px] inline-flex items-center p-2  ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                </path>
            </svg>
        </button>

        <aside id="sidebar-multi-level-sidebar"
            class="w-64 mt-[64px] fixed top-0 left-0 z-40 bg-transparent h-[100%] transition-transform -translate-x-full sm:translate-x-0 md:h-screen"
            aria-label="Sidebar">
            <div class="h-[90%] px-3 py-4 overflow-y-auto bg-[#1f2937] rounded-lg ml-2 mt-2">
                <input type="hidden" id="tkn"
                    value="{{ session()->has('mis_tokens') ? session('mis_tokens') : '' }}">
                <ul class="space-y-2 font-medium">
                    <li class="cursor-pointer">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 text-white  rounded-sm  hover:bg-[#374151]">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75  group-hover:text-gray-900"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3 text-[14px] mt-1 uppercase">Inicio</span>
                        </a>
                    </li>
                    @if (Auth::user()->user_type == 'super_user')
                        <li class="cursor-pointer">
                            <button type="button"
                                class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-sm group hover:bg-[#374151]"
                                aria-controls="dropdown-usuarios_permisos"
                                data-collapse-toggle="dropdown-usuarios_permisos">
                                <span
                                    class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text-[14px] uppercase">
                                    Usuarios-Permisos
                                </span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul id="dropdown-usuarios_permisos" class="py-2 space-y-2">
                                <li class="cursor-pointer">
                                    <a href="{{ route('admin.users') }}">
                                        <span
                                            class="text-[14px] flex items-center w-full p-1 text-[#bac0d2] transition duration-75 rounded-sm pl-11 group hover:bg-[#374151] ">
                                            Usuarios
                                        </span>
                                    </a>
                                </li>
                                <li class="cursor-pointer">
                                    <a href="{{ route('admin.permises') }}">
                                        <span
                                            class="text-[14px] flex items-center w-full p-1 text-[#bac0d2] transition duration-75 rounded-sm pl-11 group hover:bg-[#374151]  ">
                                            Permisos
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="cursor-pointer">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-sm group hover:bg-[#374151]"
                            aria-controls="dropdown-mis_temarios" data-collapse-toggle="dropdown-mis_temarios">
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text-[14px] uppercase">
                                Juegos
                            </span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-mis_temarios" class="py-2 space-y-2">
                            <li class="cursor-pointer">
                                <a href="{{ route('admin.games') }}">
                                    <span
                                        class="text-[14px] flex items-center w-full p-1 text-[#bac0d2] transition duration-75 rounded-sm pl-11 group hover:bg-[#374151] ">
                                        Lista de los juegos
                                    </span>
                                </a>
                            </li>
                            <li class="cursor-pointer">
                                <a href="{{ route('admin.add-game') }}">
                                    <span
                                        class="text-[14px] flex items-center w-full p-1 text-[#bac0d2] transition duration-75 rounded-sm pl-11 group hover:bg-[#374151] ">
                                        Añadir juego
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="min-h-screen p-4 sm:ml-64 sm:mt-[15px] md:px-[2rem] md:py-[3.70rem]"
            style="width:calc(100% - 256px);">
            {{ $slot }}
        </div>

    </x-app-layout>
@endif
