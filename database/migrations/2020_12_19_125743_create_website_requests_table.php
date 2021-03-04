<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_requests', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('website_id')->nullable();
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');

            $table->boolean("available")->default(false);

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
        Schema::dropIfExists('website_requests');
    }
}
