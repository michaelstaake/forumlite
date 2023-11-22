@php ($pageTitle = "Sign In")
@include('includes.header')

<div class="row justify-content-center">
    <div class="col-4">
        <div class="page-title">
            <center>Sign In</center>
        </div>
        <form method="post" action="{{ route('login.perform') }}">
        
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

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                <label for="floatingName">Email or Username</label>
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

            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
            
        </form>
        <div class="guest-form-link">
            <a href="/register">Not a member? Create account.</a>
        </div>
        <div class="guest-form-link">
            <a href="/forgot-password">Forgot password? Reset it.</a>
        </div>
    </div>
</div>




@include('includes.footer')