<x-app-layout>
    <h1 class="text-center block my-5 text-2xl text-white">{{ __('investigation-works.index.title').'('.$investigation_works->total().')' }}</h1>
    <div class="pagination">
        {{ $investigation_works->links() }}
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
                                    {{ __('investigation-works.index.table.header.title') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('investigation-works.index.table.header.synopsis') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('investigation-works.index.table.header.authors') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('investigation-works.index.table.header.topics') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('investigation-works.index.table.header.downloadable') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('investigation-works.index.table.header.extraimages') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($investigation_works as $investigation_work)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center flex-col">
                                            <div class="mb-3 flex h-40">
                                                <div class="flex-shrink-0 h-full mr-1">
                                                    <img class="h-full" src="{{ asset("storage/$investigation_work->coverImage") }}"
                                                        alt="">
                                                </div>
                                                @if (!empty($investigation_work->backCoverImage))
                                                    <div class="flex-shrink-0 h-full">
                                                        <img class="h-full"
                                                            src="{{ asset("storage/$investigation_work->backCoverImage") }}"
                                                            alt="">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="">
                                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width:340px;"
                                                    class="text-sm text-center font-medium text-gray-900"
                                                    title="{{ $investigation_work->title }}">
                                                    <a href="{{ route('investigationwork.show', ['slug' => $investigation_work->slug]) }}">{{ $investigation_work->title }}</a>
                                                </div>
                                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width:340px;"
                                                    class="text-sm text-center text-gray-500"
                                                    title="{{ $investigation_work->slug }}">
                                                    {{ $investigation_work->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p
                                            style="white-space: pre-line; height: 175px; width:340px; overflow: auto;">
                                            {{ $investigation_work->synopsis }}</p>
                                            {{-- @dd($investigation_work->synopsis ) --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <ul>
                                            @foreach ($investigation_work->authors as $author)
                                                <li>{{ $author->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <ul>
                                            @foreach ($investigation_work->topics as $topic)
                                                <li>{{ $topic->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if (isset($investigation_work->downloadable))
                                            <span class="text-gray-500"><a
                                                    href="{{ asset('storage/' . $investigation_work->downloadable) }}"
                                                    target="_blank">{{ __('general.confirmation.yes') }}</a></span>
                                        @else
                                            <span class="text-gray-500">{{ __('general.confirmation.no') }}</span>
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center flex-wrap w-20">
                                            @if($investigation_work->extraimages->count() >= 1)
                                                <span class="text-gray-500">{{ __('general.confirmation.yes') }}</span>
                                            @else
                                                <span class="text-gray-500">{{ __('general.confirmation.no') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('investigationwork.edit', ['slug' => $investigation_work->slug]) }}"
                                            class="text-indigo-600 hover:text-indigo-900"
                                            style="min-width: 20px; text-align:center; margin: 5px 0;"><i
                                                class="fas fa-edit text-lg"></i></a>
                                        <form class="" style="min-width: 20px; text-align:center; margin: 5px 0;"
                                            method="POST"
                                            action="{{ route('investigationwork.destroy', ['slug' => $investigation_work->slug]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a type="submit" href="{{ route('investigationwork.destroy', ['slug' => $investigation_work->slug]) }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-indigo-900">
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
        {{ $investigation_works->links() }}
    </div>

    <x-notification />

</x-app-layout>
