<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
		    $table->string('booking_id', 255);
		    $table->integer('user_id');
		    $table->integer('dispatcher_id')->default('0');
		    $table->integer('corporate_id')->default('0');
		    $table->integer('provider_id')->default('0');
		    $table->integer('current_provider_id');
		    $table->integer('service_type_id');
		    $table->enum('status', ['SEARCHING', 'CANCELLED', 'ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED', 'COMPLETED', 'SCHEDULED']);
		    $table->enum('cancelled_by', ['NONE', 'USER', 'PROVIDER']);
		    $table->string('cancel_reason', 255)->default(null);
		    $table->enum('payment_mode', ['CASH', 'CARD', 'PAYPAL']);
		    $table->string('promo_code', 50)->default(null);
		    $table->integer('paid')->default('0');
		    $table->integer('distance')->default(null);
		    $table->string('s_address', 255)->default(null);
		    $table->integer('s_latitude');
		    $table->integer('s_longitude');
		    $table->string('d_address', 255)->default(null);
		    $table->integer('d_latitude');
		    $table->integer('d_longitude');
		    $table->time('assigned_at')->nullable()->default(null);
		    $table->time('schedule_at')->nullable()->default(null);
		    $table->time('started_at')->nullable()->default(null);
		    $table->time('finished_at')->nullable()->default(null);
		    $table->boolean('user_rated')->default('0');
		    $table->boolean('provider_rated')->default('0');
		    $table->integer('estimated_fare')->default('0');
		    $table->boolean('use_wallet')->default('0');
		    $table->boolean('surge')->default('0');
		    $table->longText('route_key');
		    $table->enum('req_type', ['AUTO', 'MANUAL']);
		    $table->text('special_note');
		    $table->integer('req_zone_id')->default('0');
		    $table->integer('payment_method_id')->default('0');
		    $table->string('verification_code', 50)->default(null);
		    $table->string('kindersitz', 255)->default(null);
		    $table->string('babyschale', 255)->default(null);
		    $table->string('nameschield', 255)->default(null);
		    $table->text('note');
		    $table->string('total', 255)->default(null);
		    $table->string('return_at', 255)->default(null);
		    $table->string('going_at', 255)->default(null);
		    $table->string('handynummer', 255)->default(null);
		    $table->string('nameshield_name', 255)->default(null);
		    $table->string('vorname', 255)->default(null);
		    $table->string('nachname', 255)->default(null);
		    $table->string('emailadress', 255)->default(null);
		    $table->string('tips', 255)->default(null);
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
        Schema::dropIfExists('user_requests');
    }
}
