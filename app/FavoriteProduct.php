<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $table = "favorite_products";

    protected $fillable = ["customer_id","product_id"];
}
