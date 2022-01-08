<form action="{{ url('login') }}" id="loginForm" method="POST">
  @csrf
  <div class="intro-x mt-8">
      <input type="text" name="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
          placeholder="Email">
      <input type="password" name="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
          placeholder="Password">
  </div>
  <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
      <div class="flex items-center mr-auto">
          <input id="remember-me" type="checkbox" name="remember_me" class="form-check-input border mr-2">
          <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
      </div>
      <a href="">Forgot Password?</a>
  </div>
  <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
      <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" id="loginBtn"
          data-btnid="loginBtn" data-form="loginForm" data-callback="loginCallback" data-validator="true"
          data-loading='<i class="fas fa-spinner"></i>' onclick="_run(this)">Login</button>
      <a href="{{ url('register') }}"
          class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign up</a>
  </div>
</form>