<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    protected $table= 'shipping_address';
    protected $fillable = [
        'id' ,'name',' states_id' ];
}
