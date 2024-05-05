<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MusicCategory;
use App\Models\Music;
use Illuminate\Support\Str;

class MusicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = MusicCategory::orderBy('orders', 'ASC')->paginate(150);
        return view('music.category.index',$data);
    }
    
    public function category_status(Request $request)
    {
        $festivals = MusicCategory::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    
    public function category_order(Request $request){
        $positions = $request->get("position");
        $ids = $request->get("parameter");
        
        $ids = json_decode($ids,true);
        $positions = json_decode($positions,true);
        
        foreach ($ids as $key => $id){
            $sec = MusicCategory::find($id);
            $sec->orders = $key+1;
            $sec->save();
        }
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('music.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
             'title' => 'required',
        ]);
        $sec =new MusicCategory();
        $sec->name = $request->get("title");
        $sec->save();
        return redirect()->route('musiccategory.index');
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
        $data['category'] = MusicCategory::find($id);
        return view('music.category.edit',$data);
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
        $validatedData = $request->validate([
             'title' => 'required',
        ]);
        $posts = MusicCategory::find($id);
        $posts->name = $request->get("title");
        $posts->save();
        return redirect()->route('musiccategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MusicCategory::find($id)->delete();
        return redirect()->route('musiccategory.index');
    }
}
