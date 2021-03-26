<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'id','qty','customer_id','product_id','orders_id','unit_id','unit_price','total'
    ];

    public function product(){
        return $this->hasOne('App\Products','id','product_id');
    }
}
