<?php

namespace App\Http\Controllers;
use Illuminate\Http\Requests;
use App\Http\Requests\AddFriendRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Friend;
use Illuminate\Http\Request;


class FreindController extends Controller
{
    public function addFriend(AddFriendRequest $req)
    {
        $fid=$req->fid;
        $uid=$req->data->uid;
        if($uid != $fid)
        {
            $friend=new Friend;
            $friend->userid_1=$uid;
            $friend->userid_2=$fid;
            $friend->save();
            return response()->json(["messsage" => "now you are friends","status" => 200]);
        }
        else{
            return response(["message" => "invalid access","status" => 405]);
        }
    }

    public function removeFriend(Request $req)
    {
        $fid=$req->fid;
        $uid=$req->data->uid;
        if(DB::table('friends')->where(['userid_1' => $uid , 'userid_2' => $fid])->delete() == 1)
        {
            return response(['Message' => 'Unfriend Successfuly',"status" => 200]);
        }
        else{
            return response(['Message' => 'invalid credentials',"status" => 405]);
        }
    }
}
