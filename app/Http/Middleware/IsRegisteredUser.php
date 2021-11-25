<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IsRegisteredUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $uid=$request->data->uid;
        
       $fid= $request->fid;
        if(DB::table('users')->where('uid',$fid)->exists())
            {
                if(DB::table('friends')
                        ->where(['userid_1' => $uid , 'userid_2' => $fid])
                        ->orwhere(['userid_1' => $fid , 'userid_2' => $uid])
                        ->doesntExist())
                {
                return $next($request);
            }
            else{
                    return response(["message" => "Invalid Friend Id"]);
                 }
            }
        else{
                return response(["message" => "User is not registerd ."]);
            }
    }
}
