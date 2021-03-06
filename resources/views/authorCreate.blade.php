<x-guest-layout>
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block bg-gray-100 bg-opacity-50">
        @auth
        <a href="{{ url('/book/create') }}" class="text-sm text-gray-700 underline m-2">Crear Libro</a>
        <a href="{{ url('/books') }}" class="text-sm text-gray-700 underline m-2">Lista de Libros</a>
        <a href="{{ url('/') }}" class="text-sm text-gray-700 underline m-2" >Inicio</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline m-2">Login</a>
    
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline m-2">Register</a>
            @endif
        @endauth
    </div>

    <div class="w-6/12 m-auto">
        <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ route('author.store') }}">
            @csrf
            <label class="block">Escribi los authores</label>
            <span class="text-gray-400 block">Puedes crear varios autores separandolos con una ',' (coma) y un ' '(espacio)
            <input type="text" name="authorsName">
            <input type="submit" value="Crear" >
        </form>
    </div>

</x-guest-layout>