<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('later', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_type', 255)->default(null);
		    $table->string('order_date', 255)->default(null);
		    $table->string('order_time', 255)->default(null);
		    $table->string('kindersitz', 255)->default(null);
		    $table->string('babyschale', 255)->default(null);
		    $table->string('nameschield', 255)->default(null);
		    $table->text('note');
		    $table->string('user_id', 255)->default(null);
		    $table->string('s_latitude', 255)->default(null);
		    $table->string('d_latitude', 255)->default(null);
		    $table->string('d_longitude', 255)->default(null);
		    $table->string('s_longitude', 255)->default(null);
		    $table->string('s_address', 255)->default(null);
		    $table->string('d_address', 255)->default(null);
		    $table->string('distance', 255)->default(null);
		    $table->string('payment_mode', 255)->default(null);
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
        Schema::dropIfExists('later');
    }
}
