<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->destroyData();
        $this->call([
            CorporationsSeeder::class,
            CorporationContactsSeeder::class,
            GroupsSeeder::class,
            AccountsSeeder::class,
            ServicesSeeder::class,
            RegistriesSeeder::class,
            TokensSeeder::class,
            CorporationServiceSeeder::class,

            RolesSeeder::class,
            PermissionsSeeder::class,
            PermissionRoleSeeder::class,
            ModelHasRolesSeeder::class,
            ManagersSeeder::class,
        ]);
    }

    public function destroyData()
    {
        $this->setForeignKeyCheckOff();
        DB::table('corporations')->truncate();
        DB::table('corporation_contacts')->truncate();
        DB::table('corporation_service')->truncate();
        DB::table('managers')->truncate();
        DB::table('services')->truncate();
        DB::table('accounts')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('registries')->truncate();
        DB::table('groups')->truncate();
        DB::table('tokens')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        $this->setForeignKeyCheckOn();
    }

    private function setForeignKeyCheckOff()
    {
        switch (DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = OFF');
                break;
        }
    }

    private function setForeignKeyCheckOn()
    {
        switch (DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = ON');
                break;
        }
    }
}
