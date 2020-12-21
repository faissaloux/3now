<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_request_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id');
		    $table->integer('promocode_id')->default(null);
		    $table->string('payment_id', 255)->default(null);
		    $table->string('payment_mode', 255)->default(null);
		    $table->integer('fixed')->default('0.00');
		    $table->integer('distance')->default('0.00');
		    $table->integer('commision')->default('0.00');
		    $table->integer('discount')->default('0.00');
		    $table->integer('tax')->default('0.00');
		    $table->integer('wallet')->default('0.00');
		    $table->integer('surge')->default('0.00');
		    $table->integer('total')->default('0.00');
		    $table->string('base_earn', 255)->default(null);
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
        Schema::dropIfExists('user_request_payments');
    }
}
