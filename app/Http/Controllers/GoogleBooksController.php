<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleBooksSearch;


class GoogleBooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function googleBookSearch(GoogleBooksSearch $google, Request $request)
    {
        $str = $request['str'];
        $result = $google->getBooks($str);
        $source = [];

        foreach ($result as $item) {
            if ($item['volumeInfo']['title'] != null
                and $item['volumeInfo']['authors'] != null
                and $item['volumeInfo']['categories'] != null
                and $item['volumeInfo']['publishedDate'] != null) {
                $source[] = [
                    'id' => $item['id'],
                    'name' => $item['volumeInfo']['title'],
                    'author' => $item['volumeInfo']['authors'],
                    'genre' => $item['volumeInfo']['categories'][0],
                    'year' => substr($item['volumeInfo']['publishedDate'], 0, 4),
                    'description' => $item['volumeInfo']['description'],
                    'photo' => $item['volumeInfo']['imageLinks']['thumbnail'],
                ];
            }
        }
        return json_encode($source);
    }
}
