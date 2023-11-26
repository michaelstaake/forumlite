<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Update Forumlite
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
		<h1>Update Forumlite</h1>
	</div>
	
</div>

<div class="content"><!-- closed in footer -->
	<div class="container"> <!-- closed in footer -->
        <form method="post" action="{{ route('start.update') }}" class="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <p>Once you've uploaded the files, click the button to update the database.</p>
            <p><button class="btn btn-primary" type="submit">Run Update</button></p>
        </form>

        </div><!-- closes .container from header -->
</div> <!-- closes .content from header -->

<div class="footer">
    
        <center><p><a href="http://forumlite.com/" target="_blank">Powered by Forumlite</a></p></center>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>