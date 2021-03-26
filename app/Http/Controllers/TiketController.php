<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\Order_details;
use Illuminate\Support\Facades\DB;
class TiketController extends Controller
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

        $orders =  Orders::all();

        return view('tikets.index',compact('orders'));

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


    public function tiketfilter(Request $request)
    {


        $order_id = $request['order_id'];

        $order_details =  Order_details::select( 'categories.id as value','categories.name as text')

    ->leftjoin('products', 'order_details.product_id','=','products.id')
    ->leftjoin('categories', 'products.category_id','=','categories.id')
    ->where('order_details.orders_id',$order_id)
     ->groupBy('value','text')->get();

        $array[] = ['value', 'text'];

        return $order_details  ;

    }
    public function tabletiket(Request $request)
    {


        $categoria = $request['categoria'];

        $order_id = $request['order_id'];




        $order_details =  Order_details::select('products.name as product_name',
            DB::raw('CONCAT_WS(" ",order_details.qty, units.name) as qty_unit'),
            DB::raw('CONCAT_WS(" ","Pedido:",order_details.orders_id,"Ruta:",routes.name,"Cliente:",customers.name,customers.last_name,last_name2 ) as order_route'),

            'order_details.orders_id as orders_id','order_details.qty as order_detail_qty', 'categories.name as text','routes.name as route_name','units.name as unit_name','customers.name as customer_name')

            ->leftjoin('orders', 'order_details.orders_id','=','orders.id')
            ->leftjoin('routes_customers', 'orders.customer_id','=','routes_customers.customer_id')
            ->leftjoin('routes', 'routes_customers.route_id','=','routes.id')
            ->leftjoin('customers', 'routes_customers.customer_id','=','customers.id')
            ->leftjoin('products', 'order_details.product_id','=','products.id')
            ->leftjoin('categories', 'products.category_id','=','categories.id')
            ->leftjoin('units', 'products.unit_id','=','units.id')

            ->where('order_details.orders_id',$order_id);
if($categoria > 0){
    $order_details = $order_details->whereIn('categories.id', $categoria);
}
//            ->whereIn('categories.id', $categoria)
            $order_details = $order_details->groupBy('route_name','text','product_name','orders_id','order_detail_qty','unit_name','order_route','customer_name')->get();
        $foot = "";

        foreach ($order_details as $order_detail){
            $foot = $order_detail->order_route;
        }

        return response()->json(['order_details'=>$order_details, 'foot'=>$foot]);



    }




}
