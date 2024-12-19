<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($id)
    {
        $user = User::find($id);
        return view('profile', ['user' => $user]);
    }
}
