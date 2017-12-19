<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AdminAuthorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminAuthors()
    {
        $authors = Author::paginate(12);
        $confirm_delete_author_message = 'Are you sure to delete this author?';
        return view('admin/admin_authors', array(
            'authors' => $authors,
            'confirm_delete_author_message' => $confirm_delete_author_message,
        ));
    }

    protected function adminAuthorDelete(Request $request)
    {
        $author = Author::find($request->get('admins_author_id'));

        $author->books()->detach();
        $author->delete();

        $message = "Author deleted!";
        return back()->with('status', $message);
    }

    protected function adminAuthorCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $author = Author::where('name', $request->get('name'))->first();

        if (!$author) {
            Author::create([
                'name' => $request->get('name'),
            ]);

            $message = "Author created!";
        }
        else {
            $message = "Author already exists!";
        }

        return back()->with('status', $message);
    }
}
