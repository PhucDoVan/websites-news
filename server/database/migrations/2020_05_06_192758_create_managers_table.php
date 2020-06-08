<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->bigInteger('manager_id', true)->comment('管理者ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->string('name', 50)->nullable()->comment('管理者名');
            $table->string('username', 50)->nullable()->unique('manager_username_UNIQUE')->comment('ユーザー名');
            $table->string('password')->nullable()->comment('パスワード');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('managers');
    }

}
