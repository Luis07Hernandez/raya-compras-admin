<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    protected $table= 'providers';
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'categories_id'
    ];

    public function categoriesssss(){
        return $this->belongsToMany("App\Categories", "categories_providers",'providers_id','categories_id' );
       // return $this->hasMany('App\CategoriesProviders', 'id', 'providers_id' );
    }
}
