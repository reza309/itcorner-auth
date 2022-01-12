<?php

namespace ItCorner\Auth\Http\Controllers\Auth;
require_once('ItUpload.php');
// use Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;

use App\Models\User;
use App\Models\User_profile;

use Session;
class ItCornerFileUploadController extends Controller
{
    
    public function userFileUpload(Request $request)
    {
    $file_type = ["jpg","png","jpeg","gif"];
    $config_data = [
        "file_name"             => 'it-corner-auth', //you may set a file name
        "name_attribute"        => "file", //value of input field name attribute
        "target_dir"            => "auth-image/",
        "watermark"             => false, 
    ];
    $upload = new ItUpload($config_data); 
    $upload_status = $upload->store();
    $file_dir = $upload->get_target_file();
        if($upload_status['status'] ==='success'){
            $profile = User_profile::where('user_id', Session::get('loginId'))
            ->update([
                'images' => $file_dir[0],
            ]);
            return response()->json([
                'success' => 'done',
                'target_file' =>$upload->get_target_file()
            ]);
        }
        else
        {
            return response()->json([
                'success' => 'done',
                'target_file' =>$upload_status
            ]);
        }
    }
}
