<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shipping_address extends Model
{


    protected $table= 'shipping_address';
    protected $fillable = [
        'id', 'contact_name','street','num_ext', 'num_int', 'zipcode', 'city_id', 'phone','cellphone','suburbs_id','cities_id','created_at','updated_at','customers_id','is_main'
    ];
}
