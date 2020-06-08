<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                'name'  => 'シカクマップ',
                'token' => '3874f2b7-ec9a-4858-846d-c9a3e6aa8be9',
            ],
            [
                'name'  => 'マダミヌサービス',
                'token' => '54a60370-5328-4d74-8680-3de50d00ad22',
            ],
        ]);
    }
}
