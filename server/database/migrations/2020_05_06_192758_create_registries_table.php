<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegistriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registries', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->bigInteger('corporation_id')->unsigned()->index('registry_corporation_FK_idx')->comment('法人ID');
            $table->bigInteger('group_id')->unsigned()->index('registry_group_FK_idx')->comment('部門ID');
            $table->bigInteger('account_id')->unsigned()->index('registry_account_FK_idx')->comment('アカウントID');
            $table->string('label')->comment('ラベル');
            $table->string('v1_code', 13)->comment('V1コード');
            $table->boolean('number_type')->comment('番号種別（用途）');
            $table->string('number', 50)->comment('地番・家屋番号');
            $table->boolean('pdf_type')->comment('種類');
            $table->string('s3_object_url')->comment('S3オブジェクトURL');
            $table->dateTime('requested_at')->nullable()->comment('取得依頼日時');
            $table->dateTime('based_at')->comment('鮮度基準日時');
            $table->decimal('latitude', 10, 8)->comment('取得緯度');
            $table->decimal('longitude', 11, 8)->comment('取得経度');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registries');
    }

}
