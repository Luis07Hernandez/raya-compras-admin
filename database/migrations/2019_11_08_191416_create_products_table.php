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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->string('image');
            $table->string('key');
            $table->integer('category_id');
//            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('unit_id');
//            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('status');  //0:inactivo 1:activo 2:varios
            $table->integer('outstanding');
            $table->integer('product_key');
            $table->foreign('comments')->references('id')->on('units');
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
        Schema::dropIfExists('products');
    }
}
