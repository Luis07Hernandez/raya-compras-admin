<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $table = "product_units";

    protected $fillable = ["product_id","unit_id","price","product_key","isShow"];
}
