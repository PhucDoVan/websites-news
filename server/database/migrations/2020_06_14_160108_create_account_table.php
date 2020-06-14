<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('ID');
            $table->timestamps();
            $table->softDeletes()->comment('deleted_at');
            $table->string('email')->comment('Email');
            $table->string('password')->comment('password');
            $table->text('permissions')->nullable()->comment('Permission');
            $table->timestamp('last_login')->comment('Last_login');
            $table->string('first_name')->nullable()->comment('first_name');
            $table->string('last_name')->nullable()->comment('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
