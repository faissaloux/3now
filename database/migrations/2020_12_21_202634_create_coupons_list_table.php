<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
		    $table->string('valid_from', 255)->default(null);
		    $table->string('valid_to', 255)->default(null);
		    $table->string('discount_type', 255);
		    $table->string('discount', 255);
		    $table->string('maxUsage', 255)->default(null);
		    $table->string('logged', 255)->default(null);
		    $table->string('shipping', 255)->default(null);
		    $table->text('description');
		    $table->string('count', 255)->default(null);
		    $table->string('title', 255)->default(null);
		    $table->string('statue', 255)->default(null);
		    $table->string('usage_type', 255)->default(null);
		    $table->integer('user')->default(null);
		    $table->string('maxDiscount', 255)->default(null);
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
        Schema::dropIfExists('coupons_list');
    }
}
