@extends('admin.layouts.master')
@section('title', 'Login')
<link rel="stylesheet" href="{{asset('css/login/style.css')}}">
@section('content')
    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="{{asset('images/signin-image.jpg')}}" alt="sing up image"></figure>
                    <a href="" class="signup-image-link">Create an account</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" class="register-form" id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" placeholder="Username" value="{{old('username')}}"/>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" placeholder="Password" value="{{old('password')}}"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember_me" id="remember_me" class="agree-term" value="{{ old('remember') ? 'checked' : '' }}">
                            <label for="remember_me" class="label-agree-term">Remember me</label>
                        </div>
                        <div class="form-group">
                            <label class="label-agree-term"><span><span></span></span>
                                <a href="{{route('admin.forgot_password')}}">Forgot password</a>
                            </label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" class="form-submit" value="Log In"/>
                        </div>
                    </form>
                    @if(isset($errors))
                        <div class="alert-danger">
                            @foreach($errors->all() as $error)
                                {!! $error !!}<br/>
                            @endforeach
                        </div>
                    @endif
                    @if(isset($message))
                        <div class="alert-danger">
                            {!! $message !!}
                        </div>
                    @endif
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
