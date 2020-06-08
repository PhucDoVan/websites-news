<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('サービスID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->string('name')->comment('サービス名称');
            $table->string('token')->unique('service_token_UNIQUE')->comment('サービス識別トークン');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }

}
