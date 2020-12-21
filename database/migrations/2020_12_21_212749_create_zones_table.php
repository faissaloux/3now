<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country', 200)->default(null);
		    $table->string('city', 200)->default(null);
		    $table->string('state', 200)->default(null);
		    $table->string('zone_name', 255);
		    $table->string('currency', 200);
		    $table->string('status', 200)->default(null);
		    $table->string('background', 255)->default(null);
            $table->string('draw_lines', 255)->default(null);
            $table->binary('coordinate');
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
        Schema::dropIfExists('zones');
    }
}
