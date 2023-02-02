<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sites');
        Schema::create('sites', function (Blueprint $table) {
            $table->id();            
            $table->foreign('id')->references('site_id')->on('lockers')->onDelete('cascade');
            $table->foreign('id')->references('site_id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('url');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('sites');
    }
}
