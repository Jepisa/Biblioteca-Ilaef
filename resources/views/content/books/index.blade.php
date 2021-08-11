@extends('adminlte::page')

@section('title', 'Panel de Control')

@section('plugins.Sweetalert2', true)


@section('content_header')
    
@stop

@section('content')
    
    <style>

        .h1-shadow{
            text-shadow: 2px 3px 3px gray;
        }
        .bg-thead-black{
            background-color:#121416;
        }

        .th-authors{
            min-width: 260px;
        }

        .th-topics{
            min-width: 175px;
        }
        .th-audiobook{
            min-width: 113.04px;
        }

        .th-downloadable{
            min-width: 177.74px;
        }

        .th-extraimages{
            min-width: 147.17px;
        }
        
        .td-title{
            width: 500px;
        }

        .td-image{
            height:150px;
        }
        .td-title-link{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width:340px;
            margin:auto;
        }

        .text-aqua{
            color: #00ffff;
        }
        .text-aqua:hover{
            color:#00ffffb0;
        }

        .td-synopsis{
            white-space: pre-line;
            height: 170px;
            width: 340px;
            overflow: auto;
        }

        .td-icon-action{
            min-width: 20px;
            text-align:center;
            margin: 5px 0;
        }
    </style>
    <h1 class="text-center block text-2xl h1-shadow">{{ __('books.index.title').'('.$books->total().')' }}</h1>
    <div class="mb-4 d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('book.create') }}">{{ __('books.create.title') }}</a>
    </div>

    <div class="pagination">
        {{ $books->links('vendor.pagination.bootstrap-4') }}
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="bg-thead-black">
                <tr class="text-center">
                    <th scope="col">
                        {{ __('books.index.table.header.title') }}
                    </th>
                    <th scope="col">
                        {{ __('books.index.table.header.synopsis') }}
                    </th>
                    <th scope="col" class="th-authors">
                        {{ __('books.index.table.header.authors') }}
                    </th>
                    <th scope="col" class="th-topics">
                        {{ __('books.index.table.header.topics') }}
                    </th>
                    <th scope="col" class="th-audiobook">
                        {{ __('books.index.table.header.audiobook') }}
                    </th>
                    <th scope="col" class="th-downloadable">
                        {{ __('books.index.table.header.downloadable') }}
                    </th>
                    <th scope="col" class="th-extraimages">
                        {{ __('books.index.table.header.extraimages') }}
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="text-center td-title">
                            <div class="d-flex flex-column ">
                                <div class="mb-3 d-flex justify-content-center h-40">
                                    <div class="mw-100">
                                        <img src="{{ asset("storage/$book->coverImage") }}"
                                            alt="" class="td-image"> 
                                    </div>
                                    @if (!empty($book->backCoverImage))
                                        <div class="mw-100 ml-2">
                                            <img src="{{ asset("storage/$book->backCoverImage") }}"
                                                alt="" class="td-image">
                                        </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="td-title-link"
                                        title="{{ $book->title }}">
                                        <a class="text-aqua" href="{{ route('book.show', ['slug' => $book->slug]) }}">{{ $book->title }}</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="td-synopsis  ">
                                {{ $book->synopsis }}
                            </p>
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
                        <td class="px-6 py-4 text-center">
                            @if (isset($book->audiobook))
                                <span>{{ __('general.confirmation.yes') }}</span>
                            @else
                                <span>{{ __('general.confirmation.no') }}</span>
                            @endif

                        </td>
                        <td class="px-6 py-4 text-center">
                            @if (isset($book->downloadable))
                                <span><a
                                        href="{{ asset('storage/' . $book->downloadable) }}"
                                        target="_blank">{{ __('general.confirmation.yes') }}</a></span>
                            @else
                                <span>{{ __('general.confirmation.no') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($book->extraimages->count() >= 1)
                                <span>{{ __('general.confirmation.yes') }}</span>
                            @else
                                <span>{{ __('general.confirmation.no') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('book.edit', ['slug' => $book->slug]) }}"
                                class="hover:text-indigo td-icon-action">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <form class="td-icon-action="
                                method="POST"
                                action="{{ route('book.destroy', ['slug' => $book->slug]) }}">
                                @csrf
                                @method('DELETE')
                                <a type="submit" href="{{ route('book.destroy', ['slug' => $book->slug]) }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $books->links('vendor.pagination.bootstrap-4') }}
    </div>

    <x-notification />
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
@stop

@section('js')
    {{-- <script>
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        )
    </script> --}}
@stop
