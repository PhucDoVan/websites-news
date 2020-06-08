<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTokensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->foreign('account_id',
                'token_account_FK')->references('account_id')->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('service_id',
                'token_service_FK')->references('id')->on('services')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign('token_account_FK');
            $table->dropForeign('token_service_FK');
        });
    }

}
