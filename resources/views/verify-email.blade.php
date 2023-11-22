@php ($pageTitle = "Verify Email")

@include('includes.header')

<div class="page-title">
	 Verify Email
</div>

<p>Please verify your email address. You should have received an email with a verification link. Click that button or link to proceed. If you can't find the email, check your spam folder. Until you have verified your email, you will have limited access to the forum. If you are having issues, please go to the <a href="/contact">contact</a> page.</p>

<form method="post" action="{{ route('verification.send') }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <button class="btn btn-primary" type="submit">Resend Verification Email</button>
</form>

@include('includes.footer')