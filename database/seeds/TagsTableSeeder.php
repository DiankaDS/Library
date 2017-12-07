<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'name' => 'biography',
        ]);

        Tag::create([
            'name' => 'education',
        ]);

        Tag::create([
            'name' => 'historical',
        ]);

        Tag::create([
            'name' => 'fantasy',
        ]);

        Tag::create([
            'name' => 'paranormal',
        ]);
    }
}
