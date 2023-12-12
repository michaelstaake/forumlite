<h1>{{ config('app.name'); }}</h1>

<h6>Reported {{ $data['type'] }}</h6>

<p>{{ $data['summary'] }}</p>

<p><a href="{{ $data['url'] }}">{{ $data['url'] }}</a></p>