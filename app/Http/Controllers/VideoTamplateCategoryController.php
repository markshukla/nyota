<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoTamplateCategory;
use App\Models\VideoTamplate;
use App\Models\Setting;
use Illuminate\Support\Str;

class VideoTamplateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = VideoTamplateCategory::orderBy('orders', 'ASC')->paginate(25);
        return view('videoTamplate.category.index',$data);
    }
    
    public function category_status(Request $request)
    {
        $festivals = VideoTamplateCategory::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    
    public function category_order(Request $request){
        $positions = $request->get("position");
        $ids = $request->get("parameter");
        
        $ids = json_decode($ids,true);
        $positions = json_decode($positions,true);
        
        foreach ($ids as $key => $id){
            $sec = VideoTamplateCategory::find($id);
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
        return view('videoTamplate.category.create');
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
        ]);
        
        $posts = new VideoTamplateCategory();
        $posts->name = $request->get("title");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
            }else{
                
                $thumbName = Str::uuid() . '.' .$extension;
            
                $image->move('uploads/posts', $fileName);
                $item_url = 'uploads/posts/'.$fileName;
              
                if($request->get("type") == "political"){
                  $posts->image = $item_url;
                }else{
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
                
            }
            
        }
        
        $posts->save();
        return redirect('/videotamplatecategory');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = VideoTamplateCategory::find($id);
        return view("videoTamplate.category.edit", $data);
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
        
        $posts = VideoTamplateCategory::find($id);
        $posts->name = $request->get("title");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
            }else{
                
                $thumbName = Str::uuid() . '.' .$extension;
            
                $image->move('uploads/posts', $fileName);
                $item_url = 'uploads/posts/'.$fileName;
              
                if($request->get("type") == "political"){
                  $posts->image = $item_url;
                }else{
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
                
            }
            
        }
        
        $posts->save();
        return redirect('/videotamplatecategory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = VideoTamplateCategory::find($id);
        @unlink($posts->image);
        $posts->delete();
        return redirect()->route('videotamplatecategory.index');
    }
}
