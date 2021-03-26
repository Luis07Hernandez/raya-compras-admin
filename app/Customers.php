<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customers extends Authenticatable implements JWTSubject
{

    protected $table= 'customers';
    
    protected $fillable = [
        'id','commercial_name', 'last_name','email','password', 'customer_status', 'remember_token'
        ,'phone', 'cellphone','address','adress_id','rfc','contact_name','seller_id','contpaqi'
    ];

        
    public function Sellers(){
        return $this->hasMany('App\Sellers','id','seller_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
