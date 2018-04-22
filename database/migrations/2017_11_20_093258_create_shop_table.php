<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('address');
            $table->integer('tel');
            $table->integer('capital_city_id')->unsigned()->index();
            $table->foreign('capital_city_id')->references('id')->on('cities');
            $table->integer('town_city_id')->unsigned()->index();
            $table->foreign('town_city_id')->references('id')->on('cities');
            $table->string('user_name');
            $table->string('password');
            $table->string('permission_pic');
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
        Schema::dropIfExists('shops');
    }
}
