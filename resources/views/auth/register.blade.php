<x-guest-layout>
    @include('layouts.partials.navbar')

    <div class="w-full h-screen flex justify-center items-center !bg-center !bg-cover"
        style="background:url('{{ asset('/assets/imgs/img_login_1.png') }}')">
        <form method="POST" action="{{ route('register') }}"
            class="w-[98%] h-[480px] flex flex-col justify-center p-8 sm:w-[480px] bg-gradient-to-r from-[#8b5cf6bf] to-fuchsia-500 sm:p-10 rounded-lg">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-white" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password', 'show')" id="show-password-button"
                    class="absolute inset-y-0 right-[5px] pr-3 flex items-center text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_show_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <button type="button" onclick="togglePassword('password', 'hide')" id="hide-password-button"
                    class="hidden absolute inset-y-0 right-[5px] pr-3  text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_hide_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 relative">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password_confirmation', 'show')"
                    id="show-password-confirmation-button"
                    class="absolute inset-y-0 right-[5px] pr-3 flex items-center text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_show_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <button type="button" onclick="togglePassword('password_confirmation', 'hide')"
                    id="hide-password-confirmation-button"
                    class="hidden absolute inset-y-0 right-[5px] pr-3  
                 text-sm leading-5  w-[30px] h-[20px] top-[50%] "
                    style="background-image: url('{{ asset('assets/icons/eye_hide_1.png') }}');background-position:center;background-size:cover;">
                </button>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="text-sm text-white dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Click aquí si ya tienes cuenta') }}
                </a>
                <x-primary-button class="ms-4">
                    {{ __('Regístrate') }}
                </x-primary-button>
            </div>
        </form>
    </div>


</x-guest-layout>
