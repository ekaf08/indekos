<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('backend.login.index');
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validator)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Login Successful!');
        }

        // return redirect()->back()->with('error', 'Invalid Login Credentials.');
        return back()->withErrors([
            'username' => 'Mohon maaf, Username atau Password salah',
            'password' => 'Mohon maaf, Username atau Password salah',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
