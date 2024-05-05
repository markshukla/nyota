<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['sliders'] = Slider::orderBy('id', 'DESC')->paginate(12);
        return view('slider.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['subscriptions'] = Subscription::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->get();
        return view("slider.create", $data);
    }
    
    public function slider_status(Request $request)
    {
        // echo("okk");
        $festivals = Slider::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
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
             'title' => 'required',
             'type' => 'required',
        ]);
        
        $posts = new Slider();
        $posts->title = $request->get("title");
        $posts->action = $request->get("type");
        $posts->slider = $request->get("slider");
        
        if($request->get("type") == 'category'){
            $posts->action_item = $request->get("category");
        }
        if($request->get("type") == 'url'){
            $posts->action_item = $request->get("url");
        }
        if($request->get("type") == 'subscription'){
            $posts->action_item = $request->get("subscription");
        }
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            
            $image = $request->file("image");
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/thumbnail/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/thumbnail/'.$fileName;
            }else{
                
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
            }
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('slider.index');
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
        
        $data['subscriptions'] = Subscription::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->get();
        $data['slider'] = Slider::find($id);
        return view("slider.edit", $data);
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
             'title' => 'required',
             'type' => 'required',
        ]);
        
        $posts = Slider::find($id);
        $posts->title = $request->get("title");
        $posts->action = $request->get("type");
        $posts->slider = $request->get("slider");
        
        if($request->get("type") == 'category'){
            $posts->action_item = $request->get("category");
        }
        if($request->get("type") == 'url'){
            $posts->action_item = $request->get("url");
        }
        if($request->get("type") == 'subscription'){
            $posts->action_item = $request->get("subscription");
        }
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            
            $image = $request->file("image");
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/thumbnail/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/thumbnail/'.$fileName;
            }else{
                
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
                @unlink($posts->image);
            }
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Slider::find($id);
        @unlink($posts->image);
        Slider::find($id)->delete();
        return redirect()->route('slider.index');
    }
}
