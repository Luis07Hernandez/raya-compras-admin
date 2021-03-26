<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;

use App\Http\Requests\BannerRequest;

use Session;
class BannerController extends Controller
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
    public function index(Request $request)
    {


        $banners = Banner::all();



        return view('banners.index',compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        $banner = new Banner();

        $banner->image = Banner::fileAttribute($request->file('image'));
        $banner->banner_status  =  true;
        $banner->title = $request->input('title');
//            $collection->images = $request->input('image');
        $banner->description = $request->input('description');
        $banner->save();


        \Session::flash('success','Banner guardado correctamente');
        return redirect('/banners');
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
        $banners = Banner::find($id);


        return view('banners.edit', compact('banners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {

        $banner = Banner::find($id);

        $banner->fill($request->except('image'));
//        if ($request->hasfile('image')){
//            $file = $request->file('image');
//            $name = time().$file->getClientOriginalName();
//            $banner->image = 'image_banners/' .$name;
//            $file->move(public_path().'/image_banners/', $name);
//        }

        if ($request->hasfile('image')) {
            $banner->image = Banner::fileAttribute($request->file('image'),$id);
        }
        $banner->title = $request['title'];
        $banner->description = $request['description'];
        $banner->update();

        Session::flash('success','Banner actualizado');
        return redirect('/banners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner =   Banner::find($id);
        if($banner->image != null){
            $file_path = public_path().$banner->image;
            if(file_exists($file_path)){
                \File::delete($file_path);
            }
        }



        $banner->delete();

        Session::flash('success','banner eliminado');
    }

    public function changestatus(Request $request)
    {

        $id = $request['id'];
        $status = $request ['status'] == 'true' ? 1:0;
        $banner = Banner::find($id);

        $banner->banner_status = $status;

        $banner-> update();
        Session::flash('success','Estatus cambiado correctamente');
    }

}
