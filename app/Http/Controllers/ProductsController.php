<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Redirect;
use App\Units;
use App\Orders;
use App\Products;
use App\Categories;
use App\ProductUnit;
use App\Order_details;
use App\CategoriesProviders;
use Illuminate\Http\Request;
use App\Http\Requests\ProductsRequest;

class ProductsController extends Controller
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
            ->leftjoin('units', 'products.unit_id', '=', 'units.id');
            
            $user = Auth::user();
            if($user->status === 0){ //proveedor
                $providerSelected = CategoriesProviders::select("categories_id")->where("providers_id",$user->id)->get();
                $products = $products->whereIn("products.category_id",$providerSelected);
            }

            $products = $products->where('products.status', '!=' , 2 )->get();

        return view('Products.index',compact('products'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $categories = Categories::select('id', 'name');
        $user = Auth::user();
        if($user->status === 0){ //proveedor
            $providerSelected = CategoriesProviders::select("categories_id")->where("providers_id",$user->id)->get();
            $categories = $categories->whereIn("id",$providerSelected);
        }

        $categories = $categories->get();
        $units = Units::select('id', 'name')->get();
        return view('Products.create',compact('categories','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {

        try{

            $units = [];
            if(!isset($request["units"])){
                Session::flash("error","Debes agregar los datos de al menos una unidad de medida");
                return Redirect::back()->withInput($request->all());    
            }else{

               for($i = 0; $i < sizeof($request["units"]); $i++){
                    if($request["units"][$i]["product_key"] !== null){
                        $data = array(
                            "unit_id" => $request["units"][$i]["unit_id"],
                           // "price" => $request["units"][$i]["price"],
                            "product_key" => $request["units"][$i]["product_key"],
                            "isShow" => $request["units"][$i]["isShow"],
                        );
                        array_push($units,$data);
                    }
               } 
            }

            if(sizeof($units) == 0 ){
                Session::flash("error","Debes agregar los datos de al menos una unidad de medida");
                return Redirect::back()->withInput($request->all());   
            }else{

                DB::beginTransaction();

                $products = new Products();
                $products->name = $request->input('name');
                $products->image = Products::fileAttribute($request->file('image'));
                $products->description  =  $request->input('description');
                // $products->price  =  $request->input('price');
                $products->key  =  $request->input('key');
                $products->category_id  =  $request->input('category_id');
                $products->status  =  true;
                $products->outstanding  =  false;
                $products->product_key = $request->input('product_key');
                $products->save();


                for($i = 0; $i < sizeof($units); $i++){
                    ProductUnit::create([
                        "product_id" => $products->id,
                        "unit_id" => $units[$i]["unit_id"],
                        // "price" => $units[$i]["price"],
                        "product_key" => $units[$i]["product_key"],
                        "isShow" => $units[$i]["isShow"],
                        
                    ]);
                }

                DB::commit();
                Session::flash('success','Producto guardado correctamente');
                return redirect('/products');
            }

        }catch(\Exception $ex){
            DB::rollBack();
            Session::flash('error',$ex->getMessage());
            return Redirect::back()->withInput($request->all());
        }

       
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

        $categories = Categories::select('id', 'name');
        $user = Auth::user();
        if($user->status === 0){ //proveedor
            $providerSelected = CategoriesProviders::select("categories_id")->where("providers_id",$user->id)->get();
            $categories = $categories->whereIn("id",$providerSelected);
        }

        $categories = $categories->get();

        $product = Products::find($id);
        $units = Units::select('id', 'name')->get();
        $productUnits = ProductUnit::where("product_id",$id)->get();

        return view('Products.edit',compact('categories','units','product','productUnits'));


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
                    if($request["units"][$i]["product_key"] !== null){
                        $data = array(
                            "unit_id" => $request["units"][$i]["unit_id"],
                           // "price" => $request["units"][$i]["price"],
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
                // $products->price = $request['price'];
                $products->key = $request['key'];
                $products->category_id = $request['category_id'];
                //$products->unit_id = $request['unit_id'];
                $products->product_key = $request['product_key'];
                $products->update();

                ProductUnit::where("product_id",$products->id)->delete();
                
                for($i = 0; $i < sizeof($units); $i++){
                    
                    ProductUnit::create([
                        "product_id" => $products->id,
                        "unit_id" => $units[$i]["unit_id"],
                        //"price" => $units[$i]["price"],
                        "product_key" => $units[$i]["product_key"],
                        "isShow" => $units[$i]["isShow"]
                    ]);                    
                }

                Session::flash('success','Producto actualizado');
                return redirect('/products');
            }

        }catch(\Exception $ex){
            DB::rollBack();
            Session::flash('error',$ex->getMessage());
            return Redirect::back()->withInput($request->all());
        }
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
                        $message->from('contacto@rayafrutasyverduras.com.mx', 'Raya - Distribuidor de frutas y verduras');

                        if ( $status == 1){
                            $message->subject('El producto solicitado esta nuevamente disponible - Distribuidor de frutas y verduras');
                        
            
                        }else{
                            $message->subject('El producto solicitado esta agotado actualmente - Distribuidor de frutas y verduras');
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
