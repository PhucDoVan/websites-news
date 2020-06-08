<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorporationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->bigInteger('corporation_id', true)->unsigned()->comment('法人ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->string('name', 100)->nullable()->comment('法人名表記');
            $table->string('kana', 100)->nullable()->comment('法人名カナ');
            $table->string('uid', 3)->nullable()->unique('uid_UNIQUE')->comment('法人識別ID');
            $table->string('postal', 7)->nullable()->comment('郵便番号');
            $table->string('address_pref', 50)->nullable()->comment('都道府県');
            $table->string('address_city', 50)->nullable()->comment('市区町村');
            $table->string('address_town', 50)->nullable()->comment('町名番地');
            $table->string('address_etc', 50)->nullable()->comment('ビル・マンション名・号室');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corporations');
    }

}
