<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tokens')->insert([
            [
                'account_id' => 1,
                'service_id' => 1,
                'token'      => 'ec68391f-ba6e-4ad0-a12e-74f5225eade6',
                'expires_in' => date('Y-m-d H:i:s', 1617235200),
            ],
            [
                'account_id' => 4,
                'service_id' => 1,
                'token'      => 'f38a077f-bcc1-40b8-83c2-af94c3d4c826',
                'expires_in' => date('Y-m-d H:i:s', 1585878138),
            ],
        ]);
    }
}
