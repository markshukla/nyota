<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;
use App\Models\FrameCategory;
use Illuminate\Support\Str;
use ZipArchive;
use File;
use Storage;
use App\Models\Setting;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['categories'] = FrameCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['frames'] = Frame::orderBy('id', 'DESC')->paginate(12);
        
        return view('frame.index',$data);
    }
    
    public function filterby_category($id){
        
        $data['categories'] = FrameCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['frames'] = Frame::where('category_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['category'] = FrameCategory::find($id)->name;
        return view('frame.index',$data);
    }
    
    public function frame_status(Request $request)
    {
        // echo("okk");
        $posts = Frame::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function frame_premium_action(Request $request)
    {
        $festivals = Frame::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    public function frame_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Frame::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Frame::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Frame::find($id);
                    @unlink($posts->thumbnail);
                    Frame::find($id)->delete();
                    
                }
            }
            
        }
        return redirect()->route("frame.index");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['categories'] = FrameCategory::where('status','0')->orderBy('id', 'DESC')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('frame.create',$data);
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
             'image' => 'required',
             'title' => 'required',
             'category' => 'required',
             'premium' => 'required',
             'ratio' => 'required',
             'type' => 'required',
        ]);
        
        
        $sicker = new Frame();
        $sicker->title = $request->get("title");
        $sicker->type = $request->get("type");
        $sicker->premium = $request->get("premium");
        $sicker->category_id = $request->get("category");
        $sicker->ratio = $request->get("ratio");
        

        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/frame/';
            $zip_obj = new ZipArchive();
            $zipdata = $_FILES['zip_file']['tmp_name'];
            
            if ($zip_obj->open($zipdata) === TRUE) {
                $zip_obj->extractTo(public_path().$storage_url.$sicker->title.'/');
                $zip_obj->close();
            }
            
            $jsonname = '';
            $files = File::files(public_path().$storage_url.$sicker->title.'/json/');
            foreach ($files as $file){
                $jsonname = basename($file, ".json");
                $text_info = File::get($file);
            }
            
            $foldername = Str::uuid();
            $json = json_decode($text_info,true);
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                $skinsFiles = File::files(public_path().$storage_url.$sicker->title.'/skins/'.$jsonname.'/');
                foreach($skinsFiles as $skinfile)
                {
                    Storage::disk('spaces')->put($storage_url.$sicker->title.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                }
                
                if(File::exists(public_path().$storage_url.$sicker->title.'/fonts/')){
                    $fontsFiles = File::files(public_path().$storage_url.$sicker->title.'/fonts/');
                    foreach($fontsFiles as $fontfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$sicker->title.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                    }
                }
                
                File::deleteDirectory(public_path().$storage_url.$sicker->title);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$sicker->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $json['layers'][$key]['font'] = $storage_url.$sicker->title.'/fonts/'.$data['font'].'.ttf';
                }
            }
            
            $sicker->json = json_encode($json);
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
                
            }
            $sicker->thumbnail = $thumbnail_url;
        }
        $sicker->save();
        
        return redirect()->route('frame.index');
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
        
        $data['frame'] = Frame::find($id);
        $data['categories'] = FrameCategory::where('status','0')->orderBy('id', 'DESC')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('frame.edit',$data);
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
             'type' => 'required',
             'premium' => 'required',
             'ratio' => 'required',
        ]);
        
        $sicker = Frame::find($id);
        
        $sicker->type = $request->get("type");
        $sicker->premium = $request->get("premium");
        $sicker->ratio = $request->get("ratio");
        $sicker->category_id = $request->get("category");
        
        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/frame/';
            File::deleteDirectory(public_path().$storage_url.$sicker->title);
            $sicker->title = $request->get("title");
            
            $zip_obj = new ZipArchive();
            $zipdata = $_FILES['zip_file']['tmp_name'];
            
            if ($zip_obj->open($zipdata) === TRUE) {
                $zip_obj->extractTo(public_path().$storage_url.$sicker->title.'/');
                $zip_obj->close();
            }
            
            $jsonname = '';
            $files = File::files(public_path().$storage_url.$sicker->title.'/json/');
            foreach ($files as $file){
                $jsonname = basename($file, ".json");
                $text_info = File::get($file);
            }
            
            $foldername = Str::uuid();
            $json = json_decode($text_info,true);
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                $skinsFiles = File::files(public_path().$storage_url.$sicker->title.'/skins/'.$jsonname.'/');
                foreach($skinsFiles as $skinfile)
                {
                    Storage::disk('spaces')->put($storage_url.$sicker->title.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                }
                
                if(File::exists(public_path().$storage_url.$sicker->title.'/fonts/')){
                    $fontsFiles = File::files(public_path().$storage_url.$sicker->title.'/fonts/');
                    foreach($fontsFiles as $fontfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$sicker->title.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                    }
                }
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$sicker->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $json['layers'][$key]['font'] = $storage_url.$sicker->title.'/fonts/'.$data['font'].'.ttf';
                }
            }
            
            $sicker->json = json_encode($json);
        }
        $sicker->title = $request->get("title");
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
                
            }
            $sicker->thumbnail = $thumbnail_url;
        }
        
        $sicker->save();
        return redirect()->route('frame.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sicker = Frame::find($id);
        @unlink($sicker->thumbnail);
        Frame::find($id)->delete();
        
        return redirect()->route('frame.index');
    }
}
