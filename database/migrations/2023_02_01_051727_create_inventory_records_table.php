<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_records', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->integer('locker_id')->nullable();
            $table->string('quantity');
            $table->text('notes');
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
        Schema::dropIfExists('inventory_records');
    }
}
