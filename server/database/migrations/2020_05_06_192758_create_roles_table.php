<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('ロールID');
            $table->bigInteger('service_id')->unsigned()->index('roles_service_FK_idx')->comment('サービスID');
            $table->string('label')->comment('ラベル');
            $table->string('name')->unique('role_name_UNIQUE')->comment('ロール名');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }

}
