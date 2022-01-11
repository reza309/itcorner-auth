<?php

namespace ItCorner\Auth\Http\Controllers\Auth;
// use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Session;
use Hash;
use Session;
class ItCornerProfileController extends Controller
{
    /**
     * user profile update form view
     * created by shaheen reza 
     */
    public function profileView(Request $request)
    {
        $user = User::leftJoin('user_profiles','users.id','=','user_profiles.user_id')
        ->where('users.id', $request->session()->get('loginId'))
        ->get([
            'first_name', 'last_name', 'email',
            'phone','line_1','line_2','state','city'
        ]);
        // return Response::json(array('users',$user));
        return view('auth.profile',["user"=>$user]);
    }
    public function profileStore(Request $request)
    {
        $validationRules = [
            'first_name' => 'required|max:20|min:2',
            'last_name' => 'required|min:2|max:20',
            'phone' =>'numeric|digits:10',
            'line_1'=>'string|max:50',
            'line_2'=>'string|max:50',
            'state'=>'string|max:20',
            'city'=>'string|max:20'
        ];
        $validator = Validator::make($request->all(),$validationRules);
        if($validator->fails()) {
            // return Respons::back()->withErrors($validator->errors());
            // return Response::json(array('success',$validator->errors()));
            return Response::json($validator->errors());
        }else{
            if (User_profile::where('user_id',Session::get('loginId'))->exists()) {
                $profile = User_profile::where('user_id', Session::get('loginId'))
                ->update([
                    'line_1' => $request->line_1,
                    'line_2' => $request->line_2,
                    'state' => $request->state,
                    'city'=>$request->city,
                    'phone'=>$request->phone
                ]);
                if($profile){
                    return Response::json('success');
                }else{
                    return Response::json('error');
                }
            }
            else
            {
                $user_profile = new User_profile();
                $user_profile->phone = $request->phone;
                $user_profile->line_1 = $request->line_1;
                $user_profile->line_2 = $request->line_2;
                $user_profile->state = $request->state;
                $user_profile->city=$request->city;
                $user_profile->user_id=Session::get('loginId');
                if($user_profile->save()){
                    return Response::json('success');
                }else{
                    return Response::json('error');
                }
            }
        }
        
        

        // return Response::json($todo);
    }
}
