<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailExistsAuth
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
       if(DB::table('users')->where(['email' => $req->email])->exists())
       {
         return response(["message","This email is not available"]);
       }
       else{
        return $next($req);
       }
    }
}
