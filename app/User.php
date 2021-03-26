<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function fileAttribute($file,$provider_id = null){

        if(is_file($file)){
            $folder = public_path().'/providers_logo';
            
            $ext = $file->getClientOriginalExtension();
            $fileName = \Str::random(10)."_".time(). "." . $ext;
            $path = '/providers_logo/'.$fileName;

            if($provider_id != null){
                $provider = User::where('id',$provider_id)->first();
                if($provider->image != ''){
                    if(file_exists(public_path().'/'.$provider->image)){
                        unlink(public_path().'/'.$provider->image);
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
