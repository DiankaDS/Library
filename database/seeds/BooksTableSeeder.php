<?php

use Illuminate\Database\Seeder;
use App\LibBook;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10; $i++) {
            $book = LibBook::insertGetId([
                'name' => str_random(10),
                'genre_id' => mt_rand(1, 10),
                'year' => mt_rand(1600, 2017),
                'description' => str_random(20),
                'photo' => '',
                'created_at' => Now(),
                'updated_at' => Now(),
            ]);

            DB::table('authors_books')->insert([
                'book_id' => $book,
                'author_id' => mt_rand(1, 10),
            ]);

            DB::table('user_books')->insert([
                'book_id' => $book,
                'user_id' => mt_rand(1, 10),
                'created_at' => Now(),
                'updated_at' => Now(),
            ]);
        }
    }
}
