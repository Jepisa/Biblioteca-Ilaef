<x-app-layout>

    <div style="border: 1px solid white; width: 90%; margin: 50px auto 0 auto; padding: 5px; display:flex;">
        <div style="width: 50%">
            <h1 class="">{{ $book->title }}</h1>
            @foreach ($book->authors as $author)
                <h4>{{ $author->name }}</h4>
            @endforeach
            <div>
                <p>{{ __('books.show.fields.synopsis').': '.$book->synopsis }}</p>
                <p>{{ __('books.show.fields.year').': '.$book->year }}</p>
                <p>{{ __('books.show.fields.editorial').': '.$book->editorial }}</p>
                <p>{{ __('books.show.fields.language').': '.$book->lenguage }}</p>
                <p>{{ __('books.show.fields.city').': '.$book->city }}</p>
                <p>{{ __('books.show.fields.url').': '.$book->url }}</p>
                <p>{{ __('books.show.fields.pages').': '.$book->pages }}</p>
            </div>
        </div>
        <div style="width: 50%; display:flex; justify-content:flex-end;">
            <img src="{{ asset('storage/'.$book->coverImage) }}">
        </div>
        <audio src="{{ asset('storage/'.$book->audiobook) }}" controls>
            Your browser does not support the <code>audio</code> element.
        </audio>
    </div>

    <x-notification />

</x-app-layout>
