<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id');
		    $table->string('document_id', 255);
		    $table->string('url', 255);
		    $table->string('unique_id', 255)->default(null);
		    $table->enum('status', ['ASSESSING', 'ACTIVE']);
		    $table->date('expires_at')->default(null);
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
        Schema::dropIfExists('provider_documents');
    }
}
