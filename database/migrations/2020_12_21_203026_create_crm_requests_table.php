<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('crm_user_id')->unsigned();
		    $table->string('booking_id', 255);
		    $table->integer('user_id')->unsigned();
		    $table->integer('driver_id');
		    $table->string('request_type', 255);
		    $table->string('reason', 255);
		    $table->string('status', 255);
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
        Schema::dropIfExists('crm_requests');
    }
}
