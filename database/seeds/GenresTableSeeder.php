<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'name' => 'Science',
        ]);

        DB::table('genres')->insert([
            'name' => 'Fantasy',
        ]);

        DB::table('genres')->insert([
            'name' => 'Education',
        ]);

        DB::table('genres')->insert([
            'name' => 'Horror',
        ]);

        DB::table('genres')->insert([
            'name' => 'Comedy',
        ]);

        DB::table('genres')->insert([
            'name' => 'Biography',
        ]);

        DB::table('genres')->insert([
            'name' => 'Religious',
        ]);

        DB::table('genres')->insert([
            'name' => 'Crime',
        ]);

        DB::table('genres')->insert([
            'name' => 'Mystery',
        ]);

        DB::table('genres')->insert([
            'name' => 'Romance',
        ]);
    }
}
