@extends('layouts.app')
@section('title')
{{'User Login'}}
@endsection
@section('content')
<section class="p-3 bg-light pt-5 pb-5 mt-5">
    <div class="row">
        <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="text-center">
                    <h3>Login</h3>
                    <hr>
                </div>
                <form action="" method="post" id="loginForm">
                @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" name="email" id="eamil" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Your Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{csrf_token()}}" id="remember-me" name="remember_me">
                            <label class="form-check-label" for="remember-me">
                                Remember Me &quest;
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{route('register')}}">Registration Now &quest;</a>
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary w-100" id="loginBtn" data-btnid="loginBtn" data-form="loginForm" data-callback="loginCallback" data-validator="true" data-loading='<i class="fas fa-spinner"></i>' onclick="_run(this)">Login</button>
                        </div>
                    </div>
                    <a href="{{route('forget-password')}}">Forget Password</a>
                </form>
            </div>
        <div class="col-lg-3"></div>
    </div>
</section>
<script>
        function loginCallback(data) {
            _enableBtn('loginBtn');
            if (data.success) {
                toast('success', data.message);
                document.getElementById('loginForm').reset();
                window.location.href = data.redirect;
            } else {
                toast('error', data.message);
            }
        }
    </script>
@endsection