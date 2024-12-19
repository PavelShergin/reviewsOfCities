<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Review;

class EditController extends Controller
{
    public function edit($id)
    {

        $review = Review::find($id);

        $this->authorize('update', $review);
        if ($review->city_id) {
            $city = City::find($review->city_id);
        } else {
            $city = null;
        }

        return view('addreview', ['review' => $review, 'city' => $city]);
    }
}
