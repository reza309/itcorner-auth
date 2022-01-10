@extends('layouts.app')
@section('title')
{{"User Registration"}}
@endsection

@section('content')
<section class="p-lg-3 bg-light">
  <div class="row justify-content-center">
    <div class="col-lg-3"></div>
      <div class="col-md-10 col-lg-6 col-xl-5">

        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
        <hr>
        <form action="{{route('register')}}" method="post" id="registerForm">
            @csrf
          <div class="d-lg-flex">
            <div class="mb-3 me-lg-3 w-100">
              <label for="first_name" class="form-label name-color">First Name</label>
              <input type="text" name="first_name" id="first_name" class="form-control">
            </div>
            <div class="mb-3 w-100">
              <label for="last_name" class="form-label name-color">Last Name</label>
              <input type="text" name="last_name" id="last_name" class="form-control">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" name="email" id="email" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            <div id="password_strain" class="intro-x w-full grid grid-cols-12 gap-4 h-1 mt-3">
                <div class="col-span-3 password_strain_content h-full rounded bg-gray-200"></div>
                <div class="col-span-3 password_strain_content h-full rounded bg-gray-200"></div>
                <div class="col-span-3 password_strain_content h-full rounded bg-gray-200"></div>
                <div class="col-span-3 password_strain_content h-full rounded bg-gray-200"></div>
            </div>
            <span id="password_meter_show" class="intro-x text-gray-600 block mt-2 text-xs sm:text-sm"></span>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="confirmPassword" class="form-control">
          </div>
          <div class="form-check mb-5">
            <input
              class="form-check-input me-2"
              type="checkbox"
              value="1"
              id="remember-me" name="remember_me"
            />
            <label class="form-check-label" for="remember-me">
              I agree all statements in <a href="#!">Terms of service</a>
            </label>
          </div>

          <div class="mb-3 mb-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <a href="{{route('login')}}">Aleardy have an account &quest;</a>
              </div>
              <div class="col-lg-6">
              <button class="btn btn-primary w-100" id="regBtn"
                data-btnid="regBtn" data-form="registerForm" data-callback="registerCallback" data-validator="true"
                data-loading='<i class="fas fa-stroopwafel fa-spin"></i>' type="button"
                onclick="_run(this)">Register</button>
              </div>
            </div>
          </div>

        </form>
      </div>
    <div class="col-lg-3"></div>
  </div>
</section>
  <script>
    function registerCallback(data) {
        _enableBtn('regBtn');
        if (data.success) {
            toast('success', data.message);
            document.getElementById('registerForm').reset();
        } else {
            toast('error', data.message);
        }
    }

    // password strength meter ----------------------------------------
    const password = document.getElementById('password');
    let password_meter_show = document.getElementById('password_meter_show');
    password.addEventListener('keyup', function() {
        var len = password.value.length;

        if (len <= 2) {
            resetAllPasswordStraingth();
            password_meter_show.innerText = '';
        } else if (len <= 4 && len > 2) {
            passwordContent(1);
            password_meter_show.innerText = 'Easy';
        } else if (len <= 7 && len >= 5) {
            passwordContent(2);
            password_meter_show.innerText = 'Normal';
        } else if (len <= 10 && len >= 8) {
            passwordContent(3);
            password_meter_show.innerText = 'Strong';
        } else if (len > 12) {
            passwordContent(4);
            password_meter_show.innerText = 'Very Strong';
        }

    });

    function passwordContent(length) {
        var content = document.querySelectorAll('.password_strain_content');
        resetAllPasswordStraingth();

        for (var i = 0; i < length; i++) {
            content[i].classList.add('bg-theme-20');
            content[i].classList.remove('bg-gray-200');
            if (!content[i].classList.contains('bg-theme-20')) {
                content[i].classList.remove('bg-gray-200');
                content[i].classList.add('bg-theme-20');
            }
        }
    }

    function resetAllPasswordStraingth() {
        var content = document.querySelectorAll('.password_strain_content');
        for (var i = 0; i < 4; i++) {

            console.log(content[i].classList.contains('bg-theme-20'));

            if (content[i].classList.contains('bg-theme-20')) {
                content[i].classList.remove('bg-theme-20');
            }

            if (!content[i].classList.contains('bg-gray-200')) {
                content[i].classList.add('bg-gray-200');
            }

        }
    }
    // ----------------------------------------------------------------
</script>
@endsection