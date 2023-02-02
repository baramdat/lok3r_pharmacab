<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_state');
            $table->string('trans_type');
            $table->string('reg_type');
            $table->string('is_finance');
            $table->string('add_info')->nullable();
            $table->string('num_lease')->nullable();
            $table->string('lien')->nullable();
            $table->string('on_lease');
            $table->string('veh_type');
            $table->string('veh_id_num');
            $table->string('veh_year');
            $table->string('veh_make');
            $table->string('veh_model'); 
            $table->string('veh_color');
            $table->string('veh_mile');
            $table->string('total_price');
            $table->string('trade_ins');
            $table->string('amount')->nulable();
            $table->string('veh_weight');
            $table->string('cylinders');
            $table->string('fuel_type');
            $table->string('gross_weight');
            $table->string('registrant_1');
            $table->string('registrant_2');
            $table->string('owner_1');
            $table->string('owner_2');
            $table->string('social');
            $table->string('transaction_for');
            $table->string('comapny_name')->nulable();
            $table->string('customer_address');
            $table->string('customer_address_2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('status')->default('1');

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
        Schema::dropIfExists('transactions');
    }
}
