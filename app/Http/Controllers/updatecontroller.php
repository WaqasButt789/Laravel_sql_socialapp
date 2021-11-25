<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class updatecontroller extends Controller
{
    /**
     *
     * updating Email_verified_at field
     */
    public function updateData($email,$token)
    {
        $data = DB::table('users')->where('email',$email)->where('token',$token)->get();
        $count=count($data);
        if($count>0)
        {
            DB::table('users')->where('token',$token)->update(['email_verified_at'=>now()]);
            return response(["message"=>"Email has been Verified","status" => 200]);
        }
        else{
            return "Your Email is not Verified";
        }

    }
}
