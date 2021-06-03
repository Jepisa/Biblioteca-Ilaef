<x-app-layout>

    <div style="border: 1px solid white; width: 90%; margin: 50px auto 0 auto; padding: 5px; display:flex;">
        <div style="width: 50%">
            <h1 class="">{{ $investigation_work->title }}</h1>
            @foreach ($investigation_work->authors as $author)
                <h4>{{ $author->name }}</h4>
            @endforeach
            <div>
                <p>{{ __('investigation-works.show.fields.synopsis').': '.$investigation_work->synopsis }}</p>
                <p>{{ __('investigation-works.show.fields.year').': '.$investigation_work->year }}</p>
                <p>{{ __('investigation-works.show.fields.language').': '.$investigation_work->lenguage }}</p>
                <p>{{ __('investigation-works.show.fields.city').': '.$investigation_work->city }}</p>
                <p>{{ __('investigation-works.show.fields.url').': '.$investigation_work->url }}</p>
                <p>{{ __('investigation-works.show.fields.pages').': '.$investigation_work->pages }}</p>
            </div>
        </div>
        <div style="width: 50%; display:flex; justify-content:flex-end;">
            <img src="{{ asset('storage/'.$investigation_work->coverImage) }}">
        </div>
    </div>

    <x-notification />

</x-app-layout>
