<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {
        $key=$req->token;
        $data=DB::table('users')->where('remember_token',$key)->first();
        if($data)
        {
            return $next($req->merge(["data"=>$data]));
        }
        else {
            return response(["Message" => "you are not logIn"]);
        }
    }
}
