<x-app-layout>
    @section('title', 'Editar - Mi perfil')
    @include('layouts.partials.navbar')
    <!--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>-->

    <div class="p-4">
        <div class="w-full min-h-screen md:max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="w-full flex flex-col justify-center items-center">
                <div class="w-full flex flex-col lg:flex-row justify-between sm:items-center gap-2 mt-[5rem] lg:mt-[10rem]">
                    <div class="w-full md:w-[80%] lg:w-[49%] p-4 sm:p-8 bg-gradient-to-r from-slate-300 to-slate-500 shadow sm:rounded-lg ">
                        <div class="max-w-xl ">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                    <div class="w-full md:w-[80%] lg:w-[49%] p-4 sm:p-8 bg-gradient-to-r from-slate-300 to-slate-500 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
                <div class="w-full p-4 sm:p-8 bg-gradient-to-r from-slate-300 to-slate-500 shadow sm:rounded-lg mt-10">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>