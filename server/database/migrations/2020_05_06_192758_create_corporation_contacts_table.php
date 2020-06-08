<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorporationContactsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporation_contacts', function (Blueprint $table) {
            $table->bigInteger('corporation_contact_id', true)->comment('法人.連絡先ID');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
            $table->bigInteger('corporation_id')->unsigned()->nullable()->index('contact_corporation_PK')->comment('法人ID');
            $table->string('name', 100)->nullable()->comment('連絡先名、支払いについて、契約について');
            $table->string('tel', 50)->nullable()->comment('電話番号');
            $table->string('email', 250)->nullable()->comment('メールアドレス');
            $table->string('fax', 50)->nullable()->comment('FAX');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corporation_contacts');
    }

}
