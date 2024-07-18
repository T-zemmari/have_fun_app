<x-guest-layout>
    @section('title', 'HaveFun - Contacto')
    @include('layouts.partials.navbar')

    <div class="w-full flex justify-center items-center md:h-[92.6vh]">
        <div class="w-[95%] mt-[90px] md:w-[700px] mx-auto p-1 md:mt-[70px]">
            <div class="text-center mb-2">

                <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-600">
                    Rellena <span class="text-indigo-600">el Formulario</span>
                </h3>
            </div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mt-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST"
                class="w-full md:border-2 border-[#706e6e] p-4 md:p-12 rounded-lg mt-4">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-600 text-xs font-bold mb-2"
                            for="first_name">
                            Nombre
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="first_name" type="text" name="first_name" placeholder="Nombre" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-600 text-xs font-bold mb-2"
                            for="last_name">
                            Apellidos
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                            id="last_name" type="text" name="last_name" placeholder="Apellidos" required>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-600 text-xs font-bold mb-2"
                            for="email">
                            Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="email" type="email" name="email" placeholder="********@*****.**" required>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-600 text-xs font-bold mb-2"
                            for="message">
                            Mensaje
                        </label>
                        <textarea rows="6"
                            class="appearance-none block w-full bg-gray-200 text-gray-300 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="message" name="message" required></textarea>
                    </div>
                </div>
                <div class="flex justify-between w-full px-3">
                    <div class="md:flex md:items-center">
                        <label class="block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" type="checkbox" name="newsletter">
                            <span class="text-sm">
                                Regístrame en tu newsletter
                            </span>
                        </label>
                    </div>
                    <button
                        class="shadow bg-indigo-600 hover:bg-indigo-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 rounded"
                        type="submit">
                        Enviar mensaje
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
