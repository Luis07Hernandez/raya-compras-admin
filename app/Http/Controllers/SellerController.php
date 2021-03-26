<?php

namespace App\Http\Controllers;

use Session;
use App\Routes;
use App\Sellers;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SellerRequest;

class SellerController extends Controller
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
        $sellers = Sellers::all( );
        $comments = Comments::all();

        return view('sellers.index',compact('sellers','comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
     

        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $request)
    {
        $seller = Sellers::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'sku' => $request['sku'],
        ]);    
        $seller_id=$seller->id;

        $sellers = Sellers::find($seller_id);

        $encrypId = $this->base64_url_encode($seller_id);
        $sellers->url = env('PORTAL_PATH').'/vendedor/'.$encrypId;
 
        $sellers->update();

        \Session::flash('success','Vendedor creado correctamente');
        return redirect('/sellers');
    }

    public function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '._-');
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
         $sellers = Sellers::find($id);
        return view('sellers.edit', compact('sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerRequest $request, $id)
    {
        
        $seller = Sellers::find($id);

        $seller->name = $request['name'];
        $seller->phone = $request['phone'];
        $seller->sku = $request['sku'];
       

        if($seller->url == null){
            $encrypId = $this->base64_url_encode($seller->id);
            $seller->url =  env('PORTAL_PATH').'/vendedor/'.$encrypId;
        }

        $seller->update();

        Session::flash('success','Vendedor actualizado');
        return redirect('/sellers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $seller = Sellers::find($id);

        $seller->delete();

        // Routes_customers::where('route_id',$id)->delete();


        Session::flash('success','Vendedor eliminado');
    }
}
