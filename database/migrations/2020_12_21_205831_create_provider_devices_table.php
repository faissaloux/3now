<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id');
		    $table->string('udid', 255);
		    $table->string('token', 255);
		    $table->string('sns_arn', 255)->default(null);
		    $table->enum('type', ['android', 'ios']);
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
        Schema::dropIfExists('provider_devices');
    }
}
