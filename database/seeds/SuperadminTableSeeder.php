<?php

use Illuminate\Database\Seeder;
use App\User;

class SuperadminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'username' => 'superadmin',
            'name' => 'superadmin',
            'surname' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'phone' => mt_rand(1000, 999999),
            'password' => bcrypt('admin'),
            'photo' => '',
            'created_at' => Now(),
            'updated_at' => Now(),
            'role_id' => 2,
        ]);
    }
}
