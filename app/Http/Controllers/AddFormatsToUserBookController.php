<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Format;
use Illuminate\Support\Facades\DB;

class AddFormatsToUserBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function addFormatsToBook(Request $request)
    {
        $formats = $request['checkbox'];
        $user_book_id = $request['book_id'];

        DB::table('formats_users_books')
            ->where('user_book_id', $user_book_id)
            ->delete();

        foreach ($formats as $format) {
            DB::table('formats_users_books')->insert([
                'format_id' => $format,
                'user_book_id' => $user_book_id,
            ]);
        }

        $source = DB::table('formats')
            ->whereIn('id', $formats)
            ->get();

        return json_encode($source);
    }

    protected function allFormatsList()
    {
        $all_formats = Format::get();
        return json_encode($all_formats);
    }
}
