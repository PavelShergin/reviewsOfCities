<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInControllers extends Controller
{
    public function signIn(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        if (Auth::attempt($validate)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }
        return back()->withErrors([
            'email' => 'Неправильный email или пароль',
        ])->onlyInput('email');
    }
}
