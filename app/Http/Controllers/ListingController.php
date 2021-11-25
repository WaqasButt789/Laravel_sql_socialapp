<?php
namespace App\Http\Controllers;
use App\Models\post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ListingPostsRequest;

class ListingController extends Controller
{
    public function listPosts(ListingPostsRequest $req)
    {
        $uid=$req->data->uid;
        $friends=DB::table('friends')->select('userid_2')
                    ->where('userid_1',$uid)->get();
        $objects = json_decode(json_encode($friends->toArray(),true));
        if($objects!=null)
        {
            $friend=$friends[0]->userid_2;
            $friendPosts = DB::table('posts')
            ->whereIn('user_id', [$friend] )->get();
            $allposts[0]=$friendPosts;
        }
        $posts = DB::table('posts')
        ->orWhere('user_id',$uid)
        ->orWhere('accessors','public')
        ->get();
        $allposts[1]=$posts;
        return response()->json($allposts);
    }
}
