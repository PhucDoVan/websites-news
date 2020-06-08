<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->insert([
            [
                'name'     => '管理者',
                'username' => 'admin',
                'password' => bcrypt('admin'),
            ],
        ]);
    }
}
