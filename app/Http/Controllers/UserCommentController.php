<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\comment;

class UserCommentController extends Controller
{
    /**
     * creating a comment against a post
     */
    public function createComment(Request $req)
    {
        $uid=$req->data->uid;
        $pid=$req->pid;
        $comments=new comment;
        if($req->comment !=NULL)
        {
            $comment=$req->comment;
        }
        else{
            $comment=NULL;
        }
        if( $req->file('file')!=NULL)
        {
            $path = $req->file('file')->store('post');
        }
        else{
            $path=NULL;
        }
        $comments->user_id=$uid;
        $comments->p_id=$pid;
        $comments->comment=$comment;
        $comments->file=$path;
        $comments->save();
        return response()->json(['message'=>'Commented Successfuly']);
    }

    /**
     * updating an existing comment
     */
    public function updateComment(Request $req)
    {
        $cid=$req->cid;
        $uid=$req->data->uid;
        $comment=$req->comment;
        if($req->comment != NULL)
        {
            if(DB::table('comments')->where(['user_id' => $uid , 'cid' => $cid ])->update(['comment' => $req->comment])==1)
            {
                return response()->json(["messsage" => "comment updated successfuly"]);
            }
            else{
                return response()->json(["messsage" => "you cannot update others comments"]);
            }
        }
        if($req->file('file') != NULL)
        {
            $path = $req->file('file')->store('post');
            if(DB::table('comments')->where(['user_id' => $uid , 'cid' => $cid])->update(['file' => $path])==1)
            {
                return response()->json(["messsage" => "comment updated successfuly"]);
            }
            else{
                return response()->json(["messsage" => "you cannot update others comments"]);
            }
        }
        else{
            return response()->json(["messsage" => "No data to update"]);
        }
    }

     /**
     * deleting an existing comment
     */
    public function deleteComment(Request $req)
    {
        $cid=$req->cid;
        $uid=$req->data->uid;
        if(DB::table('comments')->where(['cid'=> $cid,'user_id'=> $uid])->delete() == 1)
        {
            return response()->json(["messsage" => "comment Deleted successfuly"]);
        }
        else{
            return response()->json(["messsage" => "you are ot allowed to delete others comment"]);
        }
    }
}
