<x-guest-layout>
    @include('layouts.partials.navbar')

    <div class="w-full h-screen flex justify-center items-center !bg-center !bg-cover"
        style="background:url('{{ asset('/assets/imgs/img_login_1.png') }}')">
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}"
            class="w-[98%] h-[400px] flex flex-col justify-center p-8 sm:w-[400px] bg-gradient-to-r from-[#8b5cf6bf] to-fuchsia-500 sm:p-10 rounded-lg">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label class="text-white" for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full " type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-input-label class="text-white" for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <button type="button" onclick="togglePassword('password', 'show')"
                    id="show_pass_login_button"
                    class="absolute inset-y-0 right-[5px] pr-3 flex items-center text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_show_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <button type="button" onclick="togglePassword('password', 'hide')"
                    id="hide_pass_login_button"
                    class="hidden absolute inset-y-0 right-[5px] pr-3  text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_hide_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="flex justify-start items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ms-2 text-sm text-white dark:text-gray-400 ">{{ __('Recuerdame') }}</span>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#cfcfcf] dark:text-gray-400 ml-6 -mt-0 hover:text-white dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="{{ route('password.request') }}">
                            {{ __('¿Has olvidado tu contraseña?') }}
                        </a>
                    @endif
                </label>

            </div>

            <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ms-3">
                    {{ __('Entrar') }}
                </x-primary-button>
            </div>
            <a class="text-sm text-[#cfcfcf] dark:text-gray-400 hover:text-white dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('register') }}">
                {{ __('Haz click aqui si no tienes cuenta aun') }}
            </a>
        </form>

    </div>
</x-guest-layout>
