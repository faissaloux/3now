<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRequestRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_request_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id');
		    $table->integer('user_id');
		    $table->integer('provider_id');
		    $table->integer('user_rating')->default('0');
		    $table->integer('provider_rating')->default('0');
		    $table->string('user_comment', 255)->default(null);
		    $table->string('provider_comment', 255)->default(null);
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
        Schema::dropIfExists('user_request_ratings');
    }
}
