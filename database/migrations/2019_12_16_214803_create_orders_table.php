<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('num_items');
            $table->integer('customer_id');
            $table->dateTime('delivery_date');
            $table->double('subtotal');
            $table->double('shipping_cost');
            $table->double('total');
            $table->integer('status_payment')->comment("1: Tarjeta de debito/creadito, 0: Efectivo");
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
        Schema::dropIfExists('orders');
    }
}
