<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorporationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('corporations')->insert([
            [
                'name'         => '株式会社 エー・ビー・シー',
                'kana'         => 'エービーシー',
                'uid'          => 'Ab7',
                'postal'       => '9200907',
                'address_pref' => '⽯川県',
                'address_city' => '⾦沢市',
                'address_town' => '⻘草町',
                'address_etc'  => '1-2-3'
            ],
            [
                'name'         => '有限会社 xx商事',
                'kana'         => 'xxショウジ',
                'uid'          => 'Cd2',
                'postal'       => '8740902',
                'address_pref' => '⼤分県',
                'address_city' => '別府市',
                'address_town' => '⻘⼭町',
                'address_etc'  => null
            ]
        ]);
    }
}
