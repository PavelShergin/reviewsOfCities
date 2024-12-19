<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileReviewsController extends Controller
{
    public function profileReviews($id)
    {
        $user = User::find($id);


        $reviews = $user->review()->orderBy('created_at', 'desc')->paginate(6);

        return view('reviews', ['reviews' => $reviews, 'user' => $user]);
    }
}
