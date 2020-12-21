<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id')->default(null);
		    $table->string('paypal_id', 200)->default(null);
		    $table->string('account_name', 222)->default(null);
		    $table->string('bank_name', 222)->default(null);
		    $table->integer('account_number')->default(null);
		    $table->integer('routing_number')->default(null);
		    $table->string('country', 222)->default(null);
		    $table->string('currency', 22)->default(null);
		    $table->string('status', 122)->default('WAITING');
            $table->enum('type', ['bank', 'paypal']);
            
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
        Schema::dropIfExists('bank_accounts');
    }
}
