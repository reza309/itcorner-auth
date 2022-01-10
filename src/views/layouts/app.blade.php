<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/toastify.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/itcorner-auth-style.css')}}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">It Corner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        @if(Route::has('login'))
            @if(!Session::has('loginId'))
            <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
                @if(Route::has('register'))
                <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
                @endif
            @endif
        @endif
        @if(Session::has('loginId'))
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           My Account
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
          </ul>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
    <div class="container">
        @yield('content')
    </div>
</body>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/all.min.js')}}"></script>
<script src="{{asset('js/common-ajax.js')}}"></script>
<script src="{{asset('js/toastify-js.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</html>