<section class="w-full ">
    <header>
        <div class="w-full flex justify-between items-center">
            <div class="w-[50%]">
                <h2 class="text-lg font-medium text-gray-800">
                    {{ __('Mi perfil') }}
                </h2>

                <p class="mt-1 text-sm text-gray-800">
                    {{ __('Actualiza tu perfil y correo electrónico.') }}
                </p>
            </div>
            <div class="w-[50%] flex justify-end">
                <form id="avatar-form" action="{{ route('profile.change-avatar') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="avatar" class="cursor-pointer text-blue-600 hover:underline">
                        @if (Auth::user()->userProfile && Auth::user()->userProfile->avatar && Auth::user()->userProfile->avatar != 'N/A')
                            <img class="w-16 h-16 rounded-full"
                                src="{{ asset('/assets/uploads/imgs/avatars/' . Auth::user()->userProfile->avatar) }}"
                                alt="user">
                        @else
                            <img class="w-12 h-12 rounded-full" src="{{ asset('/assets/imgs/admin_1.png') }}"
                                alt="user">
                        @endif
                    </label>
                    <input type="file" id="avatar" name="avatar" class="hidden"
                        onchange="document.getElementById('avatar-form').submit()">
                </form>
            </div>
        </div>


    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre y apellidos')" class="text-gray-800" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full " :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo electrónico (No se puede modificar)')" class="text-red-800" />
            <x-text-input id="email" name="email" readonly type="email"
                class="mt-1 block w-full bg-gray-600 text-gray-100" :value="old('email', $user->email)" required
                autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-200">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-200 hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Clic aquí para reenviar el correo electrónico de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-200">{{ __('Información guardada.') }}</p>
            @endif
        </div>
    </form>
</section>
