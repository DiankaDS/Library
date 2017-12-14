<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGenresController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminGenres()
    {
        $genres = DB::table('genres')->simplePaginate(12);
        $confirm_delete_genre_message = 'Are you sure to delete this genre?';
        return view('admin/admin_genres', array(
            'genres' => $genres,
            'confirm_delete_genre_message' => $confirm_delete_genre_message,
        ));
    }

    protected function adminGenreDelete(Request $request)
    {
        DB::table('genres')
            ->where('genres.id', $request->get('admins_genre_id'))
            ->delete();

        $message = "Genre deleted!";
        return back()->with('status', $message);
    }

    protected function adminGenreCreate(Request $request)
    {
        $request->validate([
            'genre' => 'required|string|max:255',
        ]);

        DB::table('genres')->insert(
            ['name' => $request->get('genre')]
        );

        $message = "Genre created!";
        return back()->with('status', $message);
    }
}
