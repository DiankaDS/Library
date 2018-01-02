<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'review' => 'required|string|max:255',
        ]);

        if ($request->get('edit_review_id')) {
            $review = Review::find($request->get('edit_review_id'));
            $review->fill([
                'text' => $request->get('review')
            ])->save();
        }

        else {
            Review::create([
                'book_id' => $request->get('book_id'),
                'user_id' => Auth::user()->id,
                'text' => $request->get('review'),
                'rating' => $request->get('rating'),
            ]);
        }
        $message = "Your review saved!";

        return back()->with('status', $message);
    }

    protected function deleteReview(Request $request)
    {
        $review = Review::find($request->get('review_id'));
        $review->delete();

        $message = "Review deleted!";
        return back()->with('status', $message);
    }
}
