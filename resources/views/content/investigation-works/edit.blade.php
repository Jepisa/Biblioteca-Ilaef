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
                        <h3 class="pt-4 text-2xl text-center">{{ __('investigation-works.edit.title') }}</h3>
                        <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ route('investigationwork.update', ['slug' => $investigation_work->slug]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
    
                            {{-- Titulo --}}
                            <div class="mb-2 w-6/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="title">
                                    {{ __('investigation-works.edit.fields.title.label') }}
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="title"
                                    name="title"
                                    type="text"
                                    max="255"
                                    value="{{ old('title') ? old('title') : $investigation_work->title }}"
                                    required
                                />
                            </div>
                            {{-- Autores y Temas --}}
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Autores --}}
                                <div class="w-5/12 mb-2" >
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="select">{{ __('investigation-works.edit.fields.authors.label') }}</label>
                                    <select name="authors[]" id="authors" class="form-control multi-select" multiple="multiple" required>
                                        @foreach ($authors as $author)
                                            @if(old('authors'))
                                                <option value="{{ $author->id }}" {{ (in_array((string) $author->id, old('authors'))) ? 'selected' : '' }}>{{ $author->name }}</option>
                                            @else
                                                <option value="{{ $author->id }}" {{ (in_array((string) $author->id, $investigation_work->authors_id)) ? 'selected' : '' }}>{{ $author->name }}</option>
                                            @endif
                                        @endforeach
                                        @if (old('authors'))
                                            @foreach (old('authors') as $newauthor)
                                                @if (!is_numeric($newauthor))
                                                    <option value="{{ $newauthor }}" selected>{{ $newauthor }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                {{-- Temas --}}
                                <div class="w-5/12 mb-2" >
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="topics">{{ __('investigation-works.edit.fields.topics.label') }}</label>
                                    <select name="topics[]" id="topics" class="form-control multi-select" multiple="multiple" required>
                                        @foreach ($topics as $topic)
                                            @if(old('topics'))
                                                <option value="{{ $topic->id }}" {{ (in_array((string) $topic->id, old('topics'))) ? 'selected' : '' }}>{{ $topic->name }}</option>
                                            @else
                                                <option value="{{ $topic->id }}" {{ (in_array((string) $topic->id, $investigation_work->topics_id)) ? 'selected' : '' }}>{{ $topic->name }}</option>
                                            @endif
                                        @endforeach
                                        @if (old('topics'))
                                            @foreach (old('topics') as $newtopic)
                                                @if (!is_numeric($newtopic))
                                                    <option value="{{ $newtopic }}" selected>{{ $newtopic }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- Sinopsis, Nota y Año --}}
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Sinopsis --}}
                                <div class="mb-2 w-4/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="synopsis">
                                        {{ __('investigation-works.edit.fields.synopsis.label') }}
                                    </label>
                                    <textarea
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="synopsis"
                                        name="synopsis"
                                        rows="2"
                                        cols="50"
                                        maxlength="1200"
                                    >{{ old('synopsis') ? old('synopsis') : $investigation_work->synopsis }}</textarea>
                                </div>
                                {{-- Nota --}}
                                <div class="mb-2 w-4/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="note">
                                        {{ __('investigation-works.edit.fields.notes.label') }}
                                    </label>
                                    <textarea
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="note"
                                        name="note"
                                        rows="2"
                                        cols="20"
                                        maxlength="600"
                                    >{{ old('note') ? old('note') : $investigation_work->note }}</textarea>
                                </div>
                                {{-- Año --}}
                                <div class="mb-2 w-4/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="year">
                                        {{ __('investigation-works.edit.fields.year.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="year"
                                        name="year"
                                        type="number"
                                        value="{{ old('year') ? old('year') : $investigation_work->year }}"
                                        min="1000"
                                        max="3000"
                                    />
                                </div>
                            </div>
                            {{-- Fuentes e Idioma --}}
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Fuentes --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="sources">
                                        {{ __('investigation-works.edit.fields.sources.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="sources"
                                        name="sources"
                                        value="{{ old('sources') ? old('sources') : $investigation_work->sources }}"
                                        type="text"
                                        max="255"
                                    />
                                </div>
                                {{-- Idioma --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="language_id">
                                        {{ __('investigation-works.edit.fields.language.label') }}
                                    </label>
                                    <select name="language_id" id="language_id" class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                                        @foreach ($languages as $language)
                                            @if(old('language_id'))
                                                <option value="{{ $language->id }}" {{ ( old('language_id') == $language->id) ? 'selected' : '' }}>{{ $language->name }}</option>
                                            @else
                                                <option value="{{ $language->id }}" {{ ( $investigation_work->language_id == $language->id) ? 'selected' : '' }}>{{ $language->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Ciudad, País, Páginas e ISBN --}}
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Ciudad --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="city">
                                        {{ __('investigation-works.edit.fields.city.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') ? old('city') : $investigation_work->city }}"
                                        type="text"
                                        max="255"
                                    />
                                </div>
                                {{-- País --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="country_id">
                                        {{ __('investigation-works.edit.fields.country.label') }}
                                    </label>
                                    <select name="country_id" id="country_id" class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                                        @foreach ($countries as $country)
                                        @if(old('country_id'))
                                            <option value="{{ $country->id }}" {{ ( old('country_id') == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}" {{ ( $investigation_work->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Páginas --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="pages">
                                        {{ __('investigation-works.edit.fields.pages.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="pages"
                                        name="pages"
                                        value="{{ old('pages') ? old('pages') : $investigation_work->pages }}"
                                        type="number"
                                        min="1"
                                    />
                                </div>
                                {{-- ISBN --}}
                                <div class="mb-2 w-3/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="isbn">
                                        {{ __('investigation-works.edit.fields.isbn.label') }}
                                    </label>
                                    <input
                                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        id="isbn"
                                        name="isbn"
                                        value="{{ old('isbn') ? old('isbn') : $investigation_work->isbn }}"
                                        type="text"
                                        max="255"
                                        placeholder="{{ __('investigation-works.edit.fields.isbn.placeholder') }}"
                                    />
                                </div>
                            </div>
                            {{-- URL --}}
                            <div class="mb-2">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="url">
                                    {{ __('investigation-works.edit.fields.url.label') }}
                                </label>
                                <input name="url" id="url" type="url" value="{{ old('url') ? old('url') : $investigation_work->url }}">
                            </div>
                            {{-- Archivo descargable, Imagen de Tapa, Imagen de Contratapa, Imagenes extras --}}
                            <div class="archivos w-10/12">
                                <div class="mb-4 md:flex md:justify-between">
                                    {{-- Archivo descargable --}}
                                    <div class="mb-2 w-2/12">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="downloadable">
                                            {{ __('investigation-works.edit.fields.downloadable.label') }}
                                        </label>
                                        <input id="downloadable" name="downloadable" type="file" accept=".pdf,.doc">
                                    </div>
                                    
                                    {{-- Imagen de tapa --}}
                                    <div class="mb-2 w-2/12">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="coverImage">
                                            {{ __('investigation-works.edit.fields.cover.label') }}
                                        </label>
                                        <input id="coverImage" name="coverImage" type="file" accept=".jpg,.png,.jpeg">
                                    </div>
                                    {{-- Imagen de contratapa --}}
                                    <div class="mb-2 w-2/12">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="backCoverImage">
                                            {{ __('investigation-works.edit.fields.backcover.label') }}
                                        </label>
                                        <input id="backCoverImage" name="backCoverImage" type="file" accept=".jpg,.png,.jpeg" >
                                    </div>
                                </div>
                                <div class="mb-4 md:flex md:justify-between">
                                    {{-- Imagenes extras --}}
                                    <div class="mb-2 w-2/12">
                                        <label class="block mb-1 text-sm font-bold text-gray-700" for="extraImages">
                                            {{ __('investigation-works.edit.fields.extraimages.label') }}
                                        </label>
                                        <input id="extraImages" name="extraImages[]" type="file" accept=".jpg,.png,.jpeg" multiple>
                                    </div>
                                </div>
                            </div>
                            
    
    
    
    
                            {{-- Botón Submit --}}
                            <div class="mb-6 text-center">
                                <button
                                    class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                    type="submit"
                                >
                                {{ __('investigation-works.edit.buttons.submit') }}
                                </button>
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
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
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
    