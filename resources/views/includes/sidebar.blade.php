@auth
	<div class="card sidebar-user-card">
	    <div class="card-body">
			<h3>Hi, {{ Auth::user()->username }}!</h3>
			<p>Welcome back to the forum.</p>
			<a class="btn btn-primary btn-sm" href="{{ route('logout.perform') }}" role="button">Logout</a>
		</div>
	</div>
@endauth
@guest
	<div class="card sidebar-user-card">
	    <div class="card-body">
			<h3>Hi, Guest!</h3>
			<p>You are viewing the forum as a guest. To post or reply, you must sign in or create a free account.</p>
			<a class="btn btn-primary btn-sm" href="{{ route('login.perform') }}" role="button">Sign In</a><a class="btn btn-sm btn-primary" href="{{ route('register.perform') }}" role="button">Create Account</a>
		</div>
	</div>
@endguest
