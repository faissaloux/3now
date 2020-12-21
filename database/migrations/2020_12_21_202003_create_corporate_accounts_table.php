<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('corporate_name', 255);
		    $table->string('email', 255);
		    $table->string('password', 255);
		    $table->string('name', 255);
		    $table->string('address', 255)->default(null);
		    $table->string('phone', 255)->default(null);
		    $table->string('account_number', 255)->default(null);
		    $table->string('remember_token', 255)->default(null);
		    $table->string('credit_card', 255)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporate_accounts');
    }
}
