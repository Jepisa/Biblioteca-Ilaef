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
                            <div class="flex items-center">
                                <div>
                                    <div class="flex-shrink-0 w-10">
                                        <img class="w-full" src="{{ asset("storage/$book->coverImage") }}" alt="">
                                    </div>
                                    <div class="flex-shrink-0 w-10">
                                        <img class="w-full" src="{{ asset("storage/$book->backCoverImage") }}" alt="">
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $book->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $book->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p style="white-space: break-spaces;">{{ $book->synopsis }}</p>
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
                            @isset($book->audiobook)
                                <audio controls>
                                <source src="{{ asset("storage/".$book->audiobook) }}" type="audio/mpeg">
                                Tú navegador no soporta este audio.
                            </audio>
                            @endisset
                            
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
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>