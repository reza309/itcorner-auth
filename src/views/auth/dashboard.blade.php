@extends('layouts.app')
@section('title')
{{'User Dashboard'}}
@endsection

@section('content')
<section class="dashboard mt-5 bg-light">
    <div class="bg-secondary">
        <div class="p-3 border-bottom">
            <p class="text-dark">User Dashbord</p>
        </div>
        <div class="container-fluid mt-lg-3">
            <div class="row">
                <div class="col-lg-3">
                    <ul class="list-group-flush">
                        <li class="list-group-item">
                        <img src="" alt="{{'User Name'}}" srcset="" class="img img-fluid rounded rounded-circle" style="width:50px height:50px">
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">Reset Password</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">Verify Email</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9"></div>
            </div>
        </div>
    </div>
</section>
@endsection