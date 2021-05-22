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
                <!-- Col -->
                {{-- <div
                    class="w-full h-auto bg-gray-400 hidden lg:block lg:w-5/12 bg-cover rounded-l-lg"
                    style="background-image: url('https://source.unsplash.com/Mv9hjnEUHR4/600x800')"
                ></div> --}}
                <!-- Col -->
                <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                    <h3 class="pt-4 text-2xl text-center">Agrega un nuevo Podcast</h3>
                    h2
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ Route::is('podcast.create') ? route('podcast.store') : route('podcast.update',[ 'slug' => $podcast->slug]) }}" enctype="multipart/form-data">
                        @csrf
                        {{ Route::is('podcast.create') ? '' : method_field('PUT') }}

                        {{-- Titulo --}}
                        <div class="mb-2 w-6/12">
                            <label class="block mb-1 text-sm font-bold text-gray-700" for="title">
                                Titulo
                            </label>
                            <input
                                class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="title"
                                name="title"
                                type="text"
                                max="255"
                                value="{{ old('title') ?  old('title') : (Route::is('podcast.edit') ? $podcast->title : '') }}"
                                
                                required
                            />
                        </div>
                        {{-- Autores y Temas --}}
                        <div class="mb-4 md:flex md:justify-between">
                            {{-- Autores --}}
                            <div class="w-5/12 mb-2" >
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="select">Escribí los autores</label>
                                <span class="text-gray-400 block">Puedes crear varios autores separandolos solo con una ',' (coma).</span>
                                <input type="text" name="authorsName" value="{{ old('authorsName') ?  old('authorsName') : (Route::is('podcast.edit') ? $authorsName : '') }}" required>
                            </div>
                            {{-- Temas --}}
                            <div class="w-5/12 mb-2" >
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="topics">Escribí los temas</label>
                                <span class="text-gray-400 block">Puedes crear varios temas separandolos solo con una ',' (coma).</span>
                                <input type="text" name="topicsName" value="{{ old('topicsName') ?  old('topicsName') : (Route::is('podcast.edit') ? $topicsName : '') }}" required>
                            </div>
                        </div>
                        {{-- Sinopsis, Nota y Año --}}
                        <div class="mb-4 md:flex md:justify-between">
                            {{-- Sinopsis --}}
                            <div class="mb-2 w-4/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="synopsis">
                                    Sinopsis
                                </label>
                                <textarea
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="synopsis"
                                    name="synopsis"
                                    rows="2"
                                    cols="50"
                                    minlength="400"
                                    maxlength="1200"
                                    required
                                >{{ old('synopsis') ?  old('synopsis') : (Route::is('podcast.edit') ? $podcast->synopsis : '') }}</textarea>
                            </div>
                            {{-- Nota --}}
                            <div class="mb-2 w-4/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="note">
                                    Notas
                                </label>
                                <textarea
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="note"
                                    name="note"
                                    rows="2"
                                    cols="20"
                                    maxlength="600"
                                >{{ old('note') ?  old('note') : (Route::is('podcast.edit') ? $podcast->note : '') }}</textarea>
                            </div>
                            {{-- Año --}}
                            <div class="mb-2 w-4/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="year">
                                    Año
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="year"
                                    name="year"
                                    type="number"
                                    value="{{ old('year') ?  old('year') : (Route::is('podcast.edit') ? $podcast->year : '') }}"
                                    min="1000"
                                    max="3000"
                                />
                            </div>
                        </div>
                        {{-- Colección, Edición e Idioma --}}
                        <div class="mb-4 md:flex md:justify-between">
                            {{-- Colección --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="collection">
                                    Colección
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="collection"
                                    name="collection"
                                    value="{{ old('collection') ?  old('collection') : (Route::is('podcast.edit') ? $podcast->collection : '') }}"
                                    type="text"
                                    max="255"
                                />
                            </div>
                            {{-- Edición --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="edition">
                                    Edición
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="edition"
                                    name="edition"
                                    value="{{ old('edition') ?  old('edition') : (Route::is('podcast.edit') ? $podcast->edition : '') }}"
                                    type="text"
                                    max="255"
                                />
                            </div>
                            {{-- editorial --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="editorial">
                                    Editorial
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="editorial"
                                    name="editorial"
                                    value="{{ old('editorial') ?  old('editorial') : (Route::is('podcast.edit') ? $podcast->editorial : '') }}"
                                    type="text"
                                    max="255"
                                    required
                                />
                            </div>
                            {{-- Idioma --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="language_id">
                                    Idioma
                                </label>
                                <select name="language_id" id="language_id" class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" {{( (old('language_id') ?  old('language_id') : (Route::is('podcast.edit') ? $podcast->language_id : '')) == $language->id) ? 'selected' : ''}}>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Ciudad, País, Páginas e ISBN --}}
                        <div class="mb-4 md:flex md:justify-between">
                            {{-- Ciudad --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="city">
                                    Ciudad
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="city"
                                    name="city"
                                    value="{{ old('city') ?  old('city') : (Route::is('podcast.edit') ? $podcast->city : '') }}"
                                    type="text"
                                    max="255"
                                />
                            </div>
                            {{-- País --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="country_id">
                                    Páis
                                </label>
                                <select name="country_id" id="country_id" class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                                    @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{( (old('country_id') ?  old('country_id') : (Route::is('podcast.edit') ? $podcast->country_id : '')) == $country->id) ? 'selected' : ''}}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Páginas --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="pages">
                                    Páginas
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="pages"
                                    name="pages"
                                    value="{{ old('pages') ?  old('pages') : (Route::is('podcast.edit') ? $podcast->pages : '') }}"
                                    type="number"
                                    min="1"
                                />
                            </div>
                            {{-- ISBN --}}
                            <div class="mb-2 w-3/12">
                                <label class="block mb-1 text-sm font-bold text-gray-700" for="isbn">
                                    ISBN
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="isbn"
                                    name="isbn"
                                    value="{{ old('isbn') ?  old('isbn') : (Route::is('podcast.edit') ? $podcast->isbn : '') }}"
                                    type="text"
                                    max="255"
                                    placeholder="XXX-XX-XXX-XX"
                                />
                            </div>
                        </div>
                        {{-- URL --}}
                        <div class="mb-2">
                            <label class="block mb-1 text-sm font-bold text-gray-700" for="url">
                                URL
                            </label>
                            <input name="url" id="url" type="url" value="{{ old('url') ?  old('url') : (Route::is('podcast.edit') ? $podcast->url : '') }}">
                        </div>
                        {{-- Archivo descargable, Imagen de Tapa, Imagen de Contratapa, Imagenes extras y Audiolibro --}}
                        <div class="archivos w-10/12">
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Archivo descargable --}}
                                <div class="mb-2 w-2/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="downloadable">
                                    Archivo descargable
                                    </label>
                                    <input id="downloadable" name="downloadable" type="file" accept=".pdf,.doc">
                                </div>
                                
                                {{-- Imagen de tapa --}}
                                <div class="mb-2 w-2/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="coverImage">Imagen de tapa</label>
                                    <input id="coverImage" name="coverImage" type="file" accept=".jpg,.png,.jpeg" {{ Route::is('podcast.create') ?  'required' : '' }}>
                                </div>
                                {{-- Imagen de contratapa --}}
                                <div class="mb-2 w-2/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="backCoverImage">Imagen de contratapa</label>
                                    <input id="backCoverImage" name="backCoverImage" type="file" accept=".jpg,.png,.jpeg" >
                                </div>
                            </div>
                            <div class="mb-4 md:flex md:justify-between">
                                {{-- Imagenes extras --}}
                                <div class="mb-2 w-2/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="extraImages">Imagenes extras</label>
                                    <input id="extraImages" name="extraImages[]" type="file" accept=".jpg,.png,.jpeg" multiple>
                                </div>
                                {{-- Audiolibro --}}
                                {{-- <div class="mb-2 w-2/12">
                                    <label class="block mb-1 text-sm font-bold text-gray-700" for="audioBook">Audiolibro</label>
                                    <input id="audioBook" name="audioBook" type="file" accept=".mp3,.wma,.aac">
                                </div> --}}
                            </div>
                        </div>
                        




                        {{-- Botón Submit --}}
                        <div class="mb-6 text-center">
                            <button
                                class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                type="submit"
                            >
                            {{ Route::is('podcast.create') ? 'Registrar Libro'  : 'Actualizar Libro' }}
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

@if(Session()->exists('notification'))
        <div id="notification" class="flex bg-green-200 max-w-sm md:max-w-md mb-4" style="display:none; cursor:pointer; right: -150vw; top:5px; position:fixed; transition: right 2s;">
            <div class="w-16 bg-green-400">
                <div class="p-4">
                    <svg class="h-8 w-8 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M468.907 214.604c-11.423 0-20.682 9.26-20.682 20.682v20.831c-.031 54.338-21.221 105.412-59.666 143.812-38.417 38.372-89.467 59.5-143.761 59.5h-.12C132.506 459.365 41.3 368.056 41.364 255.883c.031-54.337 21.221-105.411 59.667-143.813 38.417-38.372 89.468-59.5 143.761-59.5h.12c28.672.016 56.49 5.942 82.68 17.611 10.436 4.65 22.659-.041 27.309-10.474 4.648-10.433-.04-22.659-10.474-27.309-31.516-14.043-64.989-21.173-99.492-21.192h-.144c-65.329 0-126.767 25.428-172.993 71.6C25.536 129.014.038 190.473 0 255.861c-.037 65.386 25.389 126.874 71.599 173.136 46.21 46.262 107.668 71.76 173.055 71.798h.144c65.329 0 126.767-25.427 172.993-71.6 46.262-46.209 71.76-107.668 71.798-173.066v-20.842c0-11.423-9.259-20.683-20.682-20.683z"/><path d="M505.942 39.803c-8.077-8.076-21.172-8.076-29.249 0L244.794 271.701l-52.609-52.609c-8.076-8.077-21.172-8.077-29.248 0-8.077 8.077-8.077 21.172 0 29.249l67.234 67.234a20.616 20.616 0 0 0 14.625 6.058 20.618 20.618 0 0 0 14.625-6.058L505.942 69.052c8.077-8.077 8.077-21.172 0-29.249z"/></svg>
                </div>
            </div>
            <div class="w-auto text-gray-500 items-center p-4">
                <span class="text-lg font-bold pb-4">
                    {{ __('Felicidades') }}
                </span>
                <p class="leading-tight">
                    {{ Session()->get('notification') }}
                </p>
            </div>
        </div>
    <script>
    window.addEventListener('DOMContentLoaded', (event) => {
        var notification = document.querySelector('#notification');

        if (notification) 
        {

            notification.style.display = "flex";
            
            setTimeout(() => {
                notification.style.right = "10px";
            }, 500);
            setTimeout(() => {
                notification.style.transition = "right 0.5s";
                notification.style.right = "1px";
            }, 2500);

            setTimeout(() => {
                sacarLaNotificacion();
            }, 5000);

            notification.addEventListener('click', (event) => {
                sacarLaNotificacion();
            });


            function sacarLaNotificacion()
            {
                notification.style.pointerEvents = "none";
                setTimeout(() => {
                    notification.style.right = "10px";
                }, 500);
                setTimeout(() => {
                    notification.style.transition = "right 2s";
                    notification.style.right = "-150vw";
                }, 1000);
                setTimeout(() => {
                    notification.remove();
                }, 3500);
            }

        }
    });
    </script>    
@endif

<x-slot name="scripts">
</x-slot>
<x-slot name="scriptsDown">
</x-slot>

</x-app-layout>