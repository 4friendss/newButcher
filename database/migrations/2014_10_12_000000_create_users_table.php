<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('family');
            $table->string('cellphone');
            $table->date('birth_date');
            $table->date('register_date');
            $table->string('address');
            $table->integer('capital_city_id');
            $table->integer('town_city_id');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('active')->default('1');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
