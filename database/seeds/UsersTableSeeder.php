<?php

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'username' => 'admin',
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => mt_rand(1000, 999999),
            'password' => bcrypt('admin'),
            'photo' => 'default_user.jpg',
            'created_at' => Now(),
            'updated_at' => Now(),
            'is_admin' => 1,
        ]);

        for($i=1; $i<=10; $i++) {
            User::insert([
                'username' => str_random(10),
                'name' => str_random(10),
                'surname' => str_random(10),
                'email' => str_random(10) . '@user.com',
                'phone' => mt_rand(1000, 999999),
                'password' => bcrypt('user'),
                'photo' => 'default_user.jpg',
                'created_at' => Now(),
                'updated_at' => Now(),
            ]);
        }
    }
}
