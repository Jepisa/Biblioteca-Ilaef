<x-app-layout>

    <div style="border: 1px solid white; width: 90%; margin: 50px auto 0 auto; padding: 5px; display:flex;">
        <div style="width: 50%">
            <h1 class="">{{ $ebook->title }}</h1>
            @foreach ($ebook->authors as $author)
                <h4>{{ $author->name }}</h4>
            @endforeach
            <div>
                <p>{{ __('ebooks.show.fields.synopsis').': '.$ebook->synopsis }}</p>
                <p>{{ __('ebooks.show.fields.year').': '.$ebook->year }}</p>
                <p>{{ __('ebooks.show.fields.editorial').': '.$ebook->editorial }}</p>
                <p>{{ __('ebooks.show.fields.language').': '.$ebook->lenguage }}</p>
                <p>{{ __('ebooks.show.fields.city').': '.$ebook->city }}</p>
                <p>{{ __('ebooks.show.fields.url').': '.$ebook->url }}</p>
                <p>{{ __('ebooks.show.fields.compatibility').': '.$ebook->compatibility }}</p>
                <p>{{ __('ebooks.show.fields.pages').': '.$ebook->pages }}</p>
            </div>
        </div>
        <div style="width: 50%; display:flex; justify-content:flex-end;">
            <img src="{{ asset('storage/'.$ebook->coverImage) }}">
        </div>
    </div>

    <x-notification />

</x-app-layout>
