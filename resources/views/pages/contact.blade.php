@php ($pageTitle = "Contact")

@include('includes.header')

<div class="page-title">
	Contact
</div>

<div class="row">
	<div class="col">
		<p>Send a message to the forum admin using the form below.</p>
		<form action="{{ route('contact.submit') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			@auth
				<input type="hidden" name="email" value="{{ Auth::user()->email }}" />
			@endauth
			@guest
				<div class="form-group">
					<label for="email">Email address</label>
					<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" style="max-width:300px;" required>
					<small id="emailHelp" class="form-text text-muted">Please enter a valid email so we can reply to your message.</small>
				</div>
				<br>
			@endguest
			<div class="form-group">
				<label for="content">Message</label>
				<textarea name="content" class="form-control" id="content" rows="3" required></textarea>
			</div>
			<br>
			<button type="submit" class="btn btn-primary">Submit</button>
			<br>
	</div>
</div>

@include('includes.footer')