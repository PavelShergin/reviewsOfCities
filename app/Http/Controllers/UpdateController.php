<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Review;
use App\Rules\CityExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function update(Request $request, $id)
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
        $review = Review::find($id);
        $this->authorize('update', $review);
        if ($request->has('file') && !is_null($review->img)) {
            Storage::delete($review->img);
            $validation['img'] = $request->file('file')->store('public');
        } elseif ($request->has('file')) {
            $validation['img'] = $request->file('file')->store('public');
        }


        if ($request->input('city') && City::where('name', $validation['city'])->first()) {
            $city = City::where('name', $validation['city'])->first();
            $validation['city_id'] = $city->id;
            $review->update($validation);
        } elseif (!is_null($request->input('city'))) {
            $city = City::create(['name' => $validation['city']]);
            $validation['city_id'] = $city->id;
            $review->update($validation);
        }
        if (is_null($request->input('city'))) {
            $validation['city_id'] = null;
            $review->update($validation);
        }
        return back()->with('success', 'Отзыв успешно изменен');
    }
}
