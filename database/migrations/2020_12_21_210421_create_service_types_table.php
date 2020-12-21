<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
		    $table->string('provider_name', 255)->default(null);
		    $table->string('image', 255)->default(null);
		    $table->string('capacity', 222)->default(null);
		    $table->string('fixed', 11);
		    $table->integer('price');
		    $table->integer('minute');
		    $table->integer('distance');
		    $table->enum('calculator', ['MIN', 'HOUR', 'DISTANCE', 'DISTANCEMIN', 'DISTANCEHOUR']);
		    $table->string('description', 255)->default(null);
		    $table->integer('status')->default('0');
		    $table->string('bags', 255)->default(null);
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
        Schema::dropIfExists('service_types');
    }
}
