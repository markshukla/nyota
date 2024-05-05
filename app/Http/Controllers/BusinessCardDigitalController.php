<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCardDigital;
use Illuminate\Support\Str;
use ZipArchive;

class BusinessCardDigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cards'] = BusinessCardDigital::paginate(12);
        return view('businesscard.digital.index',$data);
    }
    
     public function card_status(Request $request)
    {
        $posts = BusinessCardDigital::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function card_premium_action(Request $request)
    {
        $festivals = BusinessCardDigital::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("businesscard.digital.create");
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
             'blade_name' => 'required',
             'image' => 'required',
             'premium' => 'required',
        ]);
        
        $tamplate = new BusinessCardDigital();
        $tamplate->title = $request->get("title");
        $tamplate->premium = $request->get("premium");
        $tamplate->blade_name = $request->get("blade_name");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/thumbnail', $fileName);
            $item_url = 'uploads/thumbnail/'.$fileName;
            $thumbnail_url = 'uploads/thumbnail/'.$thumbName;
                
            switch($extension){ 
                case 'jpeg':
                    $image = imagecreatefromjpeg($item_url); 
                    break; 
                case 'png': 
                    $image = imagecreatefrompng($item_url); 
                    break; 
                case 'gif': 
                    $image = imagecreatefromgif($item_url); 
                    break; 
                default: 
                    $image = imagecreatefromjpeg($item_url); 
            }
            
            imagejpeg($image, $thumbnail_url, 50);
            
            @unlink($item_url);
            
            $tamplate->thumb_url = $thumbnail_url;
        }
        
        $tamplate->save();
        return redirect()->route('businesscarddigital.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
