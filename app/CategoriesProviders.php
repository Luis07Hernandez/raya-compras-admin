<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesProviders extends Model
{
    protected $table= 'categories_providers';
    protected $fillable = [
        'categories_id', 'providers_id'
    ];

}
