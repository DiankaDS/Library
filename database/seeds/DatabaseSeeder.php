<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            SuperadminTableSeeder::class,
            UsersTableSeeder::class,
            GenresTableSeeder::class,
            AuthorsTableSeeder::class,
            BooksTableSeeder::class,
        ]);
    }
}
