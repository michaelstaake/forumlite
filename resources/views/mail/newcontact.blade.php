<h1>{{ config('app.name'); }}</h1>

<p>A new contact form submissions has been recieved from your forum.</p>

<p>Email: {{ $data['email'] }}</p>

<p>Message: {{ $data['content'] }}</p>