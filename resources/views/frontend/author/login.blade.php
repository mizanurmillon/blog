@extends('frontend.master')
@section('content')
 <!--Login-->
 <section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="m-auto col-lg-6 col-md-8">
                <div class="login-content">
                    <h4>Login</h4>
                    @if(session('pending'))
                        <div class="alert alert-warning">{{ session('pending') }}</div>
                    @endif
                    <p></p>
                    <form  action="{{ route('author.login') }}" class="sign-form widget-form" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email*" name="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if(session('email_error'))
                                <small class="text-danger">{{ session('email_error') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password*" name="password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if(session('password_error'))
                                <small class="text-danger">{{ session('password_error') }}</small>
                            @endif
                        </div>
                        <div class="sign-controls form-group">
                            <a href="#" class="btn-link ">Forgot Password?</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-custom">Login in</button>
                        </div>
                        <p class="text-center form-group">Don't have an account? <a href="{{ route('author.register.page') }}" class="btn-link">Create One</a> </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
