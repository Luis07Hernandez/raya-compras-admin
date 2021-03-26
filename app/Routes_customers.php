<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routes_customers extends Model
{
    protected $table= 'routes_customers';
    protected $fillable = [
        'id','route_id','customer_id'
    ];
}
