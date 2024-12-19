<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Review;
use App\Rules\CityExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreReviewController extends Controller
{
    public function storeReview(Request $request)
    {
        $validation = $request->validate(
            [
                'title' => 'required',
                'text' => 'required|max:255',
                'city' => ['nullable', 'string', new CityExist],
                'rating' => 'required|numeric',
                'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            ]
        );
        cache()->flush();
        $validation['author_id'] = Auth::user()->id;
        if ($request->has('city') && !is_null($request->city)) {
            if (!City::where('name', $validation['city'])->first()) {
                $city = City::create(['name' => $validation['city']]);
            }
            $city = City::where('name', $validation['city'])->first();
            $validation['city_id'] = $city->id;
            unset($validation['city']);
            if ($request->has('file')) {
                $validation['img'] = $request->file('file')->store('public');
                Review::create($validation);
            } else {
                Review::create($validation);
            }
        } elseif ($request->has('file')) {
            $validation['img'] = $request->file('file')->store('public');
            Review::create($validation);
        } else {
            Review::create($validation);
        }

        return redirect()->route('index')->with('success', 'Отзыв успешно создан');
    }
}
