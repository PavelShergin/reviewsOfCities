<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    public function createUser(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => 'required',
            'password' => ['required',
                'min:6',
                'confirmed'],
            'captcha' => 'required|captcha'
        ]);

        $user = User::create([
            'fio' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME)->with('success', 'Пользователь успешно создан');
    }
}
