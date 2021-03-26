<?php

namespace App\Http\Controllers;

use App\Routes_customers;
use App\Routes;
use App\Customers;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\RouteRequest;
use Illuminate\Support\Facades\DB;
class RouteController extends Controller
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
        $routes = Routes::all( );


        return view('routes.index',compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $route_customer = Routes_customers::select('customer_id')->get();
        $customers = Customers::select('id', 'contact_name','last_name')->whereNotIn('id', $route_customer)->get();

        return view('routes.create',compact('customers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RouteRequest $request)
    {
//        echo "<pre>";
//        var_dump($request->all());
//        echo "</pre>";

        $routes = new Routes();
        $routes->name = $request->input('name');
        $routes->save();

        for ($a = 0; $a < sizeof($request['customers']); $a++) {

            Routes_customers::create([
                'route_id' => $routes->id,
                'customer_id' => $request['customers'][$a],
            ]);
        }

//
//
//
        Session::flash('success','Ruta guardada correctamente');
        return redirect('/routes');
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
        $route_customer = Routes_customers::select('customer_id')->get();
        $routes = Routes::find($id);
        $customers = Customers::select('id', 'contact_name','last_name')
            ->get();


        return view('routes.edit', compact('routes','customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RouteRequest $request, $id)
    {
        try{


            $routes = Routes::find($id);

            $routes->name = $request['name'];
            $routes->update();

            Routes_customers::where('route_id',$id)->delete();

            for ($a = 0; $a < sizeof($request['customers']); $a++) {

                Routes_customers::create([
                    'route_id' => $routes->id,
                    'customer_id' => $request['customers'][$a],
                ]);

            }


//
//
            Session::flash('success','Ruta guardada correctamente');
            return redirect('/routes');



        }catch (\Exception $exception){


            Session::flash('error',$exception->getMessage());
            return response()->json(["error" => true,'message' => $exception->getMessage()],500);
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


        $routes = Routes::find($id);

        $routes->delete();

        Routes_customers::where('route_id',$id)->delete();


        Session::flash('success','Ruta eliminada');
    }
}
