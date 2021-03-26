<?php

namespace App\Http\Controllers;
use App\Products;
use Illuminate\Http\Request;
use App\Categories;
use App\Units;
use App\ProductUnit;
use App\Orders;
use App\Order_details;
use App\Customers;
use Session;
use App\Http\Requests\ProductsRequest;
use Redirect;
use DB;
use Mail;
class productSpController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::select('products.id','products.name','products.description','products.price','products.image','products.key','products.category_id',
            'products.unit_id','products.status','products.outstanding as product_dest','products.product_key','categories.name as product_name','units.name as units_name')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('units', 'products.unit_id', '=', 'units.id')->where('products.status', '!=' , 2 )->get();

        return view('Products.indexSp',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
 

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Products::find($id);
        $categories = Categories::select('id', 'name')->get();
        $units = Units::select('id', 'name')->get();

        $productUnits = ProductUnit::where("product_id",$id)->get();

        return view('Products.editSp',compact('categories','units','product','productUnits'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        try{

            $units = [];
            if(!isset($request["units"])){
                Session::flash("error","Debes agregar los datos de al menos una unidad de medida");
                return Redirect::back()->withInput($request->all());    
            }else{

               for($i = 0; $i < sizeof($request["units"]); $i++){
                    if($request["units"][$i]["price"] !== null && $request["units"][$i]["product_key"] !== null){
                        $data = array(
                            "unit_id" => $request["units"][$i]["unit_id"],
                            "price" => $request["units"][$i]["price"],
                            "product_key" => $request["units"][$i]["product_key"],
                            "isShow" => $request["units"][$i]["isShow"]
                        );
                        array_push($units,$data);
                    }
               } 
            }

            if(sizeof($units) == 0 ){
                Session::flash("error","Debes agregar los datos de al menos una unidad de medida");
                return Redirect::back()->withInput($request->all());   
            }else{

                $products = Products::find($id);
                $products->fill($request->except('image'));

                if ($request->hasfile('image')) {
                    $products->image = Products::fileAttribute($request->file('image'),$id);
                }
                $products->name = $request['name'];
                $products->description = $request['description'];
               
                $products->price = $request['price'];
                $products->key = $request['key'];
                $products->category_id = $request['category_id'];
                //$products->unit_id = $request['unit_id'];
                $products->product_key = $request['product_key'];
                $products->update();

                $unitsUpdated = $this->validatePriceUnitProduct($units,$products->id);
               
                ProductUnit::where("product_id",$products->id)->delete();
                
                for($i = 0; $i < sizeof($units); $i++){
                    
                    ProductUnit::create([
                        "product_id" => $products->id,
                        "unit_id" => $units[$i]["unit_id"],
                        "price" => $units[$i]["price"],
                        "product_key" => $units[$i]["product_key"],
                        "isShow" => $units[$i]["isShow"]
                    ]);                    
                }

               // var_dump($unitsUpdated);
                echo "<br/>";
                $unitToSendEmail = $this->SendEmailFromPriceUpdated($unitsUpdated,$products->id);
                // var_dump($unitToSendEmail);

                 Session::flash('success','Producto actualizado');
                 return redirect('/productSp');
            }

        }catch(\Exception $ex){
            DB::rollBack();
            Session::flash('error',$ex->getMessage());
            return Redirect::back()->withInput($request->all());
        }
    }



    public function validatePriceUnitProduct($units,$product_id){

        $unitsArray = array();
        for($i = 0; $i < sizeof($units); $i++){
            $unitsData = ProductUnit::where([["product_id",$product_id],["unit_id",$units[$i]["unit_id"]]])->first();
            if($units[$i]["price"]  > $unitsData->price || $units[$i]["price"]  < $unitsData->price ){
                $data = array(
                    "unit_id" => $units[$i]["unit_id"],
                    "price" => $units[$i]["price"],
                );
                array_push($unitsArray,$data);
            }
        }

        return $unitsArray;
    }


    public function SendEmailFromPriceUpdated($unitsData,$product_id){

        $orderDetailIDs = array();
        for($i = 0; $i < sizeof($unitsData); $i++){

            $order_detail_users = Order_details::select('order_details.id as id','order_details.qty') 
            ->leftjoin('orders', 'order_details.orders_id', '=','orders.id')
            ->leftjoin('customers', 'orders.customer_id', '=','customers.id')
            ->leftjoin('products', 'order_details.product_id', '=','products.id')
            ->where('order_details.product_id', $product_id)
            ->where('order_details.unit_id', $unitsData[$i]["unit_id"])
            ->where('orders.order_status',0)
            ->get();

            foreach($order_detail_users as $item){
                $item->unit_price = $unitsData[$i]["price"];
                $item->total = $item->qty * $unitsData[$i]["price"];
                $item->update();

                array_push($orderDetailIDs, $item->id);
            }
        }

        for($a = 0; $a < sizeof($orderDetailIDs); $a++){
            $order_users = Order_details::select('id','orders_id')->where("id",$orderDetailIDs[$a])->get();

            

                $newTotal = $this->getNewTotal($order_users[0]->orders_id);
                $order = Orders::where('id',$order_users[0]->orders_id)->first();
                $order->subtotal = $newTotal;
                $order->total = $newTotal + $order->shipping_cost;
                $order->update();
            

        }
        


        //Enviar datos en correo electronico.
        $order_detail_users = Order_details::select('order_details.orders_id as id_orders1',
        'order_details.total as product_total',
        'customers.email','customers.contact_name','products.name as name_product',
       'orders.id as orders_id', 'orders.subtotal','orders.shipping_cost','orders.total',
       'orders.order_status as orders_status') 
        ->leftjoin('orders', 'order_details.orders_id', '=','orders.id')
        ->leftjoin('customers', 'orders.customer_id', '=','customers.id')
        ->leftjoin('products', 'order_details.product_id', '=','products.id')
        ->whereIn('order_details.id', $orderDetailIDs)
        ->get();

       // return $order_detail_users;

        foreach ($order_detail_users as $item) {
             
            $order_products = Order_details::select('order_details.orders_id',  
            'products.name','order_details.qty','units.name as unit_name','order_details.total'
            )
            ->leftjoin('products','order_details.product_id','=','products.id')
            ->leftjoin('units','order_details.unit_id','=','units.id')
            ->leftjoin('orders','order_details.orders_id','=','orders.id')
            ->leftjoin('customers','orders.customer_id','=','customers.id')
            ->where('order_details.orders_id',$item->id_orders1)->get();
            // return $order_products;
            Mail::send('Products.UpdatePriceCorreo',compact('order_products','item'), 
            function ($message) use ($item) {
                $message->from('contacto@rayafrutasyverduras.com.mx', 'Hechos la Raya Home Delivery');
                $message->subject('Hubo un cambio en el precio de el producto');
                $message->to($item->email);
            });
            
        }

        //return $orderDetailIDs;
    }

    public function getNewTotal($orderDetail){
        $total = 0;
        $order_users = Order_details::where("orders_id",$orderDetail)->get();
        foreach ($order_users as $key) {
            $total += $key->total;
        }

        return $total;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product =   Products::find($id);
        if($product->image != null){
            $file_path = public_path().$product->image;
            if(file_exists($file_path)){
                \File::delete($file_path);
            }
        }



        $product->delete();

        Session::flash('success','producto eliminado');

    }


    public function changestatus2(Request $request)
    {

        $id = $request['id'];
        $status = $request ['status'] == 'true' ? 1:0;
        $product = Products::find($id);
        $product->status = $status;
        $product-> update();

        $order_detail_users = Order_details::select('order_details.orders_id as id_orders1','order_details.total as product_total',
        'customers.email','customers.contact_name','products.name as name_product',
       'orders.id as orders_id', 'orders.subtotal','orders.shipping_cost','orders.total','orders.order_status as orders_status') 
        ->leftjoin('orders', 'order_details.orders_id', '=','orders.id')
        ->leftjoin('customers', 'orders.customer_id', '=','customers.id')
        ->leftjoin('products', 'order_details.product_id', '=','products.id')
        ->where('product_id', $id )
        ->get();

        foreach ($order_detail_users as $item) {
             
            $order_products = Order_details::select('order_details.orders_id',  
            'products.name','order_details.qty','units.name as unit_name','order_details.total'
            )
            ->leftjoin('products','order_details.product_id','=','products.id')
            ->leftjoin('units','order_details.unit_id','=','units.id')
            ->leftjoin('orders','order_details.orders_id','=','orders.id')
            ->leftjoin('customers','orders.customer_id','=','customers.id')
            ->where('order_details.orders_id',$item->id_orders1)->get();

            $dato_product_total = $item->product_total;
            $dato_order_total   = $item->total;
            $dato_order_subtotal   = $item->subtotal;

            if($item->orders_status === 0)
            { 
                $resulttotal = 0;
                $resultsubtotal = 0;
                if ( $status == 1){

                    $resulttotal =   $dato_order_total + $dato_product_total;
                    $resultsubtotal = $dato_order_subtotal + $dato_product_total;

                }else{
                    $resulttotal =   $dato_order_total - $dato_product_total;
                    $resultsubtotal = $dato_order_subtotal - $dato_product_total;  
                }

                $id =  $item->orders_id;
                $orders_result = Orders::find($id);
                $orders_result->total = $resulttotal;
                $orders_result->subtotal = $resultsubtotal;
                $orders_result-> update();  



                    Mail::send('Products.StatusActivoInactivoCorreo',compact( 'status','order_products','item','resulttotal','resultsubtotal'), 
                    function ($message) use ($status,$item) {
                        $message->from('contacto@rayafrutasyverduras.com.mx', 'Hechos la Raya Home Delivery');

                        if ( $status == 1){
                            $message->subject('El producto solicitado esta nuevamente disponible - Hechos la Raya Home Delivery');
                        
            
                        }else{
                            $message->subject('El producto solicitado esta agotado actualmente - Hechos la Raya Home Delivery');
                        }
        
                        $message->to($item->email);
                    });

                        

            }




        }
    


        

        Session::flash('success','Estatus cambiado correctamente');
    }



    public function changestatus3(Request $request)
    {

        $id = $request['id'];
        $status = $request ['status'] == 'true' ? 1:0;
        $product= Products::find($id);

        $product->outstanding = $status;

        $product-> update();


        Session::flash('success','destacado cambiado correctamente');
    }

}