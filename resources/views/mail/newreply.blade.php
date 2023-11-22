<h1>{{ config('app.name'); }}</h1>

<p>Watched discussion "{{ $data['title'] }}" has received a new reply from {{ $data['author'] }}. Click the link below to view the comment:</p>

<p><a href="{{ $data['url'] }}">{{ $data['url'] }}</a></p>