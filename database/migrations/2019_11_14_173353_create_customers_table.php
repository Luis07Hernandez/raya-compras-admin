<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('restaurant_name');
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->integer('customer_status');
            $table->string('remember_token');
            $table->string('	phone');
            $table->string('cellphone');
            $table->string('rfc');
            $table->string('adress_id');

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
        Schema::dropIfExists('customers');
    }
}
