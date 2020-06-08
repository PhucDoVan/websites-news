<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorporationContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('corporation_contacts')->insert([
            [
                'corporation_id' => 1,
                'name'           => null,
                'tel'            => '123-4567-8901',
                'email'          => 'abc@example.com',
                'fax'            => null,
            ],
            [
                'corporation_id' => 2,
                'name'           => '代表',
                'tel'            => '098-7654-3219',
                'email'          => 'xx_shoji@example.com',
                'fax'            => null,
            ],
        ]);
    }
}
