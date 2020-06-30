<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'email' => 'phuc.dovan.96@gmail.com',
            ],
        ]);
    }
}
