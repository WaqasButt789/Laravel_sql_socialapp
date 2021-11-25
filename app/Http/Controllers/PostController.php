<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\ReadPostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * create post function
     */
    public function createPost(CreatePostRequest $req)
    {
        if($req->file('file')!=NULL)
        {
            $path = $req->file('file')->store('post');
        }
        else{
            return response()->json(['message'=>'Please Provide a file to create post successfuly']);
        }
        $uid=$req->data->uid;
        $post = new post;
        $post->user_id=$uid;
        $post->file = $path;
        $post->accessors=$req->access;
        $post->save();
        return response()->json(['message'=>'post created successfuly',"status" => 200]);
    }
    /**
     * delete post controller
     */
    public function deletePost(DeletePostRequest $req)
    {
        $pid=$req->pid;
        $uid=$req->data->uid;
        DB::table('comments')->where('p_id',$pid)->delete();
        if(DB::table('posts')->where(['pid'=> $pid , 'user_id' => $uid])->delete()==1)
        {
            return response()->json(["messsage" => "Post deleted successfuly","status" => 200]);
        }
        else{
            return response()->json(["messsage" => "You are not allowed to delete this post","status" => 401]);
        }
    }
    /**
     * update post function
     */

    public function updatePost(Request $req)
    {
        $pid=$req->pid;
        $uid=$req->data->uid;
        if($req->file('file') != NULL)
        {
            $path = $req->file('file')->store('post');
            if(DB::table('posts')->where(['pid'=> $pid ,'user_id' => $uid])->update(['file' => $path])==1)
            {
                return response()->json(["messsage" => "Post updated successfuly","status" => 200]);
            }
        }
        if($req->access != NULL)
        {
            if(DB::table('posts')->where(['pid'=> $pid ,'user_id' => $uid])->update(['accessors' => $req->access])==1)
            {
                return response()->json(["messsage" => "Post updated successfuly","status" => 200]);
            }
        }
        else{
            return response()->json(["messsage" => "No Data To Update"]);
        }
    }

    /**
     * read post function
     */
    public function readPost(ReadPostRequest $req)
    {
        $uid=$req->data->uid;
        $data=DB::table('posts')->where('user_id',$uid)->get();
        return new PostResource($data);
    }
}





