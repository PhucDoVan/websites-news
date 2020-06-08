<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigInteger('account_id', true)->unsigned()->comment('アカウントID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->bigInteger('corporation_id')->unsigned()->index('corporation_FK_idx')->comment('法人ID');
            $table->bigInteger('group_id')->unsigned()->index('group_FK_idx')->comment('部門ID');
            $table->string('username', 9)->comment('ユーザー名');
            $table->string('password')->comment('パスワード');
            $table->string('name_last', 50)->comment('アカウント名.姓');
            $table->string('name_first', 50)->comment('アカウント名.名');
            $table->string('kana_last', 50)->comment('アカウント名（カナ）.姓');
            $table->string('kana_first', 50)->comment('アカウント名（カナ）.名');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->char('t_service_id', 8)->nullable()->comment('民事ID');
            $table->dateTime('shikakumap_registered_at')->nullable()->comment('シカクマップ登録日時');
            $table->dateTime('shikakumap_deregistered_at')->nullable()->comment('シカクマップ解除日時');
            $table->unique(['username', 'deleted_at'], 'account_username_UNIQUE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }

}
