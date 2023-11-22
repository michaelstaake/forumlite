@php ($pageTitle = "Create Account")
@include('includes.header')

<div class="row justify-content-center">
    <div class="col-4">
        <div class="page-title">
            <center>Create Account</center>
        </div>
        <form method="post" action="{{ route('register.perform') }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

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

            <div class="form-group mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkTerms" required>
                    <label class="form-check-label" for="checkTerms">
                    I agree to the <a href="/terms-rules" target="_blank">Terms and Rules</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                    </label>
                </div>
            </div>

           <hr>

            <p>One last thing... we need to make sure you are human! Answer the simple math problem to confirm.</p>

            <div class="form-group mb-3">
                 <div class="captcha">
                    <span>{!! captcha_img('math') !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
                @if ($errors->has('captcha'))
                    <span class="text-danger text-left">CAPTCHA incorrect, please try again.</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input id="captcha" type="text" class="form-control" placeholder="X + Y = ?" name="captcha" required="required">
                <label for="floatingCaptcha">X + Y = ?</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>

        </form>
        <div class="guest-form-link">
            <a href="/login">Already a member? Sign in.</a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

</script>



@include('includes.footer')