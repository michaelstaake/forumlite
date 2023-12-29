<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Install Forumlite
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
		<h1>Install Forumlite</h1>
	</div>
</div>

<div class="content"><!-- closed in footer -->
	<div class="container"> <!-- closed in footer -->
    <div class="row justify-content-center">
      <div class="col-4">
        <p>You must create an admin user to complete Forumlite installation.</p>
        <form method="post" action="{{ route('start.install') }}">

          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" name="group" value="admin" />

          <div class="form-group form-floating mb-3">
              <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
              <label for="floatingEmail">Email address</label>
              @if ($errors->has('email'))
                  <span class="text-danger text-left">{{ $errors->first('email') }}</span>
              @endif
          </div>

          <div class="form-group form-floating mb-3">
              <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
              <label for="floatingName">Username</label>
              @if ($errors->has('username'))
                  <span class="text-danger text-left">{{ $errors->first('username') }}</span>
              @endif
          </div>

          <div class="form-group form-floating mb-3">
              <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
              <label for="floatingPassword">Password</label>
              @if ($errors->has('password'))
                  <span class="text-danger text-left">{{ $errors->first('password') }}</span>
              @endif
          </div>

          <div class="form-group form-floating mb-3">
              <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
              <label for="floatingConfirmPassword">Confirm Password</label>
              @if ($errors->has('password_confirmation'))
                  <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
              @endif
          </div>

          <p>When you're ready, click the button below. If the installation is successful, maintenance mode will be disabled and this install page will no longer be accessible.</p>

          <button class="w-100 btn btn-lg btn-primary" type="submit">Run Install</button>
        </form>
      </div>
    </div>

        </div><!-- closes .container from header -->
</div> <!-- closes .content from header -->

<div class="footer">
    
        <center><p><a href="http://forumlite.com/" target="_blank">Powered by Forumlite</a></p></center>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>