<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-800">
            {{ __('Eliminar mi cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-800">
            {{ __('
            Una vez que se elimine tu cuenta, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
    >{{ __('ELIMINAR CUENTA') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán de forma permanente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Eliminar') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>