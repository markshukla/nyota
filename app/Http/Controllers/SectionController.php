<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['sections'] = Section::orderBy('orders', 'ASC')->paginate(150);
        return view('section.index',$data);
    }
    
    public function section_status(Request $request)
    {
        $festivals = Section::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    
    public function section_order(Request $request){
        $positions = $request->get("position");
        $ids = $request->get("parameter");
        
        $ids = json_decode($ids,true);
        $positions = json_decode($positions,true);
        
        foreach ($ids as $key => $id){
            $sec = Section::find($id);
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
        
        return view('section.create');
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
        $sec =new Section();
        $sec->name = $request->get("title");
        $sec->save();
        return redirect()->route('section.index');
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
        
        $data['section'] = Section::find($id);
        return view('section.edit',$data);
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
        $posts = Section::find($id);
        $posts->name = $request->get("title");
        $posts->save();
        return redirect()->route('section.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Section::find($id);
        @unlink($posts->image);

        Section::find($id)->delete();
        return redirect()->route('section.index');
    }
}
