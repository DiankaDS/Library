<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserBooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminRecommendations()
    {
        $books = DB::table('lib_books')
            ->join('user_books', 'user_books.book_id', '=', 'lib_books.id')
            ->join('users', 'users.id', '=', 'user_books.user_id')
            ->leftJoin('formats_users_books', 'user_books.id', '=', 'formats_users_books.user_book_id')
            ->leftJoin('formats', 'formats.id', '=', 'formats_users_books.format_id')
            ->select('lib_books.name as book',
                'lib_books.photo as book_photo',
                'users.username as username',
                'user_books.*',
                DB::raw("group_concat(formats.name) as formats")
//                DB::raw("(SELECT group_concat(formats.name)
//                FROM formats
//                INNER JOIN formats_users_books ON formats_users_books.format_id = formats.id
//                INNER JOIN user_books ON formats_users_books.user_book_id = user_books.id
//                WHERE user_books.book_id = lib_books.id
//                ) as formats")
            )
            ->where('user_books.is_approve', 0)
            ->groupBy('user_books.id')
            ->paginate(12);

//        $confirm_approve_message = "Are you sure to approve this recommendation?";

        return view('admin/recommendations', array(
            'books' => $books,
//            'confirm_approve_message' => $confirm_approve_message,
        ));
    }

    protected function acceptRecommendation(Request $request){
        DB::table('user_books')
            ->where('id', $request->get('admins_user_book_id'))
            ->update(['is_approve' => 1]);

        $message = "Recommendation approved!";
        return back()->with('status', $message);
    }

    protected function deleteRecommendation(Request $request){
        DB::table('user_books')
            ->where('id', $request->get('admins_user_book_id'))
            ->delete();

        $message = "Recommendation deleted!";
        return back()->with('status', $message);
    }

    protected function adminRecommendationUpdatePrice(Request $request)
    {
        $request->validate([
            'field' => 'required|integer',
        ]);

        DB::table('user_books')
            ->where('user_books.id', $request->get('edit_field_id'))
            ->update(['price' => $request->get('field')]);

        $message = "Recommendation updated!";

        return back()->with('status', $message);
    }

    protected function adminRecommendationUpdateLink(Request $request)
    {
        $request->validate([
            'field' => 'required|string|max:255',
        ]);

        DB::table('user_books')
            ->where('user_books.id', $request->get('edit_field_id'))
            ->update(['link' => $request->get('field')]);

        $message = "Recommendation updated!";

        return back()->with('status', $message);
    }
}
