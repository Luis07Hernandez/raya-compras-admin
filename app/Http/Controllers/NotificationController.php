<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{

   public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNotification(){

        $user = Auth::user();
        if( $user->status === 0){

            $notifications = Notification::select("notifications.created_at","categories.name","notifications.order_id")
            ->leftjoin("orders","notifications.order_id","=","orders.id")
            ->leftjoin("order_details","orders.id","=","order_details.orders_id")
            ->leftjoin("products","order_details.product_id","=","products.id")
            ->leftjoin("categories","products.category_id","=","categories.id")
            ->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
            ->where("notifications.provider_id",$user->id)
            ->orderBy("created_at","DESC")->distinct()->get();

            foreach($notifications as $notification){
                $notification->message = 'En la orden #'.$notification->order_id.' se agregaron productos de la categoría '.$notification->name;
            }

           return response()->json(["notifications" => $notifications],200);
        }else{
            return [];
        }
    }

     public function getCountNotification(){

        $user = Auth::user();
        if( $user->status === 0){
            $notifications = Notification::select("notifications.created_at","categories.name","notifications.order_id")
            ->leftjoin("orders","notifications.order_id","=","orders.id")
            ->leftjoin("order_details","orders.id","=","order_details.orders_id")
            ->leftjoin("products","order_details.product_id","=","products.id")
            ->leftjoin("categories","products.category_id","=","categories.id")
            ->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
            ->where([["notifications.provider_id",$user->id],["categories_providers.providers_id",$user->id],["notifications.isRead",0]])
            ->distinct()->get();

           return response()->json(["notifications" => sizeof($notifications)],200);
        }else{
            return response()->json(["notifications" => 0],200);
        }
    }

    public function updateNotification(){
        $user = Auth::user();
        if( $user->status === 0){
            $notifications = Notification::where([["provider_id",$user->id],["isRead",0]])->get();
            foreach($notifications as $notification){
                $notification->isRead = 1;
                $notification->update();
            }
        }



    }
}
