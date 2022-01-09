@extends('layouts.app')
@section('title')
{{'User Dashboard'}}
@endsection

@section('content')
<a href="{{route('logout')}}">Logout</a>
@endsection