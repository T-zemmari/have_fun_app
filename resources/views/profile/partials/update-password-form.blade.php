<section class="w-full">
    <header>
        <h2 class="text-lg font-medium text-gray-800">
            {{ __('Actualizar mi contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-800">
            {{ __('Usa una contraseña larga y aleatoria para mantener tu cuenta segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 text-gray-200">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" class="text-gray-800" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="w-full flex flex-row justify-between gap-4">
            <div class="w-full">
                <x-input-label for="update_password_password" :value="__('Nueva contraseña')" class="text-gray-800" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="w-full">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirma tu contraseña')" class="text-gray-800" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-200">{{ __('Contraseña cambiada.') }}</p>
            @endif
        </div>
    </form>
</section>