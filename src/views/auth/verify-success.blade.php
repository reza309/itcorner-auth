@extends('layouts.app')
@section('title')
{{'User Login'}}
@endsection
@section('content')
<section class="p-3 bg-light pt-5 pb-5 mt-5">
    <div class="border p-3 text-center">
        <h3 class="{{($message['success']==true)?'text-success':'text-danger'}}">{{$message['message']}}</h3>
        <a href="{{($message['success']==true)?route('login'):route('mail-verify')}}" class="btn btn-primary">{{($message['success']==true)?'Let`s Login':'Send Mail Again'}}</a>
    </div>
</section>
@endsection