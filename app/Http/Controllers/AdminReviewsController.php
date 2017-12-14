<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;

class AdminReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminReviews()
    {
        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('lib_books', 'reviews.book_id', '=', 'lib_books.id')
            ->select('users.username', 'reviews.*', 'lib_books.name as book')
//            ->get();
            ->simplePaginate(12);

        $confirm_delete_review_message = 'Are you sure to delete this review?';
        return view('admin/admin_reviews', array(
            'reviews' => $reviews,
            'confirm_delete_review_message' => $confirm_delete_review_message,
        ));
    }

    protected function adminReviewDelete(Request $request)
    {
        $review = Review::find($request->get('admins_review_id'));
        $review->delete();

        $message = "Review deleted!";
        return back()->with('status', $message);
    }
}
