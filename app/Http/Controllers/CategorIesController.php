<?php

namespace App\Http\Controllers;

use App\User;
use App\Products;
use App\Categories;
use App\CategoriesProviders;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;

class CategorIesController extends Controller
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
        try{
            $categories = Categories::all();
            return view('categories.index',compact('categories'));
        }catch(\Exception $ex){
            Session::flash("error",$ex->getMessage());
            return redirect()->back();
        }
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = User::select('id','name')->where("status",0)->get();
        return view('categories.create', compact ('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $categories = new Categories();
        $categories->name = $request->input('name');
        if(!isset($request["is_enable"])){
            $categories->is_enable = 0;
        }
        $categories->save();

        CategoriesProviders::create([
            'categories_id' => $categories->id,
            'providers_id' => $request['providers_id']
        ]);


        \Session::flash('success','Categoria creada correctamente');
        return redirect('/categories');
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
        $categories = Categories::find($id);
        $providers = User::select('id','name')->where("status",0)->get();
        $providerSelected = CategoriesProviders::where("categories_id",$id)->first();

        return view('categories.edit', compact('categories','providers','providerSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, $id)
    {
     
        $categories = Categories::find($id);
        $categories->name = $request['name'];

        if(!isset($request["is_enable"])){
            $categories->is_enable = 0;
        }else{
            $categories->is_enable = 1;
        }

        $categories->update();

        $categoriesProviders = CategoriesProviders::where("categories_id",$id)->first();
        
        if(!empty($categoriesProviders)){
            $categoriesProviders->providers_id = $request['providers_id']; 
            $categoriesProviders->update(); 
        }else{
            CategoriesProviders::create([
                'categories_id' => $id,
                'providers_id' => $request['providers_id'],
            ]);
        }
        
        \Session::flash('success','Categoria actualizada');
        return redirect('/categories');
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories =   Categories::find($id);

        $products = Products::select('category_id')->where('products.category_id',$id)->first();
        $caegory_pdoruct = $products["category_id"];

        if( $id == $caegory_pdoruct ){
            \Session::flash('error','La categoria tiene productos registrados');        
        }else{
            $categories->delete();
            CategoriesProviders::where("categories_id",$id)->first();
           \Session::flash('success','Categoria eliminada');
        }
    }
}
