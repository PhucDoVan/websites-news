<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('パーミッションID');
            $table->bigInteger('service_id')->unsigned()->index('permissions_service_FK_idx')->comment('サービスID');
            $table->string('label')->comment('ラベル');
            $table->string('name')->comment('パーミッション名');
            $table->timestamps();
            $table->unique(['service_id', 'name'], 'permission_in_service_UNIQUE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }

}
