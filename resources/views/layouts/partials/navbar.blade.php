<nav class="w-full h-14 bg-gradient-to-r from-violet-500 to-fuchsia-500 fixed">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('landing') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('/assets/logos/logo_1.png') }}" class="h-8" alt="scrapbook com Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">HaveFun</span>
        </a>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                <li>
                    <a href="{{ route('landing') }}"
                        class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent {{ request()->route()->named('landing') ? 'md:text-white' : 'md:text-[#b9c4d7]' }} md:hover:text-white md:p-0"
                        aria-current="{{ request()->route()->named('landing') ? 'page' : '' }}">
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" aria-current="{{ request()->route()->named('about') ? 'page' : '' }}"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent {{ request()->route()->named('about') ? 'md:text-white' : 'md:text-[#b9c4d7]' }} md:hover:text-white md:p-0">
                        Acerca de
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        aria-current="{{ request()->route()->named('contacto') ? 'page' : '' }}"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent {{ request()->route()->named('contact') ? 'md:text-white' : 'md:text-[#b9c4d7]' }} md:hover:text-white md:p-0">
                        Contacto
                    </a>
                </li>
                <li>
                    @if (!Auth::check())
                        <a href="{{ route('login') }}"
                            class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Entrar
                        </a>
                    @else
                        <div
                            class="relative flex flex-col items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 sm:-mt-1"
                                id="user-menu-button">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('/assets/imgs/admin_1.png') }}"
                                    alt="user photo">
                            </button>
                            <!-- Dropdown menu -->
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow"
                                id="user-dropdown"
                                style="z-index: 100000000 !important;position: absolute;top:25px;right:0">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900">{{ Auth::user()->name ?? '' }}</span>
                                    <span
                                        class="block text-sm text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</span>
                                </div>
                                <ul class="py-2">
                                    <li>
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Mi perfil
                                        </a>
                                    </li>
                                    @if (Auth::user()->user_type === 'super_user')
                                        <li>
                                            <a href="{{ route('dashboard') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Administrador
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('Salir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <button data-collapse-toggle="navbar-user" type="button"
                                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                                aria-controls="navbar-user" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 17 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
