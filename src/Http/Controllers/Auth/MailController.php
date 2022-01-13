<?php

namespace ItCorner\Auth\Http\Controllers\Auth;
use ItCorner\Auth\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\UrlGenerator ;

use Hash;
use Session;
class MailController extends Controller
{
    protected $verifyEmail = "reza06br@gmail.com";
    public function mailVerificationView(Request $request)
    {
        if($request->session()->has('regId'))
        {
            Route::route('sendmail');
        }
        else{
            return view('auth.get-email');
        }
    }
    // its sending the mail with body title
    public function sendVerificationMail()
    {
        $root_url = url();
        Session::forget('mailId');
        Session::forget('verifyEmail');
        Session::put('mailId', Hash::make(time()));
        Session::put('verifyEmail',$this->verifyEmail);
        $details =[
            'title'=>"Mail from IT-CORNER authentication",
            "body" => "This is a verification mail. Please click the button or linke to user verification. If you not write user please ignore this.",
            "link" => url("/mail-verfiy/confirm/".Session::get('mailId'))
        ];
        Mail::to($this->verifyEmail)->send(new VerificationMail($details));
        return true;
    }
    // verfication confirm
    public function verificationConfirm($id)
    {
        if(Session::get('mailId') == $id)
        {
            if(User::where('email',Session::get('verifyEmail')->update(['email_verified_at'=>time()])))
            {
                Session::forget('verifyEmail');
                return "verification success";
            }
            else{
                return "verification failed";
            }
            
        }
        else{
            return "verification failed";
        }
        
    }
    public function mailSendSuccess()
    {
        return view('auth.mailverification-success');
    }
    // its store the verification data
    public function mailVerification(Request $request)
    {
        $email = "";
        if($request->session()->has('regId'))
        {
            $email = User::where('id',$request->session()->get('regId'))
            ->get([
                'email'
            ]);
            $request->session()->get('regId');
        }
        else{
            $validationRuls = [
                'email'=>'required|email|exists:users|max:50'
            ];
            $validator = Validator::make($request->all(),$validationRuls);
            if($validator->fails()) {
                return Response::json(['failed'=>$validator->errors()]);
            }else{
                $this->verifyEmail = $request->email;
                if( $this->sendVerificationMail())
                {
                    return  Redirect::route('mail-send');
                }
            }
        }
        
    }
}
