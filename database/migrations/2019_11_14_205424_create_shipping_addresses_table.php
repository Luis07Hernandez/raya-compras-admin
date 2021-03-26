<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_name');
            $table->string('street');
            $table->string('num_ext');
            $table->string('num_int');
            $table->string('zipcode');
            $table->integer('city_id');
            $table->string('phone');
            $table->string('cellphone');
            $table->integer('suburbs_id');
            $table->integer('cities_id');
            $table->integer('customers_id');
            $table->integer('is_main');


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
        Schema::dropIfExists('shipping_addresses');
    }
}
