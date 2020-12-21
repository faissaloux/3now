<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFareSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fare_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('peak_night_id', 12)->default(null);
		    $table->string('fare_plan_name', 122)->default(null);
		    $table->string('from_km', 255)->default(null);
		    $table->string('upto_km', 255)->default(null);
		    $table->string('price_per_km', 255)->default(null);
		    $table->string('waiting_price_per_min', 255)->default(null);
		    $table->enum('peak_hour', ['YES', 'NO'])->default(null);
		    $table->enum('late_night', ['YES', 'NO'])->default(null);
		    $table->string('extra_on_base_price', 34)->default(null);
		    $table->string('convenience_fee', 255)->default(null);
		    $table->string('status', 255)->default('1');
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
        Schema::dropIfExists('fare_settings');
    }
}
