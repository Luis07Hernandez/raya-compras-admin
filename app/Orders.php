<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
            'id','num_items','customer_id','created_at','delivery_date','comments','delivery_date',
            'subtotal','shipping_cost','total','status_payment','order_status'
    ];

    public function orderDetail(){
        return $this->hasMany('App\Order_details','orders_id','id');
    }

    public function customer(){
        return $this->hasOne('App\Customers','id','customer_id');
    }
}
