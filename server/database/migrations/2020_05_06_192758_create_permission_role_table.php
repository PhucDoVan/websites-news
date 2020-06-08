<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionRoleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigInteger('permission_id')->unsigned()->index('permission_role_permission_FK_idx')->comment('パーミッションID');
            $table->bigInteger('role_id')->unsigned()->index('permission_role_role_FK_idx')->comment('ロールID');
            $table->boolean('level')->comment('権限レベル');
            $table->primary(['permission_id', 'role_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }

}
