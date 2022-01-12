<?php

namespace ItCorner\Auth\Http\Controllers\Auth;
// use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Session;
use Hash;
use Session;
class ItCornerAuthController extends Controller
{
    // login view function
    public function loginView(Request $request)
    {
        return view('auth::login');
    }
    // login function with ajax
    public function login(Request $request)
    {
        // dd($request->all());

        $rules = [
            'email' => 'required|email|max:50',
            'password' => 'required|min:6|max:50',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return [
                'success' => false,
                'message' => 'Not Ready To Login, Please check validation errors.',
                'errors' => $validation->errors(),
            ];
        }

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $request->session()->put('loginId',$user->id);
                return [
                    'success' => true,
                    'message' => 'You have successfully logged in!',
                    'redirect' => 'dashboard'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Password did not match'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Email is invalid',
            ];
        }
    }
    // logout function
    public function logout()
    {
        if(Session::has('loginId'))
        {
            Session::pull('loginId');
            return redirect('login');
        }
    }
    // user registration view
    public function registerView()
    {
        return view('auth::register');
    }
    public function dashboard(Request $request)
    {
        $user = User::leftJoin('user_profiles','users.id','=','user_profiles.user_id')
        ->where('users.id', $request->session()->get('loginId'))
        ->get([
            'first_name', 'last_name', 'email','images',
            'phone','line_1','line_2','state','city'
        ]);
        return view('auth.dashboard',["user"=>$user]);
    }
    // User Registration with ajax
    public function register(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:6|max:50|confirmed',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return [
                'success' => false,
                'message' => 'Not Ready To Register, Please check validation errors.',
                'errors' => $validation->errors(),
            ];
        }

        if (!$request->input('remember_me')) {
            return [
                'success' => false,
                'message' => 'You have to agree with our privacy policy'
            ];
        }

        // creating a user
        // $user = User::create(array_merge($request->all(), ['password' => Hash::make($request->password)]));
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password=Hash::make($request->password);
        if($user->save())
        // checking if a user is created successfully or not
        if ($user) {
            $res['success'] = true;
            $res['message'] = "Registration successful! You can login now.";
            $res['redirect'] = 'login';
        } else {
            $res['success'] = false;
            $res['message'] = "Server error please try again after some times";
        }

        echo json_encode($res);
    }

    public function saveRegister(Request $request)
    {
        $validationRules = [
            'name' => 'required|min:4|max:255',
            'email' => 'required|unique:users|email',
            'password'=>[
                'required',
                Password::min(8)->letters()->numbers(),
                'confirmed'
            ],
        ];
        $validator = Validator::make($request->all(),$validationRules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }
        else
        {
            $name = $email=$password=$confirmPassword=$agrement="";
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password=Hash::make($request->password);
            if($user->save())
            {
                return Response::json(array("success"=>"registration completed"));
            }
            else
            {
                // return response()->view('register',["message"=>"Registration not completed, found an error"]);
                return Redirect::back()->withErrors(["failed"=>"Registration failed, Try again later!"]);
            }
        }        
    }
}
