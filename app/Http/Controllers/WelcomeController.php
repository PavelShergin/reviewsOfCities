<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $city = session('city');
        if ($city) {
            return redirect()->route('reviews_name', $city);
        }
        return view('welcome');
    }
}
