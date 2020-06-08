<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorporationServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('corporation_service')->insert([
            [
                'corporation_id' => 1,
                'service_id'     => 1,
                'status'         => 1,
                'reason'         => 'JONからの営業',
                'terminated_at'  => null,
            ],
            [
                'corporation_id' => 2,
                'service_id'     => 1,
                'status'         => 0,
                'reason'         => 'JONからの営業',
                'terminated_at'  => null,
            ],
        ]);
    }
}
