<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fare_setting_id')->default(null);
		    $table->integer('cab_id')->default(null);
		    $table->string('zone_id', 200)->default(null);
		    $table->string('category', 122)->default(null);
		    $table->string('description', 2000)->default(null);
		    $table->integer('status')->default('1');
		    $table->integer('one_passanger_percent')->default(null);
		    $table->integer('two_passanger_percent')->default(null);
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
        Schema::dropIfExists('packages');
    }
}
