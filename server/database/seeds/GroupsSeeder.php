<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name'            => '経営部',
                'corporation_id'  => 1,
                'parent_group_id' => null,
                'deleted_at'      => null,
            ],
            [
                'name'            => '営業部',
                'corporation_id'  => 1,
                'parent_group_id' => null,
                'deleted_at'      => null,
            ],
            [
                'name'            => '第⼀営業課',
                'corporation_id'  => 1,
                'parent_group_id' => 2,
                'deleted_at'      => null,
            ],
            [
                'name'            => '経営部',
                'corporation_id'  => 2,
                'parent_group_id' => null,
                'deleted_at'      => null,
            ],
            [
                'name'            => '第⼆営業課 ',
                'corporation_id'  => 1,
                'parent_group_id' => 2,
                'deleted_at'      => new DateTime('2020-04-03 11:30:00'),
            ],
        ]);
    }
}
