<?php

namespace App\Http\Controllers;

 
use App\Categories;
use App\Products;
use Illuminate\Http\Request;
use App\Order_details;
use App\Orders;
use App\Sellers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class SellerReportController extends Controller
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
        $sellers = Sellers::all();
        return view('reports.sellerReport',compact('order_details','orders','categories','sellers'));

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


    public function filtroSellerCategorias(Request $request)
    {

        $categories_id = $request['categories_id'];
        $seller_id = $request['seller_id'];
        // $start = Carbon::parse($request['start'])->format('Y-m-d');
        // $end = Carbon::parse($request['end'])->format('Y-m-d');
        $orders = Order_details::select( 
        DB::raw('sum(order_details.qty) as qty'),
        // DB::raw('sum(products.price * qty) as newPrice'),
        'order_details.total as newPrice',
            'products.name as product_name','products.price as products_price',
            'categories.name as category_name','units.name as units'
            ,'sellers.name as name_seller'
        ) 
        ->leftjoin('orders','order_details.orders_id','=','orders.id')
        ->leftjoin('products','order_details.product_id','=','products.id')
        ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftjoin('units', 'order_details.unit_id', '=', 'units.id')
        ->leftjoin('customers','orders.customer_id','=','customers.id')
        ->leftjoin('sellers','customers.seller_id','=','sellers.id')
        ;
        if(isset($request->start))
            $orders->where('orders.delivery_date', '>=', date('Y-m-d H:i:s', strtotime($request->start . ' 00:00:00')));
        if(isset($request->end))
            $orders->where('orders.delivery_date', '<=', date('Y-m-d H:i:s', strtotime($request->end . ' 23:59:59')));
        if($categories_id > 0){
            $orders = $orders->where('products.category_id', '=', $categories_id);
        }
                if($seller_id > 0){
            $orders = $orders->where('customers.seller_id', '=', $seller_id);
        }
        $orders = $orders

            ->groupBy('order_details.total','products.name','categories.name','units.name','products.price','sellers.name','order_details.qty')->get();
                  $total = 0;
        foreach ($orders as $order){
            $order->newPrice = number_format($order->newPrice,2,'.','');
            $total += $order->newPrice;
        }
        return response()->json(['reports'=>$orders,'total'=>number_format($total,2,'.',',')]);

    }
}
