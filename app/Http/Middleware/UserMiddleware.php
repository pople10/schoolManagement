<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        if(Auth::User()->sexe==NULL and Auth::User()->role_id!="3") {
                return redirect("/Register/MoreInfo");
        }
        if(Auth::User()->verified!="1")
            return redirect("/getVerified");
        return $next($request);
    }
}
