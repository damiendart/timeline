<!doctype html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <link href="/assets/app.css" rel="stylesheet">
    <title>Timeline</title>
</head>
<body>
    <h1>Timeline</h1>
    <hr>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <input type="submit" value="{{ __('Logout') }}">
    </form>
    <hr>
    @foreach ($groupedEvents as $year => $months)
        <h2>{{ $year }}</h2>
        @foreach ($months as $month => $days)
            <h3>{{ $month }}</h3>
            @foreach ($days as $day => $events)
                <h4>{{ $day }}</h4>
                @foreach ($events as $event)
                    <h5>{{ $event->title }}</h5>
                    <ul>
                        <li><strong>Event date:</strong> {{ $event->date }}</li>
                        @if ($event->category !== null)
                            <li><strong>Event category:</strong> {{ $event->category->title }}</li>
                            <li><strong>Event category slug:</strong> {{ $event->category->slug }}</li>
                        @endif
                    </ul>
                    <p>{{ $event->description }}</p>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
    <script async src="/assets/app.js"></script>
</body>
</html>
