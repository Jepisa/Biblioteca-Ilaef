<x-app-layout>

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
    
    <div class="font-mono">
        <!-- Container -->
        <div class="container mx-auto">
            <div class="flex justify-center px-6 my-12">
                <!-- Row -->
                <div class="w-full">
                    <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                        <h3 class="text-2xl text-center">{{ __('books.create.title') }}</h3>
                        <form class="formCreateBook grid grid-cols-12 flex mt-2 gap-4" method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
                            @csrf
    
                            {{-- Titulo --}}
                            <div class="col-span-12 dashboardTitle_container">
                                <label class="text-sm mb-1 font-bold text-gray-700" for="title">
                                    {{ __('books.create.fields.title.label') }}
                                </label>
                                <input
                                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                    id="title"
                                    name="title"
                                    type="text"
                                    max="255"
                                    value="{{ old('title') }}"
                                    
                                    required
                                />
                            </div>
                            {{-- Autores y Temas --}}
                            <div class="col-span-12 grid grid-cols-12 flex gap-4 dashboardAutoresTemas_container">
                                {{-- Autores --}}
                                <div class="col-span-6">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="select">{{ __('books.create.fields.authors.label') }}</label>
                                    <select name="authors[]" id="authors" class="mt-2 form-select multi-select w-full" multiple="multiple" required>
                                        @foreach ($authors as $key => $author)
                                            <option value="{{ $author->id }}" {{ (old('authors') and in_array((string) $author->id, old('authors'))) ? 'selected' : '' }}>{{ $author->name }}</option>
                                        @endforeach
                                        @if (old('authors'))
                                            @foreach (old('authors') as $key => $newauthor)
                                                @if (!is_numeric($newauthor))
                                                    <option value="{{ $newauthor }}" selected>{{ $newauthor }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                {{-- Temas --}}
                                <div class="col-span-6">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="topics">{{ __('books.create.fields.topics.label') }}</label>
                                    <select name="topics[]" id="topics" class="mt-2 form-control multi-select w-full" multiple="multiple" required>
                                        @foreach ($topics as $key => $topic)
                                            <option value="{{ $topic->id }}" {{ (old('topics') and in_array((string) $topic->id, old('topics'))) ? 'selected' : '' }}>{{ $topic->name }}</option>
                                        @endforeach
                                        @if (old('topics'))
                                            @foreach (old('topics') as $key => $newTopic)
                                                @if (!is_numeric($newTopic))
                                                    <option value="{{ $newTopic }}" selected>{{ $newTopic }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- Sinopsis, Nota y Año --}}
                            <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                {{-- Sinopsis --}}
                                <div class="col-span-6">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="synopsis">
                                        {{ __('books.create.fields.synopsis.label') }}
                                    </label>
                                    <textarea
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="synopsis"
                                        name="synopsis"
                                        rows="3"
                                        cols="50"
                                        maxlength="1200"
                                    >{{ old('synopsis') }}</textarea>
                                </div>
                                {{-- Nota --}}
                                <div class="col-span-6">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="note">
                                        {{ __('books.create.fields.notes.label') }}
                                    </label>
                                    <textarea
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="note"
                                        name="note"
                                        rows="3"
                                        cols="20"
                                        maxlength="600"
                                    >{{ old('note') }}</textarea>
                                </div>
                            </div>
                            {{-- Colección, Edición, Editorial e Idioma --}}
                            <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                {{-- Colección --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="collection">
                                        {{ __('books.create.fields.collection.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"                                    id="collection"
                                        name="collection"
                                        value="{{ old('collection') }}"
                                        type="text"
                                        max="255"
                                    />
                                </div>
                                {{-- Edición --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="edition">
                                        {{ __('books.create.fields.edition.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"                                    id="edition"
                                        name="edition"
                                        value="{{ old('edition') }}"
                                        type="text"
                                        max="255"
                                    />
                                </div>
                                {{-- Editorial --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="editorial">
                                        {{ __('books.create.fields.editorial.label') }}
                                    </label>
                                    <input
                                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"                                    id="editorial"
                                        name="editorial"
                                        value="{{ old('editorial') }}"
                                        type="text"
                                        max="255"
                                        required
                                    />
                                </div>
                                {{-- Año --}}
                                <div class="col-span-1">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="year">
                                        {{ __('books.create.fields.year.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="year"
                                        name="year"
                                        type="number"
                                        value="{{ old('year') }}"
                                        min="1000"
                                        max="3000"
                                    />
                                </div>
                                {{-- Idioma --}}
                                <div class="col-span-2">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="language_id">
                                        {{ __('books.create.fields.language.label') }}
                                    </label>
                                    <select name="language_id" id="language_id" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent" required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" {{ (old('language_id') and old('language_id') == $language->id) ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Ciudad, País, Páginas e ISBN --}}
                            <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                {{-- Ciudad --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="city">
                                        {{ __('books.create.fields.city.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        type="text"
                                        max="255"
                                    />
                                </div>
                                {{-- País --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="country_id">
                                        {{ __('books.create.fields.country.label') }}
                                    </label>
                                    <select name="country_id" id="country_id" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent" required>
                                        @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{(old('country_id') and old('country_id') == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Páginas --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="pages">
                                        {{ __('books.create.fields.pages.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="pages"
                                        name="pages"
                                        value="{{ old('pages') }}"
                                        type="number"
                                        min="1"
                                    />
                                </div>
                                {{-- ISBN --}}
                                <div class="col-span-3">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="isbn">
                                        {{ __('books.create.fields.isbn.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        id="isbn"
                                        name="isbn"
                                        value="{{ old('isbn') }}"
                                        type="text"
                                        max="255"
                                        placeholder="{{ __('books.create.fields.isbn.placeholder') }}"
                                    />
                                </div>
                            </div>
                            {{-- URL --}}
                            <div class="col-span-12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="url">
                                    {{ __('books.create.fields.url.label') }}
                                </label>
                                <input 
                                class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                name="url" id="url" type="url" value="{{ old('url') }}">
                            </div>
                            {{-- Archivo descargable, Imagen de Tapa, Imagen de Contratapa, Imagenes extras y Audiolibro --}}
                            <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                    {{-- Archivo descargable --}}
                                    <div class="col-span-4">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="downloadable">
                                            {{ __('books.create.fields.downloadable.label') }}
                                        </label>
                                        <input id="downloadable" name="downloadable" type="file" accept=".pdf,.doc"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent"
                                        >
                                    </div>
                                    
                                    {{-- Imagen de tapa --}}
                                    <div class="col-span-4">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="coverImage">
                                            {{ __('books.create.fields.cover.label') }}
                                        </label>
                                        <input id="coverImage" name="coverImage" type="file" accept=".jpg,.png,.jpeg" required
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent">
                                    </div>
                                    {{-- Imagen de contratapa --}}
                                    <div class="col-span-4">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="backCoverImage">
                                            {{ __('books.create.fields.backcover.label') }}
                                        </label>
                                        <input id="backCoverImage" name="backCoverImage" type="file" accept=".jpg,.png,.jpeg" 
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent">
    
                                    </div>
                                </div>
                                <div class="col-span-12 grid grid-cols-12 flex gap-4">
                                    {{-- Imagenes extras --}}
                                    <div class="col-span-4">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="extraImages">
                                            {{ __('books.create.fields.extraimages.label') }}
                                        </label>
                                        <input id="extraImages" name="extraImages[]" type="file" accept=".jpg,.png,.jpeg" multiple
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent">
    
                                    </div>
                                    {{-- Audiolibro --}}
                                    <div class="col-span-4">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="audioBook">
                                            {{ __('books.create.fields.audiobook.label') }}
                                        </label>
                                        <input id="audioBook" name="audioBook" type="file" accept=".mp3,.wma,.aac"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-none focus:ring-offset-0 focus:ring-offset-transparent focus:ring-transparent">
    
                                    </div>
    
                                    {{-- Botón Submit --}}
                                    <div class="col-span-4 items-end flex">
                                    <button
                                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        type="submit"
                                    >
                                    {{ __('books.create.buttons.submit') }}
                                    </button>
                                </div>
                                </div>
                            </div>                      
    
    
    
    
    
                            <hr class="mb-6 border-t" />
                            {{-- <div class="text-center">
                                <a
                                    class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                    href="#"
                                >
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="text-center">
                                <a
                                    class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                    href="./index.html"
                                >
                                    Already have an account? Login!
                                </a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-notification />
    
    <x-slot name="css">
        <link rel="stylesheet" href="{{ asset('css/original/select2.min.css') }}">
    </x-slot>
    <x-slot name="scripts">
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    </x-slot>
    <x-slot name="scriptsDown">
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script>
            $(".multi-select").select2({
                tags: true,
            })
        </script>
    </x-slot>
    
    </x-app-layout>