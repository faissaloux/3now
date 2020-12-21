<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('zone_id')->nullable();
            $table->string('first_name');
            $table->string('last_name')->default('');
            $table->string('email');
            $table->string('mobile')->nullable()->default('NULL');
            $table->string('password');
            $table->string('avatar')->nullable()->default('NULL');
            $table->string('device_id')->nullable()->default('NULL');
            $table->decimal('rating',4,2)->default('5.00');
            $table->enum('status',['onboarding','approved','banned']);
            $table->integer('fleet')->default('0');
            $table->integer('latitude')->default(null);
		    $table->integer('longitude')->default(null);
            $table->string('remember_token',100)->nullable()->default('NULL');
            $table->enum('login_by',['manual','facebook','google']);
            $table->string('social_unique_id')->nullable()->default('NULL');
            $table->enum('device_type',['android','ios']);
            $table->string('device_token')->nullable()->default('NULL');
            $table->integer('term_n')->default('0');
            $table->integer('logged_in')->default('0');
            $table->text('access_token');
            $table->string('provider_type')->nullable()->default('NULL');
            $table->string('statue')->nullable()->default('NULL');
            $table->string('ios_token',300)->nullable()->default('NULL');
            $table->string('android_token',300)->nullable()->default('NULL');
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
        Schema::dropIfExists('providers');
    }
}
