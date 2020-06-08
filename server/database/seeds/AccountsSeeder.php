<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'corporation_id' => 1,
                'group_id'       => 1,
                'username'       => 'Ab7-abc72',
                'password'       => bcrypt('password'),
                'name_last'      => '⽥中',
                'name_first'     => '太郎',
                'kana_last'      => 'タナカ',
                'kana_first'     => 'タロウ',
                'email'          => 't_tanaka@example.com',
                't_service_id'   => null,
                'deleted_at'     => null,
            ],
            [
                'corporation_id' => 1,
                'group_id'       => 3,
                'username'       => 'Ab7-def34',
                'password'       => bcrypt('password'),
                'name_last'      => '⼭⽥',
                'name_first'     => '花⼦',
                'kana_last'      => 'ヤマダ',
                'kana_first'     => 'ハナコ',
                'email'          => 'h_yamada@example.com',
                't_service_id'   => null,
                'deleted_at'     => null,
            ],
            [
                'corporation_id' => 1,
                'group_id'       => 3,
                'username'       => 'Ab7-ghi56',
                'password'       => bcrypt('password'),
                'name_last'      => '鈴⽊',
                'name_first'     => '⼀郎',
                'kana_last'      => 'スズキ',
                'kana_first'     => 'イチロウ',
                'email'          => 'i_suzuki@example.com',
                't_service_id'   => null,
                'deleted_at'     => null,
            ],
            [
                'corporation_id' => 2,
                'group_id'       => 4,
                'username'       => 'Cd2-xyz78',
                'password'       => bcrypt('password'),
                'name_last'      => '佐藤',
                'name_first'     => 'たけし',
                'kana_last'      => 'サトウ',
                'kana_first'     => 'タケシ',
                'email'          => 't_sato@example.com',
                't_service_id'   => null,
                'deleted_at'     => null,
            ],
            [
                'corporation_id' => 1,
                'group_id'       => 5,
                'username'       => 'Ab7-jkm99',
                'password'       => bcrypt('password'),
                'name_last'      => '渡辺',
                'name_first'     => 'ひろし',
                'kana_last'      => 'ワタナベ',
                'kana_first'     => 'ヒロシ',
                'email'          => 'h_watanabe@example.com',
                't_service_id'   => null,
                'deleted_at'     => new DateTime('2020-04-03 11:30:00'),
            ],
        ]);
    }
}
