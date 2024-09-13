<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        $remember_token = false;

        if($request->input('remember_user') == 'on') {
            $remember_token = true;
        }
        $is_auth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $remember_token);

        if($is_auth) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            return redirect('/login')->withErrors(['login_denied' => 'логин или пароль не верные']);
        }
    }

    public function loginShow() {

        return view('auth/login');
    }

    public function logout(Request $request) {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect('/');
    }
}
