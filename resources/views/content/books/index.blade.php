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
    
    <h1 class="text-center block my-12">Libros ({{$books->count()}})</h1>

    <!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col w-11/12 m-auto">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Sinopsis
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Author/s
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Topic/s
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Slug
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Audio Libro
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Extra Images
                </th>
                {{-- <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th> --}}
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($books as $book)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center flex-col">
                                <div class="mb-3">
                                    <div class="flex-shrink-0 w-20 mr-1">
                                        <img class="w-full" src="{{ asset("storage/$book->coverImage") }}" alt="">
                                    </div>
                                    <div class="flex-shrink-0 w-20">
                                        <img class="w-full" src="{{ asset("storage/$book->backCoverImage") }}" alt="">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-sm text-center font-medium text-gray-900">
                                        {{ $book->title }}
                                    </div>
                                    <div class="text-sm text-center text-gray-500">
                                        {{ $book->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p style="white-space: break-spaces; height: 175px; overflow: auto;">{{ $book->synopsis }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <ul>
                                @foreach ($book->authors as $author)
                                    <li>{{ $author->name }}</li>
                                @endforeach
                            </ul>
                        {{-- <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                        <div class="text-sm text-gray-500">Optimization</div> --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <ul>
                                @foreach ($book->topics as $topic)
                                    <li>{{ $topic->name }}</li>
                                @endforeach
                            </ul>
                        {{-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span> --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $book->slug }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if(isset($book->audiobook))
                                <span class="text-gray-500">Sí</span>
                            @else
                                <span class="text-gray-500">NO</span>
                            @endif
                            
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center flex-wrap w-20">
                                @foreach ($book->extraimages as $image)
                                    <div class="flex-shrink-0 h-10 m-1">
                                        <img class="h-full" src="{{ asset("storage/$image->image") }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('book.edit', ['slug' => $book->slug]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form method="POST" action="{{ route('book.destroy', ['slug' => $book->slug]) }}">
                            @csrf
                            @method('DELETE')
                            <a type="submit" href="{{route('book.destroy', ['slug' => $book->slug])}}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600 hover:text-indigo-900">Delete</a>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
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

</x-guest-layout>