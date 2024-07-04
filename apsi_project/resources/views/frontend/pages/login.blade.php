@extends('frontend.layouts.master')

@section('title','E-Shop || Login Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Login</h2>
                        <p>Please register in order to checkout more quickly</p>
                        <!-- Form -->
                        <form class="form" method="post" action="{{route('login.submit')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="email" name="email" placeholder="" required="required" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="" required="required" value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Login</button>
                                        <span class="or-separator">OR</span>
                                        <a href="{{route('register.form')}}" class="btn register-btn">Register</a>
                                    </div>
                                    {{-- @if (session('error'))
                                    <div class="alert alert-danger">
                                         {{ session('error') }}
                                    </div>
                                    @endif
                                    <div class="row mb-3 mt-4">
                                    <div class="col-md-8 offset-md-0">
                                        <a href="{{ route('google.redirectuser') }}">
                                            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                                        </a>
                                    </div>
                                </div> --}}
                                    <div class="checkbox">
                                        <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">Remember me</label>
                                    </div>
                                    {{-- @if (Route::has('password.request')) --}}
                                        <a class="lost-pass" href="{{ route('password.reset') }}">
                                            Lost your password?
                                        </a>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection
@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
    .login-btn {
        display: flex;
        align-items: center;
        gap: 10px; 
    }
    .or-separator {
        margin: 0 10px; 
        font-weight: bold;
    }
    .register-btn {
        margin-left: 10px; 
    }
</style>
@endpush
