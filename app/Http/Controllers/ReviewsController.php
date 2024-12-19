<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewsController extends Controller
{
    public function reviews()
    {
        $currentPage = request()->get('page', 1);
        $reviews = cache()->remember('all_reviews-' . $currentPage, 120, function () {
            return Review::inRandomOrder()->paginate(6);
        });
        return view('reviews', ['reviews' => $reviews]);
    }
}
