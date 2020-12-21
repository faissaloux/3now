<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
		    $table->string('stripe_cust_id', 100)->default(null);
		    $table->string('card_fingerprint', 100)->default(null);
		    $table->string('last_four', 255)->default(null);
		    $table->string('card_id', 255)->default(null);
		    $table->string('brand', 255)->default(null);
		    $table->integer('is_default')->default('0');
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
        Schema::dropIfExists('cards');
    }
}
