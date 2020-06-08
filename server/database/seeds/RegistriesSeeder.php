<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registries')->insert([
            [
                'corporation_id' => 1,
                'group_id'       => 3,
                'account_id'     => 2,
                'label'          => '全部事項、⼟地、愛媛県松⼭市xxx',
                'v1_code'        => '3820103360000',
                'number_type'    => 1,
                'number'         => '1-2',
                'pdf_type'       => 1,
                's3_object_url'  => 'https://...',
                'requested_at'   => new DateTime('2020-04-03 11:00:00'),
                'based_at'       => new DateTime('2020-04-03 11:30:00'),
                'latitude'       => 33.8419817,
                'longitude'      => 132.760751,
            ],
            [
                'corporation_id' => 1,
                'group_id'       => 3,
                'account_id'     => 3,
                'label'          => '全部事項、⼟地、愛媛県今治市aaa',
                'v1_code'        => '3820201020002',
                'number_type'    => 1,
                'number'         => '1-2',
                'pdf_type'       => 1,
                's3_object_url'  => 'https://...',
                'requested_at'   => new DateTime('2020-04-03 11:00:00'),
                'based_at'       => new DateTime('2020-04-03 11:30:00'),
                'latitude'       => 34.1173722,
                'longitude'      => 132.9560173,
            ],
            [
                'corporation_id' => 2,
                'group_id'       => 4,
                'account_id'     => 4,
                'label'          => '所有者事項、⼟地、愛媛県松⼭市yyy',
                'v1_code'        => '3820101220000',
                'number_type'    => 1,
                'number'         => '1-2',
                'pdf_type'       => 2,
                's3_object_url'  => 'https://...',
                'requested_at'   => new DateTime('2020-04-03 11:00:00'),
                'based_at'       => new DateTime('2020-04-03 11:30:00'),
                'latitude'       => 33.8325467,
                'longitude'      => 132.7643213,
            ],
            [
                'corporation_id' => 1,
                'group_id'       => 3,
                'account_id'     => 2,
                'label'          => '全部事項、⼟地、愛媛県松⼭市zzz',
                'v1_code'        => '3820103420007',
                'number_type'    => 1,
                'number'         => '1-2',
                'pdf_type'       => 1,
                's3_object_url'  => 'https://...',
                'requested_at'   => new DateTime('2020-04-03 11:00:00'),
                'based_at'       => new DateTime('2020-04-03 11:30:00'),
                'latitude'       => 33.8329913,
                'longitude'      => 132.7518826,
            ],
        ]);
    }
}
