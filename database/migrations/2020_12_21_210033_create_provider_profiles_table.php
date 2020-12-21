<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id');
		    $table->string('language', 255)->default(null);
		    $table->string('address', 255)->default(null);
		    $table->string('address_secondary', 255)->default(null);
		    $table->string('city', 255)->default(null);
		    $table->string('country', 255)->default(null);
		    $table->string('postal_code', 255)->default(null);
		    $table->string('description', 1000)->default(null);
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
        Schema::dropIfExists('provider_profiles');
    }
}
