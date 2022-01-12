@extends('layouts.app')
@section('title')
{{'User Dashboard'}}
@endsection

@section('content')
<section class="dashboard mt-5 bg-light">
    <div class="bg-secondary">
        <div class="p-3 border-bottom mb-3">
            <p class="text-dark dashboard-title">User Dashbord</p>
        </div>
        <div class="container-fluid pt-3">
        @if($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
            <div class="row">
                <div class="col-lg-3">
                    <ul class="list-group-flush">
                        <li class="list-group-item">
                            <form action="{{route('profileUpload')}}" method="POST" enctype="multipart/form-data" id="profile-upload-form">
                                @csrf
                                <img src="{{($user->isEmpty())?asset('auth-image/avater.png'):$user[0]->images}}" alt="" srcset="" class="img img-fluid rounded rounded-circle border" style="width:50px height:50px">
                                <div class="d-flex">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Your Profile Photo</label>
                                        <input class="form-control" type="file" id="formFile" name="image">
                                    </div>
                                </div>
                            </form>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#" class="text-decoration-none d-block w-100">Reset Password</a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#" class="text-decoration-none d-block w-100">Verify Email</a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#" class="text-decoration-none d-block w-100">Two Factor Authentication</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="bg-light pb-lg-5 mb-lg-3">
                        <form action="" method="post" id="update-form" class="needs-validation">
                            @csrf
                            <table class="table table-borderless">
                                <tr>
                                    <th>Personal &amp; contact</th>
                                    <td>
                                        <div class="d-flex">
                                            <div class="w-100 me-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{$user[0]->first_name}}">
                                            </div>
                                            <div class="w-100">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{$user[0]->last_name}}">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="w-100 me-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" disabled class="form-control" name="email" value="{{($user->isEmpty())?'':$user[0]->email}}">
                                            </div>
                                            <div class="w-100">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" value="{{($user->isEmpty())?'':$user[0]->phone}}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Personal &amp; Address</th>
                                    <td>
                                        <div class="d-flex">
                                            <div class="w-100 me-3">
                                                <label for="line_1" class="form-label">Line 1</label>
                                                <input type="text" name="line_1" id="line_1" class="form-control" value="{{($user->isEmpty())?'':$user[0]->line_1}}">
                                            </div>
                                            <div class="w-100">
                                                <label for="line_2" class="form-label">Line 2</label>
                                                <input type="text" name="line_2" id="line_2" class="form-control" value="{{($user->isEmpty())?'':$user[0]->line_2}}">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="w-100 me-3">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" name="state" id="state" class="form-control" value="{{($user->isEmpty())?'':$user[0]->state}}">
                                            </div>
                                            <div class="w-100">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" name="city" id="city" class="form-control" value="{{($user->isEmpty())?'':$user[0]->city}}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="pt-lg-3">
                                <div class="row">
                                    <div class="col-lg-10"></div>
                                    <div class="col-lg-2">
                                        <input type="submit" value="Save Profile" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection