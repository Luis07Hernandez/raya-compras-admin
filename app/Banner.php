<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'id','title','image','description','banner_status',
    ];

    public static function fileAttribute($file,$banner_id = null){

        if(is_file($file)){
            $folder = public_path().'/image_banners';

            //$title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $fileName = \Str::random(10)."_".time(). "." . $ext;
            $path = '/image_banners/'.$fileName;

            if($banner_id != null){
                $banner = Banner::where('id',$banner_id)->first();
                if($banner->image != ''){
                    if(file_exists(public_path().'/'.$banner->image)){
                        unlink(public_path().'/'.$banner->image);
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
