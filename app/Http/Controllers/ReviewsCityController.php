<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Review;

class ReviewsCityController extends Controller
{
    public function reviews_city($name)
    {
        $cityId = City::where('name', $name)->first();
        if ($cityId) {
            session()->put('city', $name);
            $currentPage = request()->get('page', 1);
            $city = cache()->remember('named_city-' . $name . $currentPage, 120, function () use ($cityId) {
                return Review::where('city_id', $cityId->id)->orWhere('city_id', null)->orderBy('created_at', 'desc')->paginate(6);
            });

            return view('reviews', ['reviews' => $city, 'cityId' => $cityId]);
        } else {
            return abort(404);
        }
    }
}
