<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminLog;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
       
        $user = $request->user();

        if($user->verify == 1) {
            if($user->hasRole('superAdmin') || $user->hasRole("admin")){
                $message = 'Login from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>$user->id,"message"=>$message,"status"=>"success"]);
                return response()->json("200");
            } else {
                return response()->json("201");
            }
        } else {
            Auth::guard('web')->logout(); 
            $request->session()->regenerateToken();
            return abort('403');
        }

    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
