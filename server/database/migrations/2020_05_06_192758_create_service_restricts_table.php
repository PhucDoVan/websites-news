<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceRestrictsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_restricts', function (Blueprint $table) {
            $table->bigInteger('service_restrict_id', true)->comment('サービス制限ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->bigInteger('account_id')->unsigned()->nullable()->index('service_restrict_account_FK_idx')->comment('アカウントID');
            $table->smallInteger('type')->nullable()->comment('制限タイプ 10:IP 20:エリア 30:受付期限 40:登記目的 50:用途');
            $table->string('value', 50)->nullable()->comment('制限値');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_restricts');
    }

}
