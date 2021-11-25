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
            return response()->json(["messsage" => "now you are friend of".$fid]);
        }
        else{
            return response(["message" => "User with id = ".$fid." is already your friend"]);
        }
    }

    public function removeFriend(Request $req)
    {
        $fid=$req->fid;
        $uid=$req->data->uid;
        if(DB::table('friends')->where(['userid_1' => $uid , 'userid_2' => $fid])->delete() == 1)
        {
            return response(['Message' => 'Unfriend Successfuly']);
        }
        else{
            return response(['Message' => 'You are not the friend of '.$fid]);
        }
    }
}
