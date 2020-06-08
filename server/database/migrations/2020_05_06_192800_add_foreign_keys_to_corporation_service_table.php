<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCorporationServiceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corporation_service', function (Blueprint $table) {
            $table->foreign('corporation_id',
                'corporation_service_account_FK')->references('corporation_id')->on('corporations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('service_id',
                'corporation_service_service_FK')->references('id')->on('services')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corporation_service', function (Blueprint $table) {
            $table->dropForeign('corporation_service_account_FK');
            $table->dropForeign('corporation_service_service_FK');
        });
    }

}
