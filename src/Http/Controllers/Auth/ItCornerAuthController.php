<?php

namespace ItCorner\Auth\Http\Controllers\Auth;
// use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ItCornerAuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth::login');
    }
    public function register()
    {
        return view('auth::register');
    }
    public function saveRegister(Request $request)
    {
        $name = $email=$password=$confirmPassword=$agrement="";
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password=$request->password;
        if($user->save())
        {
            return Response::json(array("success"=>"registration completed"));
        }
        else
        {
            return response()->view('register',["message"=>"Registration not completed, found an error"]);
        }
        
    }
}
