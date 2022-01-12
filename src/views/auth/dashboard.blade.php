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
                        <img src="{{empty($user[0]->images)?asset('auth-image/avater.png'):$user[0]->images}}" alt="{{'User Name'}}" srcset="" class="img img-fluid rounded rounded-circle" style="width:50px height:50px">
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">Reset Password</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">Verify Email</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 pb-lg-3">
                    <div class="bg-white pb-lg-3 ps-lg-3 pt-lg-3 pe-lg-3">
                        <p><b>Personal &amp; Contact</b></p>
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th>Name</th>
                                <td>
                                    <div class="d-flex">
                                        <div class="me-3">{{$user[0]->first_name}}</div>
                                        <div class="me-3">{{$user[0]->last_name}}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <div class="me-3">{{$user[0]->email}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>
                                    <div class="me-3">{{$user[0]->phone}}</div>
                                </td>
                            </tr>
                        </table>
                        <p><b>Personal &amp; Address</b></p>
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th>Address</th>
                                <td>
                                    <div class="d-flex">
                                        <div class="me-3">{{$user[0]->line_1}}{{" , "}}</div>
                                        <div class="me-3">{{$user[0]->line_2}}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>
                                    <div class="me-3">{{$user[0]->state}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>city</th>
                                <td>
                                    <div class="me-3">{{$user[0]->city}}</div>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <a href="{{route('profile')}}" class="btn btn-primary d-block w-100"><i class="fas fa-edit"></i> Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection