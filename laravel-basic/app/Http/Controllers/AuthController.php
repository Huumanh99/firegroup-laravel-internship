<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $authUser = auth()->user();
        if ($authUser) {
            return redirect()->route('users');
        }

        return view('auth.login');
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    public function authenticate(Request $request)
    {
        $getRole = User::where('role', '=', 'admin')->get();
        $getRole->toArray();
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('users');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
