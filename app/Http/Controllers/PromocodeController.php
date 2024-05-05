<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocode;

class PromocodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['promocodes'] = Promocode::get();
        return view('promocode.index',$data);
    }
    
    public function promocode_status(Request $request)
    {
        // echo("okk");
        $posts = Promocode::find($request->get("id"));
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
        return view('promocode.create');
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
             'code' => 'required',
             'discount' => 'required',
             'total_use' => 'required',
        ]);
        // return  $request->get('discount');
        $code = new Promocode();
        $code->code = $request->get("code");
        $code->discount = $request->get("discount");
        $code->total_use = $request->get("total_use");
        $code->save();
        return redirect()->route('promocode.index');
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
        $data['promocode'] = Promocode::find($id);
        return view('promocode.edit',$data);
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
             'code' => 'required',
             'discount' => 'required',
             'total_use' => 'required',
        ]);
        // return  $request->get('discount');
        $code = Promocode::find($id);
        $code->code = $request->get("code");
        $code->discount = $request->get("discount");
        $code->total_use = $request->get("total_use");
        $code->save();
        return redirect()->route('promocode.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promocode::find($id)->delete();
        return redirect()->route('promocode.index');
    }
}
