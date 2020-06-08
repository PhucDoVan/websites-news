<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('corporation_id',
                'account_corporation_FK')->references('corporation_id')->on('corporations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('group_id',
                'account_group_FK')->references('id')->on('groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign('account_corporation_FK');
            $table->dropForeign('account_group_FK');
        });
    }

}
