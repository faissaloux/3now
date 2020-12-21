<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
		    $table->string('email', 100);
		    $table->integer('phone')->default(null);
		    $table->string('subject', 250)->default(null);
		    $table->string('message', 250)->default(null);
		    $table->string('type', 50)->default(null);
		    $table->text('attachment');
		    $table->integer('status')->default('1');
		    $table->integer('transfer')->default('0');
		    $table->text('reply');
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
        Schema::dropIfExists('complaints');
    }
}
