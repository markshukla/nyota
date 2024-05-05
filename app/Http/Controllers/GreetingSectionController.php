<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\GreetingSection;

class GreetingSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['sections'] = GreetingSection::orderBy('orders', 'ASC')->get();
        // echo(json_encode($data['sections']));
        // die();
        return view('greeting.section.index',$data);
    }
    
    
    public function greeting_section_order(Request $request){
        $positions = $request->get("position");
        $ids = $request->get("parameter");
        
        $ids = json_decode($ids,true);
        $positions = json_decode($positions,true);
        
        foreach ($ids as $key => $id){
            $sec = GreetingSection::find($id);
            $sec->orders = $key+1;
            $sec->save();
        }
        
    }
    
    public function greeting_section_status(Request $request)
    {
        // echo("okk");
        $posts = GreetingSection::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('greeting.section.create');
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
        $id = GreetingSection::create([
            "name" => $request->get("title"),
        ]);
         return redirect()->route('greetingsection.index');
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
        
        $data['section'] = GreetingSection::find($id);
        return view('greeting.section.edit',$data);
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
        $posts = GreetingSection::find($id);
        $posts->name = $request->get("title");
        $posts->save();
        return redirect()->route('greetingsection.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GreetingSection::find($id)->delete();
        return redirect()->route('greetingsection.index');
    }
}
