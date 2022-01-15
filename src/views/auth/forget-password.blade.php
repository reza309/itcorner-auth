@extends('layouts.app')
@section('title')
{{'User Login'}}
@endsection
@section('content')
<section class="p-3 bg-light pt-5 pb-5 mt-5">
    <div class="border p-3">
        <div class="text-center">
        <h3 class="text-dark">Set Your New Password</h3>
        <hr>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form action="{{route('forget-password-confirm',request()->route('forgetLink'))}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Save Password" class="btn btn-primary float-end">
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
        
    </div>
</section>
@endsection