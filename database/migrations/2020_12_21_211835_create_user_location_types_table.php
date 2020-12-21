<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLocationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_location_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
		    $table->string('location_type', 50);
		    $table->string('address', 255);
		    $table->string('latitude', 50);
		    $table->string('longitude', 50);
            $table->timestamps();
		    $table->time('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_location_types');
    }
}
