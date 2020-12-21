<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name')->nullable()->default('NULL');
            $table->enum('payment_mode',['CASH','CARD','PAYPAL']);
            $table->string('email');
            $table->string('mobile')->nullable()->default('NULL');
            $table->string('password');
            $table->string('picture')->nullable()->default('NULL');
            $table->string('device_token')->nullable()->default('NULL');
            $table->string('device_id')->nullable()->default('NULL');
            $table->enum('device_type',['android','ios']);
            $table->enum('login_by',['manual','facebook','google']);
            $table->string('social_unique_id')->nullable()->default('NULL');
            $table->integer('latitude')->default(null);
		    $table->integer('longitude')->default(null);
            $table->integer('zone_id')->default('0');
            $table->string('stripe_cust_id')->nullable()->default('NULL');
            $table->integer('wallet_balance');
            $table->decimal('rating',4,2)->default('5.00');
            $table->integer('otp');
            $table->string('remember_token',100)->nullable()->default('NULL');
            $table->integer('status')->default('0');
            $table->text('access_toekn');
            $table->string('android_token',300)->nullable()->default('NULL');
            $table->string('ios_token',300)->nullable()->default('NULL');
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
        Schema::dropIfExists('users');
    }
}
