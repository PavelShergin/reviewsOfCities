<?php

namespace App\Http\Controllers;

class ReloadCaptcha extends Controller
{
    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
