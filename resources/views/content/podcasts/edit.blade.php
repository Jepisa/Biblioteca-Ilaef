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
    
    @if ($errors->any())
        <!-- Validation Errors -->
        <div class="mb-4" :errors="$errors">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>
    
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ route('book.update', ['slug' => $book->slug]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label class="block">Título</label>
        <input type="text" value="{{ $book->title }}" name="title">

        {{-- Botón Submit --}}
        <div class="mb-6 text-center">
            <button
                class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                type="submit"
            >
                Guardar
            </button>
        </div>
    </form>

</x-guest-layout>
