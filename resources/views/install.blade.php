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
        <form method="post" action="{{ route('settings.submit') }}" class="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <h4>Step 1: Update .env</h4>
            <p>First things first, copy the file .env.example to .env and update the following items:</p>
            <p><b>APP_NAME=</b></p>
            <p>This will be displayed throughout your forum and in emails sent by the forum. Choose something like <code>MyExampleForum</code> or <code>Example Forums</code></p>
            <p><b>APP_ENV=</b></p>
            <p>This should be set to <code>production</code></p>
            <p><b>APP_DEBUG=</b></p>
            <p>This sould be set to <code>false</code></p>
            <p><b>APP_URL</b></p>
            <p>Depending on your website and folder structure, this could be something like <code>https://example.com</code>, <code>https://example.com/forum</code> or <code>https://forum.example.com</code></p>
            <p><b>DB_HOST=</b></p>
            <p>Your MySQL server host. In most cases, this will be <code>localhost</code></p>
            <p><b>DB_DATABASE=</b></p>
            <p>Your MySQL database name. Such as <code>example_forum</code></p>
            <p><b>DB_USERNAME=</b></p>
            <p>Your MySQL user name. Such as <code>example_user</code></p>
            <p><b>DB_PASSWORD=</b></p>
            <p>Your MySQL user password</p>
            <p><b>MAIL_HOST=</b></p>
            <p>This is the server the forum will use to send email. Depending on your configuration, this could be <code>localhost</code> or it could be something like <code>smtp.example.com</code></p>
            <p><b>MAIL_PORT=</b></p>
            <p>Most likely, this will be port <code>465</code> but it depends on your mail provider or mail server configuration.</p>
            <p><b>MAIL_USERNAME=</b></p>
            <p>Your mail server username. On most servers, this is the entire email address, and should match the MAIL_FROM_ADDRESS below.</p>
            <p><b>MAIL_PASSWORD=</b></p>
            <p>Your mail server password.</p>
            <p><b>MAIL_ENCRYPTION=</b></p>
            <p>Most likely, this will be <code>tls</code> but it depends on your mail provider or mail server configuration.</p>
            <p><b>MAIL_FROM_ADDRESS=</b></p>
            <p>The email your forum uses to send email. We recommend something like <code>forum@example.com</code> or <code>noreply@example.com</code></p>
            <h4>Step 2: Clear Cache</h4>
            <p>On your server, run <code>php artisan optimize:clear</code></p>
            <h4>Step 3: Prepare Database</h4>
            <p>On your server, run <code>php artisan migrate</code></p>
            <h4>Step 4: Create Admin User</h4>
            <p>This will be your user account. As an admin, you have full access to all settings and features. Of course, be sure to pick a secure, unique password!</p>
            <p><b>Username</b></p>
            <p><input type="text" class="form-control" aria-label="username" name="username" style="max-width: 200px;" required="required"></p>
            <p><b>Password</b></p>
            <p><input type="text" class="form-control" aria-label="password" name="password" style="max-width: 200px;" required="required"></p>
            <p><b>Email</b></p>
            <p><input type="email" class="form-control" aria-label="email" name="email" style="max-width: 200px;" required="required"></p>
            <h4>Step 5: Create First Category</h4>
            <p>We need at least one category for our forum. By default, it will be placed in a section called Forums. You can always change these later.</p>
            <p><b>Category Name</b></p>
            <p><input type="text" class="form-control" aria-label="category_name" name="category_name" style="max-width: 200px;" required="required"></p>
            <p><b>Category Description</b></p>
            <p><input type="text" class="form-control" aria-label="category_desc" name="category_desc" style="max-width: 200px;" required="required"></p>
            <h4>Step 6: Run the Install</h4>
            <p>When you're ready, click the button below!</p>
            <p><button class="btn btn-primary" type="submit">Run Install</button></p>
        </form>

        </div><!-- closes .container from header -->
</div> <!-- closes .content from header -->

<div class="footer">
    
        <center><p><a href="http://forumlite.com/" target="_blank">Powered by Forumlite</a></p></center>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>