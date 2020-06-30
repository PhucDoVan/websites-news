<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Profile Id');
            $table->timestamps();
            $table->softDeletes()->comment('deleted_at');
            $table->bigInteger('user_id')->unsigned()->index('profiles_user_FK')->comment('User Id');
            $table->string('full_name', 50)->nullable()->comment('FullName');
            $table->string('avatar')->nullable()->comment('Avatar');
            $table->string('phone', 50)->nullable()->comment('Phone');
            $table->string('facebook', 250)->nullable()->comment('Facebook');
            $table->string('google', 250)->nullable()->comment('Google');
            $table->string('twitter', 250)->nullable()->comment('Twitter');
            $table->dateTime('birthday')->nullable()->comment('Birthday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
