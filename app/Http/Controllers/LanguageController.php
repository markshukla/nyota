<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['languages'] = Language::orderBy('id', 'DESC')->paginate(12);
        return view('language.index',$data);
    }
    
    public function language_status(Request $request)
    {
        // echo("okk");
        $festivals = Language::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('language.create');
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
             'image' => 'required|mimes:jpg,png,jpeg',
             'name' => 'required',
             'code' => 'required',
        ]);
        
        $posts = new Language();
        $posts->language_name = $request->get("name");
        $posts->language_code = $request->get("code");
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/posts', $fileName);
            
            $item_url = 'uploads/posts/'.$fileName;
            $thumbnail_url = 'uploads/posts/'.$thumbName;
            
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
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('language.index');
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
        
        $data['language'] = Language::find($id);
        return view('language.edit',$data);
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
             'image' => 'nullable|mimes:jpg,png,jpeg',
             'name' => 'required',
             'code' => 'required',
        ]);
        
        $posts = Language::find($id);
        $posts->language_name = $request->get("name");
        $posts->language_code = $request->get("code");
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/posts', $fileName);
            
            $item_url = 'uploads/posts/'.$fileName;
            $thumbnail_url = 'uploads/posts/'.$thumbName;
            
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
            @unlink($posts->image);
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('language.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Language::find($id);
        @unlink($posts->image);

        Language::find($id)->delete();
        return redirect()->route('language.index');
    }
}
