<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use Illuminate\Http\Request;
use App\Order_details;
use App\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
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
        $order_details = Order_details::all( );
        $orders =  Orders::all();
        $categories = Categories::all();
        $products = Products::all();
        return view('reports.index',compact('order_details','orders','categories'));

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


    public function filtroCategorias(Request $request)
    {

        $categories_id = $request['categories_id'];
        // $start = Carbon::parse($request['start'])->format('Y-m-d');
        // $end = Carbon::parse($request['end'])->format('Y-m-d');

        $orders = Order_details::select( DB::raw('sum(order_details.qty) as qty') ,
            'products.name as product_name',
            'categories.name as category_name','units.name as units'

        )
        ->leftjoin('orders','order_details.orders_id','=','orders.id')
        ->leftjoin('products','order_details.product_id','=','products.id')
        ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftjoin('units', 'order_details.unit_id', '=', 'units.id');

        if(isset($request->start))
            $orders->where('orders.delivery_date', '>=', date('Y-m-d H:i:s', strtotime($request->start . ' 00:00:00')));

        if(isset($request->end))
            $orders->where('orders.delivery_date', '<=', date('Y-m-d H:i:s', strtotime($request->end . ' 23:59:59')));

        if($categories_id > 0){
            $orders = $orders->where('products.category_id', '=', $categories_id);
        }

        $orders = $orders

            ->groupBy('products.name','categories.name','units.name')->get();

        return response()->json(['reports'=>$orders]);

    }
}
