<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if (isset($pageTitle))
            {{ $pageTitle }} - {{ config('app.name'); }}
        @else
            {{ config('app.name'); }}
        @endif
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('assets/markitup/jquery.markitup.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/markitup/sets/default/set.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/markitup/skins/simple/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/markitup/sets/default/style.css')}}" />
  </head>
  <body>
    
  <div class="header">
	<div class="logo">
		<h1><a href="/">{{ config('app.name'); }}</a></h1>
	</div>
	<div class="navigation">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
			<div class="container">
				<div id="navbarForumMenu">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="/index"><i class="bi bi-house"></i> Home</a>
						</li>

                        <li class="nav-item">
                            <a class="nav-link" href="/search"><i class="bi bi-search"></i> Search</a>
                        </li>
                        
                        @auth
                            <!--<li class="nav-item">
                                <a class="nav-link" href="/search/newposts"><i class="bi bi-chat-left-text"></i> New Posts</a>
                            </li>-->
                            <li class="nav-item">
                                <a class="nav-link" href="/notifications"><i class="bi bi-bell"></i> Notifications <span class="badge text-bg-primary" id="notifications-badge"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/messages"><i class="bi bi-envelope"></i> Messages <span class="badge text-bg-primary" id="messages-badge"></span></a>
                            </li>
                            @if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
                                <li class="nav-item">
                                    <a class="nav-link" href="/controlpanel"><i class="bi bi-speedometer2"></i> Control Panel <span class="badge text-bg-danger" id="reports-badge"></span></a>
                                </li>
                            @endif
                            <li class="nav-item dropdown ms-auto">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="header-avatar" src="{{asset('storage/avatars')}}/{{auth()->user()->avatar}}" /> {{auth()->user()->username}}
                                </a>
                                <ul class="dropdown-menu">  
                                    <li><a class="dropdown-item" href="/settings"><i class="bi bi-person-gear"></i> Settings</a></li>
                                    <li><a class="dropdown-item" href="/watched"><i class="bi bi-eye"></i> Watched Discussions</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout.perform') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                                </ul>
                            </li>
                        @endauth

                        @guest
                            <li class="nav-item dropdown ms-auto">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login.perform') }}"><i class="bi bi-box-arrow-in-right"></i> Sign In</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register.perform') }}"><i class="bi bi-person-plus"></i> Create Account</a></li>
                                </ul>
                            </li>
                        @endguest
					</ul>
				</div>
			</div>
		</nav>
	</div>

    <div class="container">
        @auth
            @if (auth()->user()->is_banned == 'TRUE')
                <div class="alert alert-danger" role="alert">You are currently banned from the forum. To browse the forum as a guest, you may <a href="/logout">log out</a>.</div>
                @php (exit())
            @endif
        @endauth    
    </div>
    

	
</div>

<div class="content"><!-- closed in footer -->
	<div class="container"> <!-- closed in footer -->