<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'service_id' => 1,
                'label'      => 'スーパーユーザー ',
                'name'       => 'shikakumap_super_user',
            ],
            [
                'service_id' => 1,
                'label'      => '利⽤者',
                'name'       => 'shikakumap_user',
            ],
            [
                'service_id' => 2,
                'label'      => '管理者',
                'name'       => 'xxx_admin',
            ],
        ]);
    }
}
