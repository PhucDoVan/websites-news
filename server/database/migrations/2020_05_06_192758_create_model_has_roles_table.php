<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModelHasRolesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned()->index('model_has_roles_role_FK_idx')->comment('ロールID');
            $table->string('model_type')->comment('モデルタイプ');
            $table->bigInteger('model_id')->unsigned()->comment('モデルID');
            $table->primary(['role_id', 'model_type', 'model_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('model_has_roles');
    }

}
