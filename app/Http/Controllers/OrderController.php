<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Order_details;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Orders;
use App\Categories;
use Illuminate\Support\Facades\DB;
use Spipu\Html2Pdf\Html2Pdf;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;
class OrderController extends Controller
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
        $customers = Customers::all();
        return view('orders.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //'order_details.status',
        $order_details =  Order_details::select('order_details.id','order_details.product_id', 'order_details.total','order_details.unit_price',
            'order_details.orders_id','order_details.qty','products.id as product_id', 'products.name as product_name',
            'products.image as product_image',
             'categories.id as category_id','categories.name as category_name'
            ,'units.name as units_name'
            )
        ->leftjoin('products', 'order_details.product_id','=','products.id')
        ->leftjoin('categories', 'products.category_id','=','categories.id')
        ->leftjoin('units', 'order_details.unit_id','=','units.id');
        $user = Auth::user();
        if($user->status === 0){ //proveedor
            $order_details = $order_details->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
            ->where("categories_providers.providers_id",$user->id); 
        }

        $order_details = $order_details->where('order_details.orders_id',$id)->get();

        $order = Orders::find($id);
        return view('orders.show',compact('order_details','order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filtro(Request $request)
    {

        $customer_id = $request['customer_id'];

        $orders = Orders::select('orders.id as order_id','orders.num_items','orders.customer_id','orders.created_at','orders.order_status',
            DB::raw(' DATE_FORMAT(orders.delivery_date, "%d/%m/%Y") as delivery_date'),'customers.contact_name','customers.last_name','customers.commercial_name as name')
            ->leftjoin('customers', 'orders.customer_id', '=', 'customers.id');

        $user = Auth::user();
        if($user->status == 0){ //proveedor
            $orders = $orders->leftjoin("order_details","orders.id","=","order_details.orders_id")
            ->leftjoin("products","order_details.product_id","=","products.id")
            ->leftjoin("categories","products.category_id","=","categories.id")
            ->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
            ->where("categories_providers.providers_id", $user->id); 
        }

        if($request["start"] != null){
            $orders->where('orders.delivery_date', '>=', date('Y-m-d H:i:s', strtotime($request["start"] . ' 00:00:00')));
        }
            
        if($request["end"] != null){
            $orders->where('orders.delivery_date', '<=', date('Y-m-d H:i:s', strtotime($request["end"] . ' 23:59:59')));
        }
       
        if($customer_id > 0){
            $orders = $orders->where('orders.customer_id', '=', $customer_id);
        }

        $orders = $orders->distinct()->get();

        return response()->json(['reports'=>$orders]);
    }



    public function tikett($id,$category_id = null){


        $order_details =  Order_details::select(
            'products.name as product_name',
            DB::raw('CONCAT_WS(" ",order_details.qty, units.name) as qty_unit'),
            'order_details.orders_id as id_order',
            'order_details.qty as order_detail_qty',
            'order_details.total as total',
            'categories.name as text',
            'units.name as unit_name',
            
            'customers.commercial_name',
            'customers.address as name_address',
            'customers.cellphone as contact_cellphone',
            'orders.delivery_date',
            'orders.comments',
            'orders.subtotal',
            'orders.total as order_total',
            'orders.shipping_cost',
            'orders.status_payment as payment',
            'routes.name as route_name'
            )

            ->leftjoin('orders', 'order_details.orders_id','=','orders.id')
            ->leftjoin('customers', 'orders.customer_id','=','customers.id')
            ->leftjoin('routes_customers', 'customers.id','=','routes_customers.customer_id')
            ->leftjoin('routes', 'routes_customers.route_id','=','routes.id')
            ->leftjoin('products', 'order_details.product_id','=','products.id')
            ->leftjoin('categories', 'products.category_id','=','categories.id')
            ->leftjoin('units', 'order_details.unit_id','=','units.id');
            

            $user = Auth::user();
            if($user->status == 0){ //proveedor
                 $order_details = $order_details->leftjoin("categories_providers","categories.id","=","categories_providers.categories_id")
                ->where("categories_providers.providers_id",$user->id); 
            }

            $order_details = $order_details->where('order_details.orders_id',$id);

        $order_details = $order_details->groupBy('route_name','commercial_name','contact_cellphone','name_address','payment','text','product_name',
              'order_detail_qty','unit_name','qty_unit','id_order','delivery_date','comments','total',
              'order_total','subtotal','shipping_cost'
              )
            ->orderBy('text','asc');

        if($category_id !== null){
            $order_details=$order_details->where('categories.id',$category_id);
        }

        $order_details=$order_details->distinct()->get();
        foreach ($order_details as $order_detail){
            $order_detail -> delivery_date = Carbon::parse( $order_detail -> delivery_date)->format('d/m/Y');
        }

        $pdf_obj = PDF::loadView('orders.tiket', compact('order_details'))
            ->setPaper(array(0,0,222,1200))
            ->setOptions(['isRemoteEnabled' => true]) ;

        return $pdf_obj->stream('rayaliftsoft.pdf');
    }

    public function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function updateOrder(Request $request){

        $order = Orders::where("id",$request["order_id"])->first();
        $order->order_status = $request["order_status"];
        $order->update();

        return response()->json(["error" => false],200);
    }



}
