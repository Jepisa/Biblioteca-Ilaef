<x-app-layout>
    <h1 class="text-center block my-5 text-2xl text-white">{{ __('books.index.title').'('.$books->total().')' }}</h1>
    <div class="pagination">
        {{ $books->links() }}
    </div>
    <div class="flex flex-col w-11/12 m-auto mb-5">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.title') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.synopsis') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.authors') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.topics') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.audiobook') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.downloadable') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('books.index.table.header.extraimages') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($books as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center flex-col">
                                            <div class="mb-3">
                                                <div class="flex-shrink-0 w-20 mr-1">
                                                    <img class="w-full" src="{{ asset("storage/$book->coverImage") }}"
                                                        alt="">
                                                </div>
                                                @if (!empty($book->backCoverImage))
                                                    <div class="flex-shrink-0 w-20">
                                                        <img class="w-full"
                                                            src="{{ asset("storage/$book->backCoverImage") }}"
                                                            alt="">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="">
                                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width:340px;"
                                                    class="text-sm text-center font-medium text-gray-900"
                                                    title="{{ $book->title }}">
                                                    <a href="{{ route('book.show', ['slug' => $book->slug]) }}">{{ $book->title }}</a>
                                                </div>
                                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width:340px;"
                                                    class="text-sm text-center text-gray-500"
                                                    title="{{ $book->slug }}">
                                                    {{ $book->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p
                                            style="white-space: break-spaces; height: 175px; width:340px; overflow: auto;">
                                            {{ $book->synopsis }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <ul>
                                            @foreach ($book->authors as $author)
                                                <li>{{ $author->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <ul>
                                            @foreach ($book->topics as $topic)
                                                <li>{{ $topic->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if (isset($book->audiobook))
                                            <span class="text-gray-500">{{ __('general.confirmation.yes') }}</span>
                                        @else
                                            <span class="text-gray-500">{{ __('general.confirmation.no') }}</span>
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if (isset($book->downloadable))
                                            <span class="text-gray-500"><a
                                                    href="{{ asset('storage/' . $book->downloadable) }}"
                                                    target="_blank">{{ __('general.confirmation.yes') }}</a></span>
                                        @else
                                            <span class="text-gray-500">{{ __('general.confirmation.no') }}</span>
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center flex-wrap w-20">
                                            @if($book->extraimages->count() >= 1)
                                                <span class="text-gray-500">{{ __('general.confirmation.yes') }}</span>
                                            @else
                                                <span class="text-gray-500">{{ __('general.confirmation.no') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('book.edit', ['slug' => $book->slug]) }}"
                                            class="text-indigo-600 hover:text-indigo-900"
                                            style="min-width: 20px; text-align:center; margin: 5px 0;"><i
                                                class="fas fa-edit text-lg"></i></a>
                                        <form class="" style="min-width: 20px; text-align:center; margin: 5px 0;"
                                            method="POST"
                                            action="{{ route('book.destroy', ['slug' => $book->slug]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a type="submit" href="{{ route('book.destroy', ['slug' => $book->slug]) }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-indigo-900">
                                                <i class="fas fa-trash-alt text-lg"></i>
                                            </a>

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
    <div class="pagination">
        {{ $books->links() }}
    </div>

    <x-notification />

</x-app-layout>
