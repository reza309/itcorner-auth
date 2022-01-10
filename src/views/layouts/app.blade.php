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