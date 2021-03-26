<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id','name','description', 'price', 'key','category_id','unit_id','status','outstanding','product_key','image'
    ];

    public function getProduct(){
        return $this->hasOne('App\Products','id','product_id');
    }

    public function getUnit(){
        return $this->hasOne('App\Units','id','unit_id');
    }

    public function getUnitsPrice(){
        //return $this->belongsToMany('App\Units','product_units','unit_id','product_id');
        return $this->hasMany('App\ProductUnit','product_id','id');
    }

    public static function fileAttribute($file,$products_id = null){

        if(is_file($file)){
            $folder = public_path().'/image_products';

            //$title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $fileName = \Str::random(10)."_".time(). "." . $ext;
            $path = '/image_products/'.$fileName;

            if($products_id != null){
                $product = Products::where('id',$products_id)->first();
                if($product->image != ''){
                    if(file_exists(public_path().'/'.$product->image)){
                        unlink(public_path().'/'.$product->image);
                    }
                }
            }


            if(!file_exists($folder)){
                mkdir($folder, 0777, true);
                $file->move($folder, $fileName);
            }else{
                $file->move($folder, $fileName);
            }


            return $path;
        }else{
            return null;
        }
    }


}
