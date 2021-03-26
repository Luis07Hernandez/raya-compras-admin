<?php

namespace App\Http\Controllers;

use App\User;
use App\Providers;
use App\Categories;
use App\CategoriesProviders;
use Illuminate\Http\Request;
use App\Http\Requests\ProvidersRequest;
use Illuminate\Support\Facades\Session;

class ProviderController extends Controller
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
        $providers = User::where("status",0)->get();
        return view('providers.index',compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvidersRequest $request)
    {
        $providers = User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'image' => User::fileAttribute($request->file('image'),null),
        ]);

        Session::flash('success', 'El proveedor ha sido creado correctamente');
        return redirect('/providers');
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
        $providers = User::find($id);
        return view('providers.edit', compact('providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvidersRequest $request, $id)
    {
        $providers = User::find($id);

        $providers->name = $request['name'];
        $providers->phone = $request['phone'];
        $providers->email = $request['email'];

        if ($request->hasfile('image')) {
            $providers->image = User::fileAttribute($request->file('image'),$id);
        }

        if($request['password'] != null){
            $providers->password = bcrypt($request['password']);
        }

        $providers->update();

        Session::flash('success', 'El proveedor ha sido editado correctamente');
        return redirect('/providers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $providers =  User::find($id);
        CategoriesProviders::where("providers_id",$id)->delete();
        $providers->delete();

        Session::flash('success','proveedor eliminado');
    }
}
