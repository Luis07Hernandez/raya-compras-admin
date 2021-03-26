<?php

namespace App\Http\Controllers;

use App\Billing_address;
use App\Categories;
use App\Cities;
use App\Collection;
use App\Sellers;
use App\Comments;
use App\CollectionImages;
use App\Customers;
use App\Order_details;
use App\Orders;
use App\Coupon;
use App\FavoriteProduct;
use App\ProductsImages;
use App\Shipping_address;
use App\States;
use App\Suburbs;
use App\Units;
use App\User;
use App\Variables;
use App\ProductUnit;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Banner;
use App\Products;
use App\Notification;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Config;
use DB;
use Log;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use Symfony\Component\Console\Tests\CustomApplication;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log as LogOutput;

class APIController extends Controller
{

    private $status_production = false;

    function __construct()
    {
        Config::set('jwt.user', Customers::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Customers::class,
        ]]);

    }

    public function getAdminPath()
    {
        if($this->status_production){
            return 'http://admin.rayafrutasyverduras.com.mx//';
        }else{
           //
            return 'http://localhost:8000/';
        }

    }


    public function getCategories()
    {
        try{
            $categories =  Categories::all();
            return response()->json(['error'=> false, 'categories'=> $categories, 'message'=>'Listado de categorias']);

        }catch (\Exception $ex) {
                return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function banners()
    {
        try {
            $banners = Banner::select("id", "title", "description", "image")->orderBy('title', 'ASC')->get();

            if (!empty($banners)) {

                $bannersArray = array();
                foreach ($banners as $banner) {
                    $data = array(
                        "id" => $banner->id,
                        "image" => $this->getAdminPath() . $banner->image,
                        "title" => $banner->title,
                        "description" => $banner->description,
                    );

                    array_push($bannersArray, $data);
                }
                return response()->json(array('error' => false, 'banners' => $bannersArray), 200);
            } else {
                return response()->json(array('error' => false, 'message' => 'resultados no encontrados'), 200);
            }
        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

    public function getProductsOut()
    {
        try {

            $products = Products::select("id", "main_photo", "sku", "name")->where("outstanding", 1)->orderBy(DB::raw('RAND()'))->get();

            if (!empty($products)) {

                $productsArray = array();
                foreach ($products as $product) {
                    $data = array(
                        "id" => $product->id,
                        "image" => $this->getAdminPath() . $product->main_photo,
                        "name" => $product->name,
                        "sku" => $product->sku,
                    );

                    array_push($productsArray, $data);
                }

                return response()->json(array('error' => false, 'products' => $productsArray), 200);
            } else {
                return response()->json(array('error' => false, 'message' => 'resultados no encontrados'), 200);
            }
        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }



    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return response()->json(array('error' => true, 'message' => $validator->messages()->first() . '.'), 401);
            } else {
                if (!$token = JWTAuth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {

                    return response()->json(array('error' => true, 'code' => 401, 'message' => 'usuario o contraseña incorrectos'), 401);
                } else {
                    $context = JWTAuth::setToken($token);

                    $user = $context->authenticate();

                    if ( $user->customer_status == 1 ) {

                        $products = Products::select('products.id','products.name','products.description','products.image',
                        'products.category_id','products.status','categories.name as category')
                        ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
                        ->leftjoin("favorite_products","products.id","=","favorite_products.product_id")
                        ->where([["favorite_products.customer_id",$user->id],["status",1]])->get();

                        foreach($products as $product){

                            $productsUnit = ProductUnit::select("product_units.unit_id","product_units.price","units.name","product_key","product_units.isShow")
                            ->leftjoin("units","product_units.unit_id","=","units.id")                    
                            ->where("product_units.product_id",$product->id)
                            ->orderBy("product_units.isShow","desc")                
                            ->get();


                            if(!empty($productsUnit)){

                                if(isset( $productsUnit[0]->price)){
                                    if($productsUnit[0]->isShow == 1){
                                        $product->price = $productsUnit[0]->price;
                                        $product->unitNameSelected = $productsUnit[0]->name;
                                    }else{
                                        $product->price = 0; 
                                        $product->unitNameSelected = "";
                                    }
                                
                                }else{
                                    $product->price = 0; 
                                    $product->unitNameSelected = "";
                                }
                                        
                            }else{
                                $product->price = 0; 
                                $product->unitNameSelected = "";
                            }

                            $product->units = $productsUnit;
                        }



                        $data = [
                            'id' => $user->id,
                            'contact_name' => $user->contact_name,
                            'email' => $user->email,
                            'commercial_name' => $user->commercial_name,
                            'rfc' => $user->rfc,
                            'phone' => $user->phone,
                            'cellphone' => $user->cellphone,
                            'token' => $token,
                            'address' => $user->address,
                            'favProducts' =>  $products

                        ];
                        unset($user);
                        return response()->json(array('error' => false, 'message' => 'Usuario encontrado', 'status' => 200, 'client' => $data), 200);
                    } else {
                        auth()->logout(true);
                        return response()->json(array('error' => true, 'code' => 401, 'message' => 'Usuario no encontrado en nuestros registros.'), 401);
                    }
                }
            }
        } catch (\JWTException $ex) {
            return response()->json(array('error' => true, 'message' => 'Acceso no autorizado'), 401);
        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        try {

            auth()->logout(true);
            return response()->json(array('error' => false, 'message' => 'Sesión cerrada con éxito.', 'code' => 200), 200);

        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'commercial_name' => 'required',
                'contact_name' => 'required',
                'rfc' => 'required',
                'address' => 'required',
                'email' => 'required|email|unique:customers',
                'password' => 'string'
            ]);

            if ($validator->fails()) {
                return response()->json(array('error' => true,'message' => $validator->messages()->first() . '.'),401);
            }else{
                $user = Customers::create([

                    'commercial_name' => $request['commercial_name'],
                    'rfc' => $request['rfc'],
                    'contact_name' => $request['contact_name'],
                    'address' => $request['address'],
                    'cellphone' => $request['cellphone'],
                    'phone' => $request['phone'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'customer_status' => 0,
                    'seller_id' => $request['seller_id'] != null ? $request['seller_id'] : null
                ]);

                $this->sendEmail($user,$request['password']);
               return response()->json(array("error" => false,  "message" => "Usuario registrado correctamente"), 200);


            }

        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

     /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        try {

            if (! $customer = JWTAuth::parseToken()->authenticate()) {
                return response()->json(array('error'=>true,'message' => 'Usuario no encontrado.'), 404);
            }else {

                $validator = Validator::make($request->all(), [
                    'commercial_name' => 'required',
                    'contact_name' => 'required',
                    'rfc' => 'required',
                    'address' => 'required',
                    'email' => 'required|email',
                    'password' => 'nullable',
                    'confirm_password' =>'nullable|same:password',
                    ]);

                if ($validator->fails()) {
                    return response()->json(array('error' => true,'message' => $validator->messages()->first() . '.'),401);
                }else{

                    $user = Customers::find($customer->id);
                    $user->commercial_name = $request['commercial_name'];
                    $user->rfc = $request['rfc'];
                    $user->contact_name = $request['contact_name'];
                    $user->address = $request['address'];
                    $user->cellphone = $request['cellphone'];
                    $user->phone = $request['phone'];
                    $user->email = $request['email'];

                    if($request['password'] != null || $request['password'] != ''){
                        $user->password = Hash::make($request['password']);
                    }
                    
                    $user->update();

                return response()->json(array("error" => false,  "message" => "Datos actualizados correctamente"), 200);
                }
            }

         } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token a expirado'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token inválido'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token ausente'), 500);            
        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

    public function sendEmail($customer,$password){

        $path = $this->getAdminPath();

        Mail::send('emails.contact',compact('customer','path','password'),function ($msj) use ($customer){
            $msj->subject('Has recibido una solicitud de registro en plataforma de pedidos Raya');
            $msj->from('contacto@rayafrutasyverduras.com.mx','Raya - Distribuidor de frutas y verduras');
            $msj->to('administrador@rayafrutasyverduras.com.mx');
        });
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
     public function home(){
         try {

             $banners = Banner::select("id", "title", "description", "image")->where('banner_status',1)->get();

            $products = Products::select('products.id','products.name','products.description','products.image',
             'products.category_id','products.status','categories.name as category')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->where([["outstanding",1],["status",1]])->orderBy('products.name','ASC')->get();

            foreach($products as $product){

                $productsUnit = ProductUnit::select("product_units.unit_id",
                //"product_units.price",
                "units.name","product_key","product_units.isShow")
                ->leftjoin("units","product_units.unit_id","=","units.id")                    
                ->where("product_units.product_id",$product->id)
                ->orderBy("product_units.isShow","desc")                
                ->get();


                if(!empty($productsUnit)){

                    if(isset( $productsUnit[0]->price)){
                        if($productsUnit[0]->isShow == 1){
                            //$product->price = $productsUnit[0]->price;
                            $product->unitNameSelected = $productsUnit[0]->name;
                        }else{
                            // $product->price = 0; 
                            $product->unitNameSelected = "";
                        }
                      
                    }else{
                        //$product->price = 0; 
                         $product->unitNameSelected = "";
                    }
                            
                }else{
                   // $product->price = 0; 
                    $product->unitNameSelected = "";
                }

                $product->units = $productsUnit;
            }

             return response()->json(array('error' => false, 'banners' => $banners, 'products' => $products,'message' => 'Datos del home'), 200);
         } catch (\Exception $ex) {
             return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
         }
     }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

     public function getProducts($category_id,$keyword = null){

        $customerData = null;
        try{
            if ($customer = JWTAuth::parseToken()->authenticate()) {
                $customerData = $customer;
            }
        }catch(\Exception $ex){

        }
        
        try{

            $products = Products::select('products.id','products.name','products.description','products.image',
             'products.category_id','products.status','categories.name as category')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->where("products.status",1);
            
        
            if($category_id == 10){
               
                if($customerData != null){
                    $favsProducts = FavoriteProduct::select("product_id as id")->where('customer_id',$customerData->id)->get();
                    if(!empty($favsProducts)){
                        $products = $products->whereIN('products.id',$favsProducts);
                    }
                }
                 
            }else{
                if($category_id > 0 && $category_id !== 10){
                    $products = $products->where('products.category_id',$category_id);
                }
            }
            
            if($keyword !== null){
                $products = $products->where(function ($q) use ($keyword) {
                    $q ->orWhere('products.name','LIKE','%'.$keyword.'%')
                    ->orWhere('categories.name','LIKE','%'.$keyword.'%');
                });
            }

            $products = $products->orderBy('products.name','asc')->paginate(15);

             if (!empty($products)){

                foreach($products as $product){

                    $productsUnit = ProductUnit::select("product_units.unit_id","product_units.price","units.name","product_key","product_units.isShow")
                    ->leftjoin("units","product_units.unit_id","=","units.id")                    
                    ->where("product_units.product_id",$product->id)
                    ->orderBy("product_units.isShow","desc")->get();

                  if(!empty($productsUnit)){

                    if(isset( $productsUnit[0]->price)){
                        if($productsUnit[0]->isShow == 1){
                            $product->price = $productsUnit[0]->price;
                            $product->unitNameSelected = $productsUnit[0]->name;
                        }else{
                             $product->price = 0; 
                            $product->unitNameSelected = "";
                        }
                      
                    }else{
                        $product->price = 0; 
                         $product->unitNameSelected = "";
                    }
                            
                }else{
                    $product->price = 0; 
                    $product->unitNameSelected = "";
                }

                    $product->units = $productsUnit;
                }

                $categories = Categories::select("categories.id","categories.name","users.image")
                ->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
                ->leftjoin("users","categories_providers.providers_id","=","users.id")
                ->where("categories.is_enable",1)
                ->get();

                foreach ($categories as $item) {

                    if($item->id == 10){
                        $item->image = "/image_categories/corazon.png";
                    }
                }

                $categories->prepend(["id" => 0,"name" => "Todos","image" => "/image_categories/all-icon-01.png"]);

                return response()->json(array('error' => false ,'products' => $products, 
                 'categories' => $categories,                 
                 'categorySelected' => $category_id,
                 'messages' => 'Listado de productos'), 200);

             } else {
                 return response()->json(array('error' => false, 'message' => 'resultados no encontrados'), 200);
             }

         }catch (\Exception $ex) {
             return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
         } 
     }

    /**
     * @return array
     */
    public function getProductsRan(){

        $products = Products::all()->where("outstanding",1)->random(3);
        $typechange = Variables::where('id',3)->first();
        $productsData = array();
        foreach ($products as $product) {

            $data = array(
                "id" => $product->id,
                "name" => $product->name,
                "sku" => $product->sku,
                "description" => $product->short_description,
                "price" => number_format($product->price * $typechange->value,2,'.',''),
                "category_id" => $product->categories_id,
                "image" => $product->main_photo
            );

            array_push($productsData,$data);
        }
        sort($productsData);
        return $productsData;

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

     public function getDetails($id)
     {
         try {

             $products = Products::select('id', 'name', 'short_description','long_description','sku','price','categories_id','main_photo')->where('id', $id)->first();
             $typechange = Variables::where('id',3)->first();
             if (!empty($products)) {

                 $images = ProductsImages::where('products_id', $products->id)->get();

                 $imagesArray = array(
                     $this->getAdminPath() .$products->main_photo,
                 );
                 foreach ($images as $item) {

                     array_push($imagesArray, $this->getAdminPath() . $item->path_file);
                 }

                 $data = array(
                     "id" => $products->id,
                     "name" => $products->name,
                     "sku" => $products->sku,
                     "description" => $products->long_description,
                     "short_desc" => $products->short_description,
                     "price" => number_format($products->price * $typechange->value,2,'.',''),
                     "category_id" => $products->categories_id,
                     "image" => $products->main_photo,
                     "images" => $imagesArray
                 );

                 return response()->json(array('error' => false, 'product' => $data, 'message' => 'Detalle producto'), 200);
             } else {
                 return response()->json(array('error' => false, 'message' => 'resultado no encontrado'), 200);
             }
         } catch (\Exception $ex) {
             return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
         }

     }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

     public function profile($id)
     {
         try {

             if (! $customer = JWTAuth::parseToken()->authenticate()) {
                 return response()->json(array('error'=>true,'message' => 'Usuario no encontrado.'), 404);
             }else {

                 $users = Customers::select('id', 'commercial_name', 'contact_name', 'address', 'email',
                     'rfc', 'phone', 'cellphone')->where('id', $id)->first();

                 $orders = Orders::select('id', 'order_status', 'num_items', DB::raw(' DATE_FORMAT(orders.delivery_date, "%d/%m/%Y") as delivery_date'))
                 ->where('customer_id',$customer->id)
                 ->limit(15)->orderBy('id','DESC')->get();

                foreach ($orders as $order) {
                    $order->details = $this->getDetailsOrder($order->id);
                }

                if (!empty($users)) {
                    return response()->json(array('error' => false, 'user' => $users, 'orders' => $orders,
                        'message' => 'Información del usuario'), 200);
                } else {
                    return response()->json(array('error' => false, 'message' => 'resultados no encontrados',
                        'code' => 200), 200);
                }
             }


        } catch(\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage(), 'code' => 500), 500);
        }
     }


     public function getDetailsOrder($order_id){
        $orderDetails = Order_details::where("orders_id",$order_id)->get();

        $details = [];
        foreach($orderDetails as $detail){
             /*
                 id:pd.id,
                 name:pd.name,
                 image:pd.image,
                 sku:pd.key,
                 unit:pd.unit,
                 unit_id:pd.unit_id,
                 unit_price: pd.unit_price, //precio unitario
                 productSelectedPrice:pd.productSelectedPrice //total
             
             */

             $product = array(
                 "id" => $detail->product->id,
                 "name" => $detail->product->name,
                 "image" => $detail->product->image,
                 "key" => $this->getProductKey($detail->product_id,$detail->unit_id),
                 "unit" => isset($detail->product->getUnit->name) ? $detail->product->getUnit->name : $this->getUnitName($detail->unit_id),
                 "unit_id" => $detail->unit_id === null ? 0 : $detail->unit_id,
                 "unit_price" => $detail->unit_price === null ? 0 : $detail->unit_price,
                 "productSelectedPrice" => $detail->total === null ? 0 : $detail->total,
             );
             
             $data = [
                 "qty" => $detail->qty,
                 "product" => $product
             ];

            array_push($details,$data);
         }

         return $details;

     }


     public function getProductKey($product_id,$unit_id){
        $productKey = ProductUnit::where([["product_id",$product_id],["unit_id",$unit_id]])->first();
        $key = "";
        if(!empty($productKey)){
            $key = $productKey->product_key;
        }else{
            $product = Products::where("id",$product_id)->first();
            if(!empty($product)){
                $key = $product->product_key;
            }
        }

        return $key;
     }

     public function getUnitName($unit_id){
        $unit = Units::where("id",$unit_id)->first();
        $unitName = "";
        if(!empty($unit)){
            $unitName = $unit->name;
        }
        return $unitName;
     }

    /**
     * @param $method_payment_id
     * @return string
     */

     public function getMethodPaymentName($method_payment_id){
         $name = '';
         switch ($method_payment_id){
             case 1:
                 $name = 'Tarjeta';
                 break;
             case 2:
                 $name = 'Efectivo';
                 break;
             case 3:
                 $name = 'Transferencia';
                 break;
         }

         return $name;
     }

    /**
     * @param $order_status
     * @return string
     */
     public function getStatus($order_status){
         $status ='';

         switch ($order_status){
             case 1:
                 $status = 'Pagado';
                 break;
             case 2:
                 $status = 'Pendiente';
                 break;

         }

         return $status;
     }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
     public function orderDetail($id){

         try {
             if (! $customer = JWTAuth::parseToken()->authenticate()) {
                 return response()->json(array('error'=>true,'message' => 'Usuario no encontrado.'), 404);
             }else {

                 $order = Orders::select('id', 'order_status', 'subtotal', 'iva', 'total', 'num_items',
                     'discount', 'method_payment_id', 'guide_number', 'shipping_address_id', 'billing_address_id')->where('id', $id)->first();

                 if (!empty($order)) {

                     $shipping_address = Shipping_address::select('contact_name', 'street', 'num_ext', 'num_int',
                         'shipping_address.zipcode', 'phone', 'cellphone', 'suburbs.name as suburb', 'cities.name as city', 'customers_id')
                         ->leftjoin('suburbs','shipping_address.suburbs_id', '=', 'suburbs.id')
                         ->leftjoin('cities', 'shipping_address.cities_id', '=', 'cities.id')
                         ->where('shipping_address.id',$order->shipping_address_id)->first();

                     $billing_address = Billing_address::select('commercial_name', 'bussiness_name', 'email',
                         'billing_address.zipcode','street', 'num_ext', 'num_int', 'phone', 'suburbs.name as suburb', 'cities.name as city',
                         'rfc', 'customers_id')
                         ->leftjoin('suburbs','billing_address.suburbs_id', '=', 'suburbs.id')
                         ->leftjoin('cities', 'billing_address.cities_id', '=', 'cities.id')
                         ->where('billing_address.id',$order->billing_address_id)->first();

                     $data = array(
                         "id" => $order->id,
                         "order_status" => $this->getStatus($order->order_status),
                         "subtotal" => $order->subtotal,
                         "iva" => $order->iva,
                         "total" => $order->total,
                         "num_items" => $order->num_items,
                         "discount" => $order->discount,
                         "method_payment" => $this->getMethodPaymentName($order->method_payment_id),
                         "guide" => $order->guide_number,
                         "shipping_address" => $shipping_address,
                         "billing_address" => $billing_address,

                     );
                     return response()->json(array('error' => false, 'order' => $data, 'message' => 'Detalle de orden'), 200);
                 } else {
                     return response()->json(array('error' => false, 'message' => 'resultados no encontrados', 'code' => 200), 200);
                 }
             }


         } catch (\Exception $ex) {
             return response()->json(array('error' => true, 'message' => $ex->getMessage(), 'code' => 500), 500);
         }
     }

    /**
     * Obtiene un listado de status
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates($state_id = null){
        try {

            $states = States::select('id','name');
            if($state_id != null){
                $states = $states->where('id',$state_id);
            }

            $states = $states->get();
            return response()->json(array("error" => false, "code" => 200, "states" => $states), 200);
        }catch (\Exception $ex){
            return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
        }
    }

    /**
     * Obtiene un listado de ciudades por states_id
     * @param null $state_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities($city_id = null){
        try {
            if($city_id == null){
                return response()->json(array('error' => true,'message' => "Los parametros son obligatorios.","code" => 400),400);
            }else{

                $cities = Cities::select('id','name','states_id')->where('id',$city_id)->get();
                return response()->json(array("error" => false, "code" => 200, "cities" => $cities), 200);
            }

        }catch (\Exception $ex){
            return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
        }
    }

    /**
     * Obtiene un listado de colonias por city_id
     * @param null $city_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuburbs($city_id=null,$zipcode=null){
        try {

            $states = Suburbs::select('suburbs.id', 'suburbs.name', 'suburbs.zipcode','suburbs.cities_id','cities.name as city')
            ->leftjoin('cities', 'suburbs.cities_id','=','cities.id');

            if($city_id != "null"){
                $states = $states->where('cities_id', $city_id);
            }

            if($zipcode != null){
                $states = $states->where('zipcode',$zipcode);
            }

            $states = $states->get();

            return response()->json(array("error" => false, "code" => 200, "suburbs" => $states), 200);

        }catch (\Exception $ex){
            return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
        }
    }


    /**
     * Registra la orden.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerOrder(Request $request){


        try{
            if (! $customer = JWTAuth::parseToken()->authenticate()) {
                return response()->json(array('error'=>true,'message' => 'Usuario no encontrado.'), 404);
            }else {
                
                $order = $request['order'];
                $req = json_decode($order,true);
                DB::beginTransaction();
                Log::channel('RequestDaily')->info(['order' => $request->all()]);

                $order_status = 0;
                $deliveryDate = date('Y-m-d h:i A', strtotime($req['extraData']['delivery_data']));

                
                $message = "Orden creada correctamente."; 
                $statusDelivery = false;
                if(strtotime(date('Y-m-d')) === date('Y-m-d ', strtotime($req['extraData']['delivery_data']))){
                    if(strtotime($deliveryDate) >= strtotime(date('Y-m-d').' 12:30 AM')){
                        $message = "Su pedido será entregado el día de mañana.";
                        $statusDelivery = true;
                    }
                }
               
                $deliveryDate = explode('T',$req['extraData']['delivery_data']);

                $date = $deliveryDate[0];
                if($statusDelivery){
                    $stop_date = new \DateTime($date);
                    $stop_date->modify('+1 day');
                    $date = $stop_date->format('Y-m-d H:i:s');
                }


                $order = Orders::create([
                    'order_status' => $order_status,
                    'num_items' => $req['order']['num_items'],
                    'customer_id' => $customer->id,
                    'comments' => $req['extraData']['comments'],
                    'delivery_date' => $date,
                    //'subtotal' => $req['order']['subtotal'],
                    //'shipping_cost' => $req['order']['shipping_cost'],
                    //'total' => $req['order']['total'],
                    'status_payment' => 0//$req['order']['status_payment']
                ]);
                
                $documentId = $this->setDocument($order);

                for ($i = 0; $i < sizeof($req['products']); $i++) {

                    $details = Order_details::create([
                        'qty' => $req['products'][$i]['count'],
                        'orders_id' => $order->id,
                        'unit_id' => $req['products'][$i]['sku'] === "varios" ?  $this->getUnitId($req['products'][$i]['unit']) : $req['products'][$i]['unit_id'] ,
                       // 'unit_price' => isset($req['products'][$i]['unit_price']) ? $req['products'][$i]['unit_price'] : 0 ,
                        'total' => isset($req['products'][$i]['productSelectedPrice']) ? $req['products'][$i]['productSelectedPrice'] : 0,
                        'product_id' =>  $req['products'][$i]['sku'] === "varios" ?  $this-> saveVariousData($req['products'][$i]) :  $req['products'][$i]['id']
                    ]);
                    $this->setMovement($details);
                }
                $this->setNotifaction($order->id);
                DB::commit();

                $this->sendOrderEmail($customer, $order->id);
                return response()->json(array("error" => false, "code" => 200, "message" => $message,"statusDelivery" => false), 200);
                
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token a expirado'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token inválido'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token ausente'), 500);

        }catch (\Exception $ex){
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
        }
    }

    public function setDocument($order){

        $customer = Customers::find($order->customer_id);

        $mysql_raya_contpaqi_connection = DB::connection('mysql-raya-contpaqi');

        $outputs = $mysql_raya_contpaqi_connection->table('documentos')->insertGetId([
            'cIdDocumento' => $order->id,
            'cCodigoConcepto' => 2,
            'cSerieDocumento' => 'RAY',
            'cFolio' => $order->id,
            'cFecha' => date("Y-m-d"),
            'cCodigoCteProv' => isset($customer->contpaqi) ? $customer->contpaqi : null,
            'cCodigoAgente' => null,
            'cReferencia' => 1,
            'cTextoExtra1' => 1,
        ]);

        $mysql_raya_contpaqi_connection->disconnect('mysql-raya-contpaqi');

        return $outputs;
    }


    public function setMovement($details){

        $mysql_raya_contpaqi_connection = DB::connection('mysql-raya-contpaqi');

        // $productCode = ProductUnit::where([["unit_id", $details->unit_id],["product_id" => $details->product_id]])->first();

        $productKey = Products::select('product_units.product_key')
        ->leftjoin("product_units","products.id","=","product_units.product_id")
        ->where([['product_units.product_id', $details->product_id],['product_units.unit_id',$details->unit_id]])->first();  


        $outputs = $mysql_raya_contpaqi_connection->table('movimientos')->insertGetId([
            'cIdDocumento' => $details->orders_id,
            'cCodigoProducto' => $productKey->product_key,
            // 'cCodigoProducto' => !empty($productCode) ? $productCode->product_key : $details->product_id,
            'cCodigoAlmacen' => null,
            'cUnidadesCapturadas' => $details->qty,
            'cPrecioCapturado' => $details->unit_price,
            'cPorcentajeImpuesto1' => 1,
            'cTextoExtra1' => null,
            'cReferencia' => null,
            'cScMovto' => null,
        ]);

        $mysql_raya_contpaqi_connection->disconnect('mysql-raya-contpaqi');
    }

    public function setNotifaction($order_id){

       $order_details =  Order_details::select("users.id")
       ->leftjoin("products","order_details.product_id","=","products.id")
       ->leftjoin("categories","products.category_id","=","categories.id")
       ->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
       ->leftjoin("users","categories_providers.providers_id","=","users.id")
       ->where("order_details.orders_id",$order_id)->distinct()->get();

        if(!empty($order_details)){
           foreach($order_details as $detail){
                if(isset($detail->id)){
                    Notification::create([
                        "order_id" => $order_id,
                        "provider_id" => $detail->id
                    ]);
                }
            } 
        }
        
    }

    public function getUnitId($unitName){
        $unit = Units::where("name",$unitName)->first();
        return $unit->id;
        
    }

       /**
     * Registra la orden.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveFavoriteProducts(Request $request){


        try{
            if (! $customer = JWTAuth::parseToken()->authenticate()) {
                return response()->json(array('error'=>true,'message' => 'Usuario no encontrado.'), 404);
            }else {

                DB::beginTransaction();
                
                $favProduct = FavoriteProduct::where([["customer_id",$customer->id],["product_id",$request["product_id"]]])->first();
                $message = "";
                if(!empty($favProduct)){
                    $favProduct->delete();
                    $message = "Se elimino producto de favoritos";
                }else{

                    FavoriteProduct::create([
                        "customer_id" => $customer->id,
                        "product_id" => $request["product_id"]
                    ]);

                
                    $message = "Se guardo producto en favoritos.";
                }



                $products = Products::select('products.id','products.name','products.description','products.image','products.category_id',
                'products.status','categories.name as category')

                ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftjoin('product_units','products.id','=','product_units.product_id')
                ->leftjoin('units', 'product_units.unit_id', '=', 'units.id')
                ->leftjoin("favorite_products","products.id","=","favorite_products.product_id")
                ->where([["status",1],["favorite_products.customer_id",$customer->id]])->distinct()->get();

                foreach($products as $product){

                $productsUnit = ProductUnit::select("product_units.unit_id","product_units.price","units.name","product_key","product_units.isShow")
                ->leftjoin("units","product_units.unit_id","=","units.id")                    
                ->where("product_units.product_id",$product->id)
                ->orderBy("product_units.isShow","desc")                
                ->get();


                if(!empty($productsUnit)){

                    if(isset( $productsUnit[0]->price)){
                        if($productsUnit[0]->isShow == 1){
                            $product->price = $productsUnit[0]->price;
                            $product->unitNameSelected = $productsUnit[0]->name;
                        }else{
                             $product->price = 0; 
                            $product->unitNameSelected = "";
                        }
                      
                    }else{
                        $product->price = 0; 
                         $product->unitNameSelected = "";
                    }
                            
                }else{
                    $product->price = 0; 
                    $product->unitNameSelected = "";
                }

                $product->units = $productsUnit;
            }

                DB::commit();
                return response()->json(array("error" => false, "code" => 200, "message" => $message, "favProduct" => $products), 200);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token a expirado'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token inválido'), 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => 'Token ausente'), 500);

        }catch (\Exception $ex){
            DB::rollback();
            Log::channel('RequestDaily')->info(['error' => $ex->getMessage(),'Request' => $request->all()]);
            return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
        }
    }


    public function saveVariousData($product){


        $unit = Units::where("name",$product['unit'])->first();

        $products = new Products();
        $products->name = $product['name'];
        $products->image = '/images/product-varios.png';
        $products->description  =  "varios";
        $products->key  =  "varios";
        $products->category_id  =  8;
        $products->unit_id  =  $unit->id;
        $products->status  =  2;
        $products->outstanding  =  0;
//        $products->product_key = $request->input('product_key');
        $products->product_key = "key";
        $products->save();

        return $products ->id;
    }

    public function sendOrderEmail($customer,$order_id){

        $path = $this->getAdminPath();

        $products = Order_details::select('products.name','order_details.qty','units.name as units_name','order_details.total')
            ->leftjoin('products','order_details.product_id','=','products.id')
            ->leftjoin('units','order_details.unit_id','=','units.id')
            ->where('order_details.orders_id',$order_id)->get();

        $order = Orders::where("id",$order_id)->first();

        Mail::send('emails.order',compact('customer','path','products','order'),function ($msj) use ($customer){
            $msj->subject('Tu pedido en plataforma de pedidos Raya - Distribuidor de frutas y verduras');
            $msj->from('contacto@rayafrutasyverduras.com.mx','Raya - Distribuidor de frutas y verduras')->cc('administrador@rayafrutasyverduras.com.mx');            
            $msj->to($customer->email);
        });
    }




    public function strideFunction($dataBilling,$amount,$customer){
        try{

            if($this->status_production){
                $apikey = 'sk_live_8CN6j1innhbnFDpgFeswTH4U00U7uorhOp';
            }else{
                $apikey = 'sk_test_v3VUFBqce3pRBhpcADZuFbmq00MeZe63i0';
            }


            \Stripe\Stripe::setApiKey($apikey);
            $client = new    \GuzzleHttp\Client();
            $request = $client->post('https://api.stripe.com/v1/tokens',[
                'headers'        => ['Authorization' => 'Bearer '.$apikey,'Content-Type' => 'application/x-www-form-urlencoded'],
                'form_params' => [
                    'card[number]' => $dataBilling['tdc'],
                    'card[exp_month]' => $dataBilling['month'],
                    'card[exp_year]' => $dataBilling['year'],
                    'card[cvc]' => $dataBilling['cvv'],
                ]
            ]);

            $res = json_decode($request->getBody()->getContents(),true);

            if(isset( $res['error'])){
                Log::channel('RequestDaily')->info(['ErrorStride' => $res]);
                return array('error' => true,'message' => $res['message']);
            }else{

                $token = $res['id']; // This is a $20.00 charge in US Dollar.
                $charge = \Stripe\Charge::create(
                    array(
                        'amount' => ($amount * 100),
                        'currency' => 'mxn',
                        'source' => $token,
                        'description' => "Cargo rayaLiftSoft para ".$customer->email
                    )
                );

                $data = array(
                    'order' => $charge['id'],
                    'last4' => $charge['payment_method_details']['card']['last4'],
                    'receipt_url' => $charge['receipt_url'],

                );

                return $data;
            }



        }catch (\Exception $ex){
            Log::channel('RequestDaily')->info(['ErrorStrideException' => $ex->getMessage()]);
            return array('error' => true,'message' => $ex->getMessage());
        }
    }

    public function searchCoupon($code = null){

        try {

            if ($code == null) {
                return response()->json(array('error' => true, 'message' => 'Es nesesario un código para realizar la operación.'), 401);

            } else {

            $Coupons = Coupon::select('id', 'name', 'code', DB::raw('DATE(star_validity) as star_validity'), DB::raw('DATE(end_validity) as end_validity'), 'discount','min_purchase')->where("status", 1)->where("code", $code)->first();
            if (!empty($Coupons)) {

                $star_validity = strtotime($Coupons->star_validity);
                $end_validity = strtotime($Coupons->end_validity);
                $now = strtotime(date('Y-m-d'));

                if ($now >= $star_validity && $now <= $end_validity) {

                    $data = [
                        'code' => $Coupons->code,
                        'id' => $Coupons->id,
                        'name' => $Coupons->name,
                        'star_validity' => $Coupons->star_validity,
                        'end_validity' => $Coupons->end_validity,
                        'discount' => $Coupons->discount,
                        'min_purchase' => $Coupons->min_purchase,
                    ];

                    return response()->json(array('error' => false, 'coupon' => $data, 'message' => 'Cupón encontrado', 'code' => 200), 200);
                }else{


                    return response()->json(array('error' => true, 'message' => 'Cupón expirado', 'code' => 404), 404);
                }}

             else {
                return response()->json(array('error' => true, 'message' => 'Cupón no encontrado', 'code' => 404), 404);
            }

            }



        } catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage(), 'code' => 500), 500);
        }
    }

    public function searchProducts($word){
        try{

            $categories = Categories::select('id', 'name')->get();
            $products = Products::select('id','name','sku','short_description','price','categories_id','main_photo','long_description')
            ->leftjoin("categories","products.categories_id","=","categories.id")
            ->where('name', 'LIKE', "%".$word."%")
            ->orWhere('description', 'LIKE', "%$word%")
            ->orWhere('categories.name', 'LIKE', "%$word%")
            ->get();

            $typechange = Variables::where('id',3)->first();

            if (!empty($products)){

                $productsArray =array();
                foreach ($products as $product){
                    $data = array(
                        "id" => $product->id,
                        "name" => $product->name,
                        "sku" => $product->sku,
                        "short_description" => $product->short_description,
                        "long_description" => $product->long_description,
                        "price" => number_format($product->price * $typechange->value,2,'.',''),
                        "category_id" => $product->categories_id,
                        "image" => $product->main_photo
                    );
                    array_push($productsArray,$data);
                }
                return response()->json(array('error' => false,'categories' => $categories ,'products' => $productsArray,'message' => 'Listado de productos'), 200);
            } else {
                return response()->json(array('error' => false, 'message' => 'resultados no encontrados'), 200);
            }

        }catch (\Exception $ex) {
            return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
        }
    }

    public function sendContact(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'subject' => 'required',
                'comments' => 'required',
            ]);

            if ($validator->fails()) {
//                return response()->json($validator->errors()->toJson(), 400);
                return response()->json(array('error' => true,'message' => $validator->messages()->first() . '.'),401);
            }else{

                $name = $request['name'];
                $phone = $request['phone'];
                $subject = $request['subject'];
                $comments = $request['comments'];
//                $path = $this->path_url;

                Mail::send('contact.contact',compact('name','phone','subject','comments'),function ($msj) use($name){
                    $msj->subject('Te han enviado un comentario');
                    $msj->from('contacto@raya.com','Contacto Raya');
                    $msj->to('contacto@rayafrutasyverduras.com.mx');
                });

                return response()->json(array('error' => false, 'message' => 'Correo electrónico enviado correctamente.'),401);

            }

       }catch (\Exception $ex){
           return response()->json(array('error' => true,'message' => $ex->getMessage()),500);
       }

    }

    public function getSellerData(Request $request){
        try{

            //$id = decrypt($request["tok"]);
            $id = $this->base64_url_decode($request["tok"]);
            $seller = Sellers::where("id",$id)->first();
            $comment = Comments::first();

            $name = isset($seller->name) ? $seller->name : '';
            $phone = isset($seller->phone) ? $seller->phone : '';
            $comment = isset($comment->comment) ? $comment->comment : '';
            $user_id = isset($seller->id) ? $seller->id : null;


            return response()->json(array('error' => false, 'message' => $comment, 'name' => $name, 'phone' => $phone,'user_id' => $user_id), 200);
        }catch (\Exception $ex) {
             return response()->json(array('error' => true, 'message' => $ex->getMessage()), 500);
         }
    }

    public function base64_url_decode($input) {
        return base64_decode(strtr($input, '._-', '+/='));
    }
}
