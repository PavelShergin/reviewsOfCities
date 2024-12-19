<?php

namespace App\Http\Controllers;

use App\Models\Review;

class DestroyController extends Controller
{
    public function destroy($id)
    {
        $review = Review::find($id);
        $this->authorize('update', $review);
        Review::destroy($id);
        cache()->flush();
        return back()->with('success', 'Отзыв успешно удален');
    }
}
