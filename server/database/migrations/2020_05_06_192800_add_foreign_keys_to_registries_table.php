<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRegistriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->foreign('account_id',
                'registry_account_FK')->references('account_id')->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('corporation_id',
                'registry_corporation_FK')->references('corporation_id')->on('corporations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('group_id',
                'registry_group_FK')->references('id')->on('groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->dropForeign('registry_account_FK');
            $table->dropForeign('registry_corporation_FK');
            $table->dropForeign('registry_group_FK');
        });
    }

}
