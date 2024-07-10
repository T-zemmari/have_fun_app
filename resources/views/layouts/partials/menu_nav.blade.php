<!-- resources/views/layouts/partials/breadcrumbs.blade.php -->
<nav class="p-3 rounded mb-4 bg-gray-100">
    <ol class="list-reset flex text-gray-700">
        <li><a href="{{ route('landing') }}" class="text-blue-600 hover:underline">Inicio</a></li>
        @if(Request::segment(1) === 'juegos')
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('coleccion') }}" class="text-blue-600 hover:underline">Juegos</a></li>
        @endif
        @if(Request::segment(2))
            <li><span class="mx-2">/</span></li>
            <li>{{ ucwords(str_replace('-', ' ', Request::segment(2))) }}</li>
        @endif
    </ol>
</nav>
