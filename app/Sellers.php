<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    

    protected $table= 'sellers';
    protected $fillable = ['id', 'name','phone','sku','url'];
 
}
