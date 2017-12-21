<?php

use Illuminate\Database\Seeder;
use App\Format;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Format::create([
            'name' => 'paper',
        ]);

        Format::create([
            'name' => 'PDF',
        ]);

        Format::create([
            'name' => 'DOC',
        ]);

        Format::create([
            'name' => 'FB2',
        ]);

        Format::create([
            'name' => 'DjVu',
        ]);

        Format::create([
            'name' => 'RTF',
        ]);
    }
}
