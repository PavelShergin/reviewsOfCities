<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function session(Request $request)
    {
        $request->session()->put('city', $request->city);
        return redirect()->route('reviews_name', $request->city);
    }
}
