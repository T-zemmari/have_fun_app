<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : config('app.name', 'ScrapBook Community') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="w-full min-h-screen flex flex-col justify-start items-start">
        <div class="w-full h-[100%]">
            {{ $slot }}
        </div>
        @include('layouts.partials.footer')
    </div>
    <script src="{{ asset('/assets/js/jquery_3_7_1.js') }}"></script>
    <script src="{{ asset('/assets/js/swt.js') }}"></script>
    <script src="{{ asset('/assets/js/doc_scripts.js') }}"></script>
    <script src="{{ asset('/assets/js/funciones_varias.js') }}"></script>
    <script src="{{ asset('assets/js/juegos_js/tetris_1.js') }}"></script>

    <!-- Scripts -->
    <script>
        function togglePassword(inputId, action) {
            const input = document.getElementById(inputId);
            const showButton = document.querySelector(`#${inputId}`).nextElementSibling;
            const hideButton = showButton.nextElementSibling;
            if (input) {
                if (action === 'show') {
                    input.type = 'text';
                    showButton.classList.add('hidden');
                    hideButton.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    showButton.classList.remove('hidden');
                    hideButton.classList.add('hidden');
                }
            }
        }
    </script>

</body>

</html>
