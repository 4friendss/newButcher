<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productFiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned()->index();
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->string('title');
            $table->string('description');
            $table->integer('discount');
            $table->date('produce_date');
            $table->date('expire_date');
            $table->string('produce_place');
            $table->integer('unit_count_id')->unsigned()->index();
            $table->foreign('unit_count_id')->references('id')->on('unit_count');
            $table->integer('sub_unit_count_id')->unsigned()->index();
            $table->foreign('sub_unit_count_id')->references('id')->on('sub_unit_count');
            $table->string('sell_count');
            $table->string('seen_count');
            $table->string('ready_time');
            $table->string('video_src');
            $table->integer('warehouse_id')->unsigned()->index();
            $table->foreign('warehouse_id')->references('id')->on('warehouse');
            $table->integer('sum_price');
            $table->integer('delivery_volume');
            $table->integer('discount_volume');
            $table->tinyInteger('active')->default('1');
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
        Schema::dropIfExists('productFiles');
    }
}
