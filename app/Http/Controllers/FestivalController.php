<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Posts;
use App\Models\Category;
use App\Models\Language;
use App\Models\Section;
use Illuminate\Support\Str;
use Validator;
use Storage;
use ZipArchive;
use File;

class FestivalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::where('orientation',null)->get();
        foreach ($posts as $post){
            
            $p = Posts::find($post->id);
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
        
        $data['sections'] = Section::where('status','0')->get();
        $data['posts'] = Posts::with('section')->where('type','festival')->orderBy('id', 'DESC')->paginate(12);
        $data['categories'] = Category::where('status','0')->where('type','festival')->get();
       
        return view('festival.index',$data);
    }
    
    public function filterby_category($id)
    {
        
        $data['sections'] = Section::where('status','0')->get();
        $data['posts'] = Posts::with('section')->where('type','festival')->where('category_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['categories'] = Category::where('status','0')->where('type','festival')->get();
        
        $category_name = Category::find($id);
        $data['category'] = $category_name->name;
         
        return view("festival.index", $data);
    }

    public function posts_status(Request $request)
    {
        // echo("okk");
        $festivals = Posts::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    public function posts_remove_section(Request $request)
    {
        $festivals = Posts::find($request->get("id"));
        $festivals->section_id = 0;
        $festivals->save();
    }
    
    public function posts_premium_action(Request $request)
    {
        $festivals = Posts::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    public function posts_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Posts::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Posts::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Posts::find($id);
                    @unlink($posts->item_url);
                    @unlink($posts->thumb_url);
                    Posts::find($id)->delete();
                    
                }
            }
            
            if($request->action_type == "section")
            {
                foreach($ids as $id){
                    
                    $posts = Posts::find($id);
                    $posts->section_id = $request->section_id;
                    $posts->save();
                    
                }
            }
        }
        if($request->from_name == 'festival'){
            return redirect()->route("festival.index");
        }
        if($request->from_name == 'business'){
            return redirect()->route("business.index");
        }
        if($request->from_name == 'custom'){
            return redirect()->route("custom.index");
        }
        if($request->from_name == 'political'){
            return redirect()->route("political.index");
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    
    public function create()
    {
        
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->where('type','festival')->get();
        
        // echo(json_encode($data['posts']));
        // die();
        return view('festival.create',$data);
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
                
                $size = getimagesize($image);
            
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
                $post = new Posts();
                $post->title = $request->get("title");
                $post->category_id = $request->get("category");
                $post->type = "festival";
                $post->language = $request->get("language");
                $post->premium = $request->get("premium");
                $post->item_url = $item_url;
                $post->thumb_url = $thumbnail_url;
                
                $post->orientation = $orientation;
                $post->height = $size[1];
                $post->width = $size[0];
                
                $post->save();
            }
            
        }else{
            $folder_name = Str::upper(Str::random(16));
            $post = new Posts();
            $post->title = $request->get("title");
            $post->category_id = $request->get("category");
            $post->type = "festival";
            $post->language = $request->get("language");
            $post->premium = $request->get("premium");
            
            if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
                $storage_url = '/uploads/tamplate/posts/';
                $zip_obj = new ZipArchive();
                $zipdata = $_FILES['zip_file']['tmp_name'];
                
                if ($zip_obj->open($zipdata) === TRUE) {
                    $zip_obj->extractTo(public_path().$storage_url.$folder_name.'/');
                    $zip_obj->close();
                }
                
                $jsonname = '';
                $files = File::files(public_path().$storage_url.$folder_name.'/json/');
                foreach ($files as $file){
                    $jsonname = basename($file, ".json");
                    $text_info = File::get($file);
                }
                
                $foldername = Str::uuid();
                $json = json_decode($text_info,true);
                
                if(Setting::getValue('storage_type') == "digitalOccean"){
                    
                    $skinsFiles = File::files(public_path().$storage_url.$folder_name.'/skins/'.$jsonname.'/');
                    foreach($skinsFiles as $skinfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$folder_name.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                    }
                    
                    if(File::exists(public_path().$storage_url.$folder_name.'/fonts/')){
                        $fontsFiles = File::files(public_path().$storage_url.$folder_name.'/fonts/');
                        foreach($fontsFiles as $fontfile)
                        {
                            Storage::disk('spaces')->put($storage_url.$folder_name.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                        }
                    }
                    
                    File::deleteDirectory(public_path().$storage_url.$folder_name);
                    $storage_url = env("DO_SPACES_URL").$storage_url;
                }
                
                foreach ($json['layers'] as $key => $data){
                    
                    if($data['type'] == "image"){
                        
                        $json['layers'][$key]['src'] = $storage_url.$folder_name.substr($data['src'], 2);
                    }
                    
                    if($data['type'] == "text"){
                        $json['layers'][$key]['font'] = $storage_url.$folder_name.'/fonts/'.$data['font'].'.ttf';
                    }
                }
                
                $post->json = json_encode($json);
            }
            
            if ($request->file("thumbnail") && $request->file('thumbnail')->isValid()) {
                $image = $request->file("thumbnail");
                
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                $size = getimagesize($image);
            
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
                    
                }
                $post->orientation = $orientation;
                $post->height = $size[1];
                $post->width = $size[0];
                $post->item_url = $thumbnail_url;
                $post->thumb_url = $thumbnail_url;
            }
            
            
            $post->save();
        }
        return redirect()->route('festival.index');
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
        
        $data['post'] = Posts::find($id);
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->where('type','festival')->get();
        return view('festival.edit',$data);
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
             'category' => 'required',
             'language' => 'required',
        ]);
        
        $posts = Posts::find($id);
        $posts->title = $request->get("title");
        $posts->category_id = $request->get("category");
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
        
        if ($request->file("thumbnail") && $request->file('thumbnail')->isValid()) {
            $image = $request->file("thumbnail");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            $size = getimagesize($image);
            
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
                @unlink($item_url);
                @unlink($posts->thumb_url);
                @unlink($posts->thumb_url);
            }
            $posts->orientation = $orientation;
            $posts->height = $size[1];
            $posts->width = $size[0];
            $posts->item_url = $thumbnail_url;
            $posts->thumb_url = $thumbnail_url;
        }
        
        
        $folder_name = Str::upper(Str::random(16));
        
        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/tamplate/posts/';
            $zip_obj = new ZipArchive();
            $zipdata = $_FILES['zip_file']['tmp_name'];
            
            if ($zip_obj->open($zipdata) === TRUE) {
                $zip_obj->extractTo(public_path().$storage_url.$folder_name.'/');
                $zip_obj->close();
            }
            
            $jsonname = '';
            $files = File::files(public_path().$storage_url.$folder_name.'/json/');
            foreach ($files as $file){
                $jsonname = basename($file, ".json");
                $text_info = File::get($file);
            }
            
            $foldername = Str::uuid();
            $json = json_decode($text_info,true);
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                $skinsFiles = File::files(public_path().$storage_url.$folder_name.'/skins/'.$jsonname.'/');
                foreach($skinsFiles as $skinfile)
                {
                    Storage::disk('spaces')->put($storage_url.$folder_name.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                }
                
                if(File::exists(public_path().$storage_url.$folder_name.'/fonts/')){
                    $fontsFiles = File::files(public_path().$storage_url.$folder_name.'/fonts/');
                    foreach($fontsFiles as $fontfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$folder_name.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                    }
                }
                
                File::deleteDirectory(public_path().$storage_url.$folder_name);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$folder_name.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $json['layers'][$key]['font'] = $storage_url.$folder_name.'/fonts/'.$data['font'].'.ttf';
                }
            }
            
            $posts->json = json_encode($json);
        }
        
        $posts->save();
        return redirect()->route('festival.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Posts::find($id);
        @unlink($posts->item_url);
        @unlink($posts->thumb_url);

        Posts::find($id)->delete();
        return redirect()->route('festival.index');
    }
}
