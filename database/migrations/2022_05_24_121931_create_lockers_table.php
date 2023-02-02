<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lockers');
        Schema::create('lockers', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('id')->on('locker_sizes')->onDelete('cascade');
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->integer('row');
            $table->integer('column');
            $table->string('relay');
            $table->string('comment')->nullable();
            $table->string('status');
            $table->integer('booking_id')->nullable();
            $table->integer('occupied_by')->nullable();
            $table->string('occupied_until')->nullable();
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
        Schema::dropIfExists('lockers');
    }
}
