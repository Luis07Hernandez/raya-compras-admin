<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table= 'routes';
    protected $fillable = [
        'id','name'
    ];

    public function customers(){
        return $this->belongsToMany("App\Customers","routes_customers","route_id","customer_id")->withPivot("customer_id");
    }


}
