<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('部門ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->string('name')->comment('部門名称');
            $table->bigInteger('corporation_id')->unsigned()->index('group_corporation_FK_idx')->comment('法人ID');
            $table->bigInteger('parent_group_id')->unsigned()->nullable()->index('group_parent_group_FK_idx')->comment('親部門ID');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groups');
    }

}
