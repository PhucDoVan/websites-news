<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCorporationContactsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corporation_contacts', function (Blueprint $table) {
            $table->foreign('corporation_id',
                'contact_corporation_PK')->references('corporation_id')->on('corporations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corporation_contacts', function (Blueprint $table) {
            $table->dropForeign('contact_corporation_PK');
        });
    }

}
