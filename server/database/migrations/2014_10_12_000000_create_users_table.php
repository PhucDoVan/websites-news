<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('User Id');
            $table->timestamps();
            $table->softDeletes()->comment('deleted_at');
            $table->string('name', 50)->nullable()->comment('Name');
            $table->string('username', 50)->nullable()->unique('User_username_UNIQUE')->comment('UserName');
            $table->string('email', 250)->nullable()->comment('Email');
            $table->string('password')->nullable()->comment('Password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
