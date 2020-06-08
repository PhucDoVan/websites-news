<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'service_id' => 1,
                'label'      => '法⼈に関する操作',
                'name'       => 'corporation',
            ],
            [
                'service_id' => 1,
                'label'      => '部⾨に関する操作',
                'name'       => 'group',
            ],
            [
                'service_id' => 1,
                'label'      => '全体のアカウントに関する操作',
                'name'       => 'whole_account',
            ],
            [
                'service_id' => 1,
                'label'      => '⾃⾝のアカウントに関する操作',
                'name'       => 'self_account',
            ],
            [
                'service_id' => 1,
                'label'      => '全体のログに関する操作',
                'name'       => 'whole_log',
            ],
            [
                'service_id' => 1,
                'label'      => '⾃⾝のログに関する操作',
                'name'       => 'self_log',
            ],
            [
                'service_id' => 1,
                'label'      => '全体の料⾦に関する操作',
                'name'       => 'whole_bill',
            ],
            [
                'service_id' => 1,
                'label'      => '⾃⾝の料⾦に関する操作',
                'name'       => 'self_bill',
            ],
            [
                'service_id' => 1,
                'label'      => '全体の登記情報に関する操作',
                'name'       => 'whole_touki',
            ],
            [
                'service_id' => 1,
                'label'      => '⾃⾝の登記情報に関する操作',
                'name'       => 'self_touki',
            ],
            [
                'service_id' => 1,
                'label'      => 'コンテンツに関する操作',
                'name'       => 'content',
            ],
            [
                'service_id' => 2,
                'label'      => '全体統括',
                'name'       => 'admin',
            ],
        ]);
    }
}
