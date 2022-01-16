<?php

namespace ItCorner\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use ItCorner\Auth\Mail\VerificationMail;
use App\Models\User;
use \Carbon\Carbon;
use Session;
use Crypt;
use Hash;

class ItCornerForgetPassword extends Controller
{
    protected $forgetMail;
    // forget password get mail view
    public function sendLinkView()
    {
        if(file_exists(resource_path('views/auth/forget-password-mail.blade.php')))
        {
            return view('auth.forget-password-mail');
        }else{
            return view('auth::forget-password-mail');
        }
        
    }
    public function createMail()
    {
        $root_url = url();
        Session::forget('forgetMail');
        Session::forget('forgetLink');
        Session::put('forgetLink', Crypt::encrypt(time()));
        // Session::put('forgetLink',1);
        Session::put('forgetMail',$this->forgetMail);
        $details =[
            'title'=>"Forget Password",
            "body" => "This is a verification mail. Please click the button or linke to forget your password. If you not write user please ignore this.",
            "link" => url("/forget-password/confirm/".Session::get('forgetLink'))
        ];
        Mail::to($this->forgetMail)->send(new VerificationMail($details));
        return true;
    }
    /**submit mail with forget link */
    public function sendLink(Request $request)
    {
        $this->forgetMail = $request->email;
        $validationRules = [
            'email'=>'required|email|exists:users|max:50'
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if($validator->fails())
        {
            Session::forget('forgetMail');
            Session::forget('forgetLink');
            return Response::json(['failed'=>$validator->errors()]);
        }
        else{
            if($this->createMail())
            {
                return Response::json(['success'=>'We send a mail. Please check yur email and follow the instruction']);
            }else{
                Session::forget('forgetMail');
                Session::forget('forgetLink');
                return Response::json(['failed'=>'Link Sending Failed, Please Try Again Later']);
            }
        }
    }
    // forget password data insersion
    public function forgetPasswordConfirm($id)
    {

        if(file_exists(resource_path('views/auth/forget-password.blade.php')))
        {
            return view('auth.forget-password');
        }else{
            return view('auth::forget-password');
        }
    }
    public function saveNewPassword(Request $request)
    {
        $email = Session::get('forgetMail');
        // return response::json(['failed'=>$id]);
        $validationRules = [
            'password' => 'required|min:6|max:50|confirmed',
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if($validator->fails()){
            return Response::json(['failed'=>$validator->errors()]);
        }else{
            if(User::where('email',$email)->update(['password'=>Hash::make($request->password),'updated_at'=>Carbon::now()]))
            {
                Session::forget('forgetMail');
                Session::forget('forgetLink');
                return Response::json(['success'=>"You successfully set a new password, "]);
            }else{
                Session::forget('forgetMail');
                Session::forget('forgetLink');
                return Response::json(['failed'=>'Sorry! somthing went wrong, Please try again later.']);
            }
        }
    }
}
