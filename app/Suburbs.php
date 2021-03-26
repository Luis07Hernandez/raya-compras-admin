<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suburbs extends Model
{

    protected $table= 'shipping_address';
    protected $fillable = [
        'id' ,'zipcode','name','cities_id'];

}
