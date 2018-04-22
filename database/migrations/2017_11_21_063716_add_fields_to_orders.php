<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {


            $table->string('user_coordination');
            $table->date('date');
            $table->time('time');
            $table->tinyInteger('pay');
            $table->string('transaction_code');
            $table->integer('payment_type_id')->unsigned()->index();
            $table->foreign('payment_type_id')->references('id')->on('payment_type');
            $table->integer('total_price');
            $table->integer('discount_price');
            $table->integer('factor_price');
            $table->tinyInteger('active')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
