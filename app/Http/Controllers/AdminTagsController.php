<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use App\LibBook;
//use App\Author;
//use App\Review;
use App\Tag;
//use Illuminate\Support\Facades\DB;

class AdminTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminTags()
    {
        $tags = Tag::paginate(12);
        $confirm_delete_tag_message = 'Are you sure to delete this tag?';
        return view('admin/admin_tags', array(
            'tags' => $tags,
            'confirm_delete_tag_message' => $confirm_delete_tag_message,
        ));
    }

    protected function adminTagDelete(Request $request)
    {
        $tag = Tag::find($request->get('admins_tag_id'));

        $tag->books()->detach();
        $tag->delete();

        $message = "Tag deleted!";
        return back()->with('status', $message);
    }

    protected function adminTagCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $tag = Tag::where('name', $request->get('name'))->first();

        if (!$tag) {
            Tag::create([
                'name' => $request->get('name'),
            ]);

            $message = "Tag created!";
        }
        else {
            $message = "Tag already exists!";
        }

        return back()->with('status', $message);
    }

    protected function addTagsToBook(Request $request)
    {
        $tags = $request['checkbox'];
        $book_id = $request['book_id'];

        $book = LibBook::find($book_id);
        $book->tags()->detach();

        foreach($tags as $val) {
            $tag = Tag::where('id', $val)->first();
            $book->tags()->save($tag);
        }

        $source = $book->tags()->get();

        return json_encode($source);
    }
}
