<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('トークンID');
            $table->timestamps();
            $table->bigInteger('account_id')->unsigned()->index('token_account_FK_idx')->comment('アカウントID');
            $table->bigInteger('service_id')->unsigned()->index('token_service_FK_idx')->comment('サービスID');
            $table->string('token')->unique('access_token_UNIQUE')->comment('トークン');
            $table->dateTime('expires_in')->comment('トークン失効時間');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tokens');
    }

}
