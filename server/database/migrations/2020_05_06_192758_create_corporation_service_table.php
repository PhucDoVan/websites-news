<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorporationServiceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporation_service', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('サービス契約状況ID');
            $table->timestamps();
            $table->bigInteger('corporation_id')->unsigned()->index('corporation_service_corporation_FK_idx')->comment('法人ID');
            $table->bigInteger('service_id')->unsigned()->index('corporation_service_service_FK_idx')->comment('サービスID');
            $table->boolean('status')->comment('契約ステータス');
            $table->string('reason')->nullable()->comment('契約動機・理由');
            $table->dateTime('terminated_at')->nullable()->comment('解約日時');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corporation_service');
    }

}
