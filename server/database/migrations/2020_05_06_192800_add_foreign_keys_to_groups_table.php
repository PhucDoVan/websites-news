<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->foreign('corporation_id',
                'group_corporation_FK')->references('corporation_id')->on('corporations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('parent_group_id',
                'group_parent_group_FK')->references('id')->on('groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('group_corporation_FK');
            $table->dropForeign('group_parent_group_FK');
        });
    }

}
