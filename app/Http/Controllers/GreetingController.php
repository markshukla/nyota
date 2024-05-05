<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Greeting;
use App\Models\GreetingSection;
use App\Models\Language;
use Illuminate\Support\Str;
use Validator;
use Storage;
use File;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Greeting::where('orientation',null)->get();
        foreach ($posts as $post){
            $p = Greeting::find($post->id);
            if(File::exists($p->item_url)){
                $size = getimagesize($p->item_url);
            
                if($size[0] > $size[1])
                {
                    $orientation = "landscape";
                }
                if($size[0] < $size[1])
                {
                    $orientation = "portrait";
                }
                if($size[0] == $size[1])
                {
                    $orientation = "square";
                }
                
                $p->orientation = $orientation;
                $p->height = $size[1];
                $p->width = $size[0];
                $p->save();
                
            }else{
                $p->delete();
            }
        }
        
        $data['posts'] = Greeting::orderBy('id', 'DESC')->paginate(12);
        $data['sections'] = GreetingSection::where('status','0')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('greeting.index',$data);
    }
    
    public function greeting_status(Request $request)
    {
        // echo("okk");
        $posts = Greeting::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function greeting_premium_action(Request $request)
    {
        $festivals = Greeting::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    
    
    public function greeting_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Greeting::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Greeting::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Greeting::find($id);
                    @unlink($posts->item_url);
                    @unlink($posts->thumb_url);
                    Greeting::find($id)->delete();
                    
                }
            }
            
        }
        return redirect()->route("greeting.index");
    }
    
    public function filterby_section($id)
    {
        
        $data['posts'] = Greeting::where('section_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['sections'] = GreetingSection::where('status','0')->get();
        
        $category_name = GreetingSection::find($id);
        $data['section'] = $category_name->name;
         
        return view("greeting.index", $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['languages'] = Language::where('status','0')->get();
        $data['sections'] = GreetingSection::where('status','0')->get();
        
        return view('greeting.create',$data);
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
             'image_posts' => 'required',
             'title' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        if ($request->file("image_posts")) 
        {
            $removedfiles = json_decode($request->get("removed_files"), true);
            $images = $request->file('image_posts');
            
            foreach($images as $image) 
            {
                if($removedfiles != null)
                {
                    if (in_array($image->getClientOriginalName(), $removedfiles)) {
                        continue;
                    }
                }
                
                
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                if(Setting::getValue('storage_type') == "digitalOccean"){
                    $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                    $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
                    $item_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
                }else{
                    $image->move('uploads/posts', $fileName);
                    $item_url = 'uploads/posts/'.$fileName;
                    $thumbnail_url = 'uploads/thumbnail/'.$fileName;
                
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
                }
                
                $id = Greeting::create([
                    "title" => $request->get("title"),
                    "section_id" => $request->get("category"),
                    "item_url" => $item_url,
                    "premium" => $request->get("premium"),
                    "thumb_url" => $thumbnail_url,
                    "language" => $request->get("language"),
                ]);

            }
        }
        return redirect()->route('greeting.index');
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
        
        $data['post'] = Greeting::find($id);
        $data['languages'] = Language::where('status','0')->get();
        $data['sections'] = GreetingSection::where('status','0')->get();
        return view('greeting.edit',$data);
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
             'image_posts' => 'nullable|mimes:jpg,png,jpeg',
             'title' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        $posts = Greeting::find($id);
        $posts->title = $request->get("title");
        $posts->section_id = $request->get("category");
        $posts->language = $request->get("language");
        
        
        if ($request->file("image_posts") && $request->file('image_posts')->isValid()) {
            $image = $request->file("image_posts");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
                $item_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
            }else{
                $image->move('uploads/posts', $fileName);
                $item_url = 'uploads/posts/'.$fileName;
                $thumbnail_url = 'uploads/thumbnail/'.$fileName;
            
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
                @unlink($posts->item_url);
                @unlink($posts->thumb_url);
            }
            
            $posts->item_url = $item_url;
            $posts->thumb_url = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('greeting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Greeting::find($id);
        @unlink($posts->item_url);
        @unlink($posts->thumb_url);

        Greeting::find($id)->delete();
        return redirect()->route('greeting.index');
    }
}
