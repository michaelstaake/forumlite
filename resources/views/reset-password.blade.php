@php ($pageTitle = "Reset Password")
@include('includes.header')

<div class="row justify-content-center">
    <div class="col-4">
        <div class="page-title">
            <center>Reset Password</center>
        </div>
        <form method="post" action="{{ route('password.update') }}">
        
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            
            @if(isset ($errors) && count($errors) > 0)
                <div class="alert alert-warning" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::get('success', false))
                <?php $data = Session::get('success'); ?>
                @if (is_array($data))
                    @foreach ($data as $msg)
                        <div class="alert alert-warning" role="alert">
                            <i class="fa fa-check"></i>
                            {{ $msg }}
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-check"></i>
                        {{ $data }}
                    </div>
                @endif
            @endif

            <input type="hidden" name="token" value="{{ $token }}" />

            <div class="form-group form-floating mb-3">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required="required" autofocus>
                <label for="floatingName">Email</label>
                @if ($errors->has('email'))
                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
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
            
            <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
            
        </form>
        <div class="guest-form-link">
            <a href="/login">Cancel (back to Sign In page)</a>
        </div>
    </div>
</div>




@include('includes.footer')