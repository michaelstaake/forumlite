@auth
	<!--<div class="card sidebar-user-card">
	    <div class="card-body">

			<h3><a href="/member/{{auth()->user()->username}}">{{auth()->user()->username}}</a></h3>
			<ul class="home-user-card-list"> 
	            <li><a href="/messages">Messages</a></li>
	            <li><a href="/settings">Settings</a></li>
	            <li><a  href="{{ route('logout.perform') }}">Logout</a></li>
	        </ul>
		</div>
	</div>-->
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
<div class="card sidebar-search">
	<div class="card-body">
		<form method="post" action="{{ route('search.showResults') }}" class="" role="search">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="type" value="default" />
			<div class="input-group">
				<input type="text" name="query" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="">
				<button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
			</div>
	    </form>
	    <p><a href="/search">Advanced Search</a></p>
	</div>
</div>