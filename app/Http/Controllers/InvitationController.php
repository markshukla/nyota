<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\InvitationCard;
use App\Models\InvitationCategory;
use Illuminate\Support\Str;
use ZipArchive;
use File;
use Storage;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = InvitationCard::where('orientation',null)->get();
        foreach ($cards as $card){
            
            $tamplate = InvitationCard::find($card->id);
            $size = getimagesize($tamplate->thumb_url);
            
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
            
            $tamplate->orientation = $orientation;
            $tamplate->height = $size[1];
            $tamplate->width = $size[0];
            $tamplate->save();
        }
        
        $data['cards'] = InvitationCard::orderBy('id', 'DESC')->paginate(12);
        return view('invitation.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function card_status(Request $request)
    {
        $posts = InvitationCard::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function card_premium_action(Request $request)
    {
        $festivals = InvitationCard::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    
    public function create()
    {
        $data['categories'] = InvitationCategory::where('status', '0')->get();
        return view("invitation.create",$data);
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
             'category' => 'required',
        ]);
        
        $tamplate = new InvitationCard();
        $tamplate->title = $request->get("title");
        $tamplate->premium = $request->get("premium");
        $tamplate->category_id = $request->get("category");
        
         if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/tamplate/invitationcard/';
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
                
                File::deleteDirectory(public_path().$storage_url.$tamplate->title);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$tamplate->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $ext = ".ttf";
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.ttf')){
                        $ext = ".ttf";
                    }
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.TTF')){
                        $ext = ".TTF";
                    }
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.otf')){
                        $ext = ".otf";
                    }
                    $json['layers'][$key]['font'] = $storage_url.$tamplate->title.'/fonts/'.$data['font'].$ext;
                }
            }
            
            $tamplate->json = json_encode($json);
        }
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            $size = getimagesize($image);
            if($size[0] > $size[1])
            {
                $type = "landscape";
            }
            if($size[0] < $size[1])
            {
                $type = "portrait";
            }
            if($size[0] == $size[1])
            {
                $type = "square";
            }
            
            $tamplate->type = $type;
            $tamplate->height = $size[1];
            $tamplate->width = $size[0];
                        
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
        return redirect()->route('invitationcard.index');
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
        $data['tamplate'] = InvitationCard::find($id);
        return view("invitation.edit", $data);
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
        
        $tamplate = InvitationCard::find($id);
        $tamplate->title = $request->get("title");
        $tamplate->premium = $request->get("premium");
        
        if ($request->file("zip_file") && $request->file('zip_file')->isValid()){
            $storage_url = '/uploads/tamplate/invitationcard/';
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
                
                File::deleteDirectory(public_path().$storage_url.$tamplate->title);
                $storage_url = env("DO_SPACES_URL").$storage_url;
            }
            
            foreach ($json['layers'] as $key => $data){
                
                if($data['type'] == "image"){
                    
                    $json['layers'][$key]['src'] = $storage_url.$tamplate->title.substr($data['src'], 2);
                }
                
                if($data['type'] == "text"){
                    $ext = ".txt";
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.ttf')){
                        $ext = ".ttf";
                    }
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.TTF')){
                        $ext = ".TTF";
                    }
                    if(File::exists(public_path().$storage_url.$tamplate->title.'/fonts/'.$data['font'].'.otf')){
                        $ext = ".otf";
                    }
                    $json['layers'][$key]['font'] = $storage_url.$tamplate->title.'/fonts/'.$data['font'].$ext;
                }
            }
            
            $tamplate->json = json_encode($json);
        }
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            $size = getimagesize($image);
            if($size[0] > $size[1])
            {
                $type = "landscape";
            }
            if($size[0] < $size[1])
            {
                $type = "portrait";
            }
            if($size[0] == $size[1])
            {
                $type = "square";
            }
            
            $tamplate->type = $type;
            $tamplate->height = $size[1];
            $tamplate->width = $size[0];
            
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
        return redirect()->route('invitationcard.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tamplate = InvitationCard::find($id);
        @unlink($tamplate->thumb_url);
        InvitationCard::find($id)->delete();
        return redirect()->route('invitationcard.index');
    }
}
