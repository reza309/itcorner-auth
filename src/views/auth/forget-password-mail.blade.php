@extends('layouts.app')
@section('title')
{{'User Login'}}
@endsection
@section('content')
<section class="p-3 bg-light pt-5 pb-5 mt-5">
    <div class="border p-3">
        <div class="text-center">
        <h3 class="text-dark">Forget Your Password</h3>
        <hr>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form action="{{route('forget-password')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Verif Email" class="btn btn-primary float-end">
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
        
    </div>
</section>
@endsection