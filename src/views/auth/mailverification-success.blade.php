@extends('layouts.app')
@section('title')
{{'User Login'}}
@endsection
@section('content')
<section class="p-3 bg-light pt-5 pb-5 mt-5">
    <div class="border p-3 text-center">
        <h3 class="text-success">We Send a verification mail. Please check your mail.</h3>
        <a href="{{route('mail-verify')}}" class="btn btn-primary">Resend Mail</a>
    </div>
</section>
@endsection