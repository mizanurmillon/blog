@extends('frontend.master')

@section('content')
<section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="m-auto col-lg-6 col-md-8">
                <div class="login-content">
                    <h4>Sign up</h4>
                    @if(session('author_register'))
                        <div class="alert alert-success">{{ session('author_register') }}</div>
                    @endif
                    <!--form-->
                    <form action="{{ route('author.register') }}" class="sign-form widget-form" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name*" name="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address*" name="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password*" name="password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password*" name="password_confirmation">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="sign-controls form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberMe">
                                <label class="custom-control-label" for="rememberMe">Agree to our <a href="#" class="btn-link">terms & conditions</a> </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-custom">Sign Up</button>
                        </div>
                        <p class="text-center form-group">Already have an account? <a href="{{ route('author.login.page') }}" class="btn-link">Login</a> </p>
                    </form>
                       <!--/-->
                </div>
            </div>
         </div>
    </div>
</section>
@endsection
