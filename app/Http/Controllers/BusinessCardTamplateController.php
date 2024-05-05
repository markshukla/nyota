<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCardTamplate;
use Illuminate\Support\Str;
use ZipArchive;
use File;
use Storage;
use App\Models\Setting;

class BusinessCardTamplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tamplates'] = BusinessCardTamplate::paginate(12);
        return view('businesscard.tamplate.index',$data);
    }
    
    
    public function card_status(Request $request)
    {
        $posts = BusinessCardTamplate::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function card_premium_action(Request $request)
    {
        $festivals = BusinessCardTamplate::find($request->get("id"));
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
        return view("businesscard.tamplate.create");
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
             'zip_file' => 'required',
             'image' => 'required',
             'premium' => 'required',
        ]);
        
        $tamplate = new BusinessCardTamplate();
        $tamplate->title = $request->get("title");
        $tamplate->premium = $request->get("premium");
        
        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/tamplate/businesscard/';
            $zip_obj = new ZipArchive();
            $zipdata = $_FILES['zip_file']['tmp_name'];
            
            if ($zip_obj->open($zipdata) === TRUE) {
                $zip_obj->extractTo(public_path().$storage_url.$tamplate->title.'/');
                $zip_obj->close();
            }
            
            $jsonname = '';
            $files = File::files(public_path().$storage_url.$tamplate->title.'/json/');
            foreach ($files as $file){
                $jsonname = basename($file, ".json");
                $text_info = File::get($file);
            }
            
            $foldername = Str::uuid();
            $json = json_decode($text_info,true);
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                $skinsFiles = File::files(public_path().$storage_url.$tamplate->title.'/skins/'.$jsonname.'/');
                foreach($skinsFiles as $skinfile)
                {
                    Storage::disk('spaces')->put($storage_url.$tamplate->title.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                }
                
                if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/')){
                    $fontsFiles = File::files(public_path().$storage_url.$tamplate->title.'/fonts/');
                    foreach($fontsFiles as $fontfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$tamplate->title.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                    }
                }
                
                File::deleteDirectory($storage_url.$tamplate->title);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$tamplate->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $json['layers'][$key]['font'] = $storage_url.$tamplate->title.'/fonts/'.$data['font'].'.ttf';
                }
            }
            
            $tamplate->json = json_encode($json);
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
            $tamplate->thumb_url = $thumbnail_url;
        }
        $tamplate->save();
        return redirect()->route('businesscardtamplate.index');
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
        $data['tamplate'] = BusinessCardTamplate::find($id);
        return view("businesscard.tamplate.edit", $data);
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
             'premium' => 'required',
        ]);
        
        $tamplate = BusinessCardTamplate::find($id);
        $tamplate->title = $request->get("title");
        $tamplate->premium = $request->get("premium");
        
        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            
            $storage_url = '/uploads/tamplate/businesscard/';
            
            $zip_obj = new ZipArchive();
            $zipdata = $_FILES['zip_file']['tmp_name'];
            
            if ($zip_obj->open($zipdata) === TRUE) {
                $zip_obj->extractTo(public_path().$storage_url.$tamplate->title.'/');
                $zip_obj->close();
            }
            
            $jsonname = '';
            $files = File::files(public_path().$storage_url.$tamplate->title.'/json/');
            foreach ($files as $file){
                $jsonname = basename($file, ".json");
                $text_info = File::get($file);
            }
            
            $foldername = Str::uuid();
            $json = json_decode($text_info,true);
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                
                $skinsFiles = File::files(public_path().$storage_url.$tamplate->title.'/skins/'.$jsonname.'/');
                foreach($skinsFiles as $skinfile)
                {
                    Storage::disk('spaces')->put($storage_url.$tamplate->title.'/skins/'.$jsonname.'/'.basename($skinfile), file_get_contents($skinfile), 'public');
                }
                
                if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/')){
                    $fontsFiles = File::files(public_path().$storage_url.$tamplate->title.'/fonts/');
                    foreach($fontsFiles as $fontfile)
                    {
                        Storage::disk('spaces')->put($storage_url.$tamplate->title.'/fonts/'.basename($fontfile), file_get_contents($fontfile), 'public');
                    }
                }
                
                File::deleteDirectory('uploads/tamplate/businesscard/'.$tamplate->title);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }else{
                $storage_url = 'uploads/tamplate/businesscard/';
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$tamplate->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $json['layers'][$key]['font'] = $storage_url.$tamplate->title.'/fonts/'.$data['font'].'.ttf';
                }
            }
            
            $tamplate->json = json_encode($json);
        }
        
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
            
            @unlink($tamplate->thumb_url);
            @unlink($item_url);
            
            $tamplate->thumb_url = $thumbnail_url;
        }
        
        $tamplate->save();
        return redirect()->route('businesscardtamplate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tamplate = BusinessCardTamplate::find($id);
        @unlink($tamplate->thumb_url);
        BusinessCardTamplate::find($id)->delete();
        return redirect()->route('businesscardtamplate.index');
    }
}
