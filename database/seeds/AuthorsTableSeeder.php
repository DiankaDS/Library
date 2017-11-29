<?php

use Illuminate\Database\Seeder;
use App\Author;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::create([
            'name' => 'Agatha Christie',
        ]);

        Author::create([
            'name' => 'William Shakespeare',
        ]);

        Author::create([
            'name' => 'Stephen King',
        ]);

        Author::create([
            'name' => 'Paulo Coelho',
        ]);

        Author::create([
            'name' => 'Akira Toriyama',
        ]);

        Author::create([
            'name' => 'Danielle Steel',
        ]);

        Author::create([
            'name' => 'Georges Simenon',
        ]);

        Author::create([
            'name' => 'Edgar Allan Poe',
        ]);

        Author::create([
            'name' => 'Gilbert Patten',
        ]);

        Author::create([
            'name' => 'Leo Tolstoy',
        ]);
    }
}
