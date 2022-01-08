<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('/css/toastify.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/itcorner-auth-style.css')}}">
</head>
<body>
<div class="container">
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" action="{{route('register')}}" method="post" id="registerForm">
                    @csrf
                  <div class="flex">
                    <div class="mb-3">
                      <label for="first_name" class="form-label name-color">First Name</label>
                      <input type="text" name="first_name" id="first_name" class="form-control">
                    </div>
                    <div class="mb-3">
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
                  <div class="form-check d-flex justify-content-center mb-5">
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

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                  <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" id="regBtn"
                        data-btnid="regBtn" data-form="registerForm" data-callback="registerCallback" data-validator="true"
                        data-loading='<i class="fas fa-stroopwafel fa-spin"></i>' type="button"
                        onclick="_run(this)">Register</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
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
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/common-ajax.js')}}"></script>
<script src="{{asset('js/toastify-js.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>