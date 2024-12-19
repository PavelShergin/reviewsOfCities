<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function show(Request $request)
    {
        $citys = cache()->remember('citys', 120, function () {
            return City::orderBy('name', 'asc')->get();
        });
        return view('index', ['citys' => $citys]);
    }
}
