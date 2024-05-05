<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Str;
use Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $data['categories'] = Category::orderBy('id', 'DESC')->paginate(12);
        $data['type'] = "";
        return view('category.index',$data);
    }
    
    public function festivalCategory()
    {
      
        $data['categories'] = Category::where('type','festival')->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = "festival";
        return view('category.index',$data);
    }
    
    public function businessCategory()
    {
      
        $data['categories'] = Category::where('type','business')->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = "business";
        return view('category.index',$data);
    }
    
    public function getCategoryByType(Request $request)
    {
        return Category::where('type',$request->get('type'))->where('status','0')->orderBy('id', 'DESC')->get();
    }
    
    public function customCategory()
    {
      
        $data['categories'] = Category::where('type','custom')->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = "custom";
        return view('category.index',$data);
    }
    
    public function politicalCategory()
    {
      
        $data['categories'] = Category::where('type','political')->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = "political";
        return view('category.index',$data);
    }
    
    public function searchCategory(Request $request)
    {
        $data['type'] = $request->get("type");
        if($request->get("search") != ""){
            $data['search'] = $request->get("search");
            $data['categories'] = Category::where('type',$request->get("type"))->where('name','like',"%".$request->get("search")."%")->get();
        }else{
            $data['categories'] = Category::where('type',$request->get("type"))->orderBy('id', 'DESC')->paginate(12);
        }
        
        return view('category.index',$data);
    }
    
    
    public function filterby_type($type)
    {
      
        $data['categories'] = Category::where('type',$type)->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = $type;
        return view("category.index", $data);
    }
    
    public function category_status(Request $request)
    {
        // echo("okk");
        $festivals = Category::find($request->get("id"));
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
      
        return view("category.create");
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
        
        $posts = new Category();
        $posts->name = $request->get("title");
        $posts->type = $request->get("type");
        
        if($request->get("type") == 'festival'){
            $posts->event_date = $request->get("event_date");
        }
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
                $posts->image = $thumbnail_url;
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
        if($request->get("type") == "festival"){
            return redirect('/festivalCategory');
        }
        if($request->get("type") == "business"){
            return redirect('/businessCategory');
        }
        if($request->get("type") == "political"){
            return redirect('/politicalCategory');
        }
        if($request->get("type") == "custom"){
            return redirect('/customCategory');
        }
        
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
      
        $data['category'] = Category::find($id);
        return view("category.edit", $data);
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
        
        $posts = Category::find($id);
        $posts->name = $request->get("title");
        $posts->type = $request->get("type");
        
        if($request->get("type") == 'festival'){
            $posts->event_date = $request->get("event_date");
        }else{
            $posts->event_date = null;
        }
        
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
                $posts->image = $thumbnail_url;
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
                  @unlink($posts->image);
                  $posts->image = $thumbnail_url;
                }
                
            }
        }
        
        $posts->save();
        if($request->get("type") == "festival"){
            return redirect('/festivalCategory');
        }
        if($request->get("type") == "business"){
            return redirect('/businessCategory');
        }
        if($request->get("type") == "political"){
            return redirect('/politicalCategory');
        }
        if($request->get("type") == "custom"){
            return redirect('/customCategory');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Category::find($id);
        @unlink($posts->image);

        Category::find($id)->delete();
        return redirect()->route('category.index');
    }
}
