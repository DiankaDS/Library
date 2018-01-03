<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LibBook;
use App\Tag;

class AddTagsToBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
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

    protected function allTagsList()
    {
        $all_tags = Tag::get();
        return json_encode($all_tags);
    }
}
