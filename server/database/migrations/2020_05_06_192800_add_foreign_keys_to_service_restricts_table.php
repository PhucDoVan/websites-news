<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServiceRestrictsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_restricts', function (Blueprint $table) {
            $table->foreign('account_id',
                'service_restrict_account_FK')->references('account_id')->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_restricts', function (Blueprint $table) {
            $table->dropForeign('service_restrict_account_FK');
        });
    }

}
