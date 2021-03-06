{{ $topics->count() }}
<ul>
    @foreach ($topics as $topic)
        <li>{{ $topic->name }}</li>
    @endforeach
</ul>