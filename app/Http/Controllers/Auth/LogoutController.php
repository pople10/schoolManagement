<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LogoutController extends Controller
{
    
    public function destroySession()
    {
        Auth::logout();
        return redirect('/');
    }
}
