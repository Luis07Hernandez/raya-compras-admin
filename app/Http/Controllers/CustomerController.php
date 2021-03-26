<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
use App\Shipping_address;
use App\Cities;
use App\Suburbs;
use App\Sellers;
use Session;
use App\Http\Requests\CustomerRequest;
use Mail;
use DB;

class CustomerController extends Controller
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
//        $customers = Shipping_address::select('street','customers_id','customers.name as customer_name',
//            'customers.last_name','customers.email','customers.id','customers.customer_status', 'customers.phone' )
//            ->leftjoin('customers', 'shipping_address.customers_id','=','customers.id')
//            ->where('is_main',1 )
//            ->get();

        $customers = Customers::select('customers.contpaqi as id','customers.commercial_name','customers.contact_name','customers.last_name','customers.email','customers.rfc','customers.phone','customers.customer_status'
        ,'sellers.id as id_seller','sellers.name as name_seller'        )
        ->leftjoin('sellers', 'customers.seller_id','=','sellers.id')->get();
     

        return view('customer.index',compact('customers'));


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
        $customersdetails = Customers::select( 'customers.contact_name as customer_name','customers.last_name','customers.email','customers.id','customers.customer_status', 'customers.phone as customer_phone'
            ,'customers.cellphone as customer_cellphone','customers.adress_id','customers.rfc','customers.commercial_name','customers.address as direction'
            ,'shipping_address.street','shipping_address.customers_id', 'shipping_address.contact_name','shipping_address.num_ext',
            'shipping_address.num_int', 'shipping_address.zipcode','shipping_address.phone','shipping_address.cellphone','shipping_address.suburbs_id',
            'shipping_address.cities_id','shipping_address.created_at','shipping_address.updated_at','shipping_address.is_main'
            ,'cities.name as cities_name','suburbs.name as suburbs_name'

        )
        ->leftjoin('shipping_address', 'customers.adress_id','=','shipping_address.id')
            ->leftjoin('cities', 'shipping_address.cities_id','=','cities.id')
            ->leftjoin('suburbs', 'shipping_address.suburbs_id','=','suburbs.id')
            ->where('customers.id',$id)
//            ->where('shipping_address.is_main',1)
            ->get();

        return view('customer.view',compact('customersdetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customers::find($id);
            $sellers = Sellers::select('id', 'name')->get();

        return view('customer.edit', compact('customers','sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = Customers::find($id);

        $customer->contact_name = $request['contact_name'];
        $customer->last_name = $request['last_name'];
        $customer->email = $request['email'];
        $customer->commercial_name = $request['commercial_name'];
        $customer->rfc = $request['rfc'];
        $customer->seller_id = $request['seller_id'];
        $customer->contpaqi = $request['contpaqi'];

        if($request['password'] != '') {
            $customer->password = bcrypt($request['password']);
        }
        $customer->phone = $request['phone'];
        $customer->update();

        Session::flash('success','Usuario actualizado');
        return redirect('/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

 public function destroy($id)
    {
             $banner =   Customers::find($id);
    
        $banner->delete();

        \Session::flash('success','Cliente eliminado');
    }


    public function changestatus4(Request $request)
    {

        $id = $request['id'];
        $status = $request ['status'] == 'true' ? 1:0;

        $customer = Customers::find($id);

        $customer->customer_status = $status;
        $customer-> update();

        $mysql_raya_contpaqi_connection = DB::connection('mysql-raya-contpaqi');

        $client = $mysql_raya_contpaqi_connection->table('clientes')->where('CRFC', $customer->rfc)->first();
        if(empty($client)){
            $outputs = $mysql_raya_contpaqi_connection->table('clientes')->insertGetId([
                'CCODIGOCLIENTE' => $customer->contpaqi,//'GCO160113NS3',
                'CRAZONSOCIAL' => $customer->commercial_name,
                'CRFC' =>  $customer->rfc,
                'CTIPOCLIENTE' => 2,
                'CESTATUS' => 1,
                'CBANVENTACREDITO' => 1,
            ]);
        }else{
            $outputs = $mysql_raya_contpaqi_connection->table('clientes')->where("CRFC",$customer->rfc)->update([
                'CCODIGOCLIENTE' => $customer->contpaqi,//'GCO160113NS3',
                'CRAZONSOCIAL' => $customer->commercial_name,
                'CRFC' =>  $customer->rfc,
                'CTIPOCLIENTE' => 2,
                'CESTATUS' => 1,
                'CBANVENTACREDITO' => 1,
            ]);
        }

   

        $mysql_raya_contpaqi_connection->disconnect('mysql-raya-contpaqi');


        Mail::send('customer.StatusActivoInactivo',compact( 'status' ,'customer'), function ($message) use ($customer) {
            $message->from('contacto@rayafrutasyverduras.com.mx', 'Raya - Distribuidor de frutas y verduras');

            if ( $customer->customer_status == 1){
            $message->subject('Cuenta activada en plataforma de pedidos Raya - Distribuidor de frutas y verduras');}
            else{
                $message->subject('Cuenta desactivada en plataforma de pedidos Raya - Distribuidor de frutas y verduras');}
            $message->to($customer->email);

        });


        Session::flash('success','Estatus cambiado correctamente');



    }


}
