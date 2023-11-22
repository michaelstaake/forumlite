@php ($pageTitle = "Error")

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
    <script src="{{asset('assets/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
</div>

<div class="content"><!-- closed in footer -->
    <div class="container"> <!-- closed in footer -->

<div class="page-title">
    Error @yield('code')
</div>

@yield('message')

@include('includes.footer')