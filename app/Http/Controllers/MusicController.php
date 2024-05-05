<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\MusicCategory;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Str;
use Storage;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['musics'] = Music::orderBy('id', 'DESC')->paginate(22);
        $data['categories'] = MusicCategory::where('status','0')->get();
        // echo json_encode($data);
        return view('music.index',$data);
    }
    
     public function music_status(Request $request)
    {
        // echo("okk");
        $festivals = Music::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    public function filterby_category($id)
    {
        
        $data['musics'] = Music::with('section')->where('type','festival')->where('category_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['categories'] = MusicCategory::where('status','0')->where('type','festival')->get();
        $category_name = MusicCategory::find($id);
        $data['category'] = $category_name->name;
         
        return view("music.index", $data);
    }
    
    
     public function premium_status(Request $request)
    {
        $festivals = Music::find($request->get("id"));
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
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = MusicCategory::where('status','0')->get();
        return view('music.create',$data);
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
             'music' => 'required',
             'title' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        $music = new Music();
        $music->title = $request->get("title");
        $music->category_id = $request->get("category");
        $music->language = $request->get("language");
        $music->premium = $request->get("premium");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
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
            }
            
            $music->thumbnail = $thumbnail_url;
        }
        if ($request->file("music") && $request->file('music')->isValid()) {
            $music_file = $request->file("music");
            
            $extension = $music_file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/music/'.$fileName, file_get_contents($music_file),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/music/'.$fileName;
            }else{
                $music_file->move('uploads/music', $fileName);
                $item_url = 'uploads/music/'.$fileName;
            }
            
            $music->item_url = $item_url;
        }
        $music->save();
        return redirect()->route('music.index');
        
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
        $data['music'] = Music::find($id);
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = MusicCategory::where('status','0')->get();
        return view('music.edit',$data);
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
        $music = Music::find($id);
        $music->title = $request->get("title");
        $music->category_id = $request->get("category");
        $music->language = $request->get("language");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/posts/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/posts/'.$fileName;
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
                @unlink($music->thumbnail);
            }
            
            $music->thumbnail = $thumbnail_url;
        }
        if ($request->file("music") && $request->file('music')->isValid()) {
            $music_file = $request->file("music");
            $extension = $music_file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/music/'.$fileName, file_get_contents($music_file),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/music/'.$fileName;
            }else{
                $music_file->move('uploads/music', $fileName);
                $item_url = 'uploads/music/'.$fileName;
            }
            
            $music->item_url = $item_url;
        }
        $music->save();
        return redirect()->route('music.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Music::find($id);
        @unlink($posts->item_url);
        @unlink($posts->thumbnail);

        Music::find($id)->delete();
        return redirect()->route('music.index');
    }
}
