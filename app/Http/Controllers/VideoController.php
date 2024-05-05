<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Video;
use App\Models\Category;
use App\Models\Language;
use App\Models\SubCategory;
use App\Models\Section;
use Illuminate\Support\Str;
use Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sections'] = Section::where('status','0')->get();
        $data['posts'] = Video::orderBy('id', 'DESC')->paginate(12);
        // echo(json_encode($data['posts']));
        // die();
        return view('video.index',$data);
    }
    
     public function filterby_type($type)
    {
        
        $data['sections'] = Section::where('status','0')->get();
        $data['posts'] = Video::where('type',$type)->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = $type;
         
        return view("video.index", $data);
    }
    
    public function video_status(Request $request)
    {
        // echo("okk");
        $festivals = Video::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    public function video_remove_section(Request $request)
    {
        $festivals = Video::find($request->get("id"));
        $festivals->section_id = 0;
        $festivals->save();
    }
    
    public function video_premium_action(Request $request)
    {
        $festivals = Video::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    public function video_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Video::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Video::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Video::find($id);
                    @unlink($posts->item_url);
                    @unlink($posts->thumb_url);
                    Video::find($id)->delete();
                    
                }
            }
            
            if($request->action_type == "section")
            {
                foreach($ids as $id){
                    
                    $posts = Video::find($id);
                    $posts->section_id = $request->section_id;
                    $posts->save();
                    
                }
            }
        }
        return redirect()->route("video.index");
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['languages'] = Language::where('status','0')->get();
        
        $data['festivals'] = Category::where('status','0')->where('type','festival')->get();
        $data['custom'] = Category::where('status','0')->where('type','custom')->get();
        
        // echo(json_encode($data['posts']));
        // die();
        return view('video.create',$data);
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
             'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:30720',
             'title' => 'required',
             'type' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        if ($request->file("video") && $request->file('video')->isValid()) {
            
            $videof = $request->file("video");
            
            $extension = $videof->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/video/'.$fileName, file_get_contents($videof),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/video/'.$fileName;
            }else{
                $videof->move('uploads/video', $fileName);
                $item_url = 'uploads/video/'.$fileName;
            }
            
            
            $id = Video::create([
                "title" => $request->get("title"),
                "category_id" => $request->get("category"),
                "sub_category_id" => $request->get("subcategory"),
                "item_url" => $item_url,
                "thumb_url" => $item_url,
                "type" => $request->get("type"),
                "language" => $request->get("language"),
            ]);
        }
        return redirect()->route('video.index');
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
        
        $data['languages'] = Language::where('status','0')->get();
        $data['video'] = video::find($id);
        $data['categories'] = Category::where('status','0')->where('type',$data['video']['type'])->get();
        $data['subcategories'] = SubCategory::where('status','0')->where('category_id',$data['video']['category_id'])->where('type',$data['video']['type'])->get();
        
        
        // echo(json_encode($data['posts']));
        // die();
        return view('video.edit',$data);
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
             'video' => 'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm|max:30720',
             'title' => 'required',
             'type' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        $video = Video::find($id);
        $video->title = $request->get("title");
        $video->category_id = $request->get("category");
        $video->sub_category_id = $request->get("subcategory");
        $video->type = $request->get("type");
        $video->language = $request->get("language");
        
        if ($request->file("video") && $request->file('video')->isValid()) {
            
            $videof = $request->file("video");
            
            $extension = $videof->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/video/'.$fileName, file_get_contents($videof),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/video/'.$fileName;
            }else{
                $videof->move('uploads/video', $fileName);
                $item_url = 'uploads/video/'.$fileName;
                @unlink($video->item_url);
            }
            
            $video->item_url = $item_url;
            $video->thumb_url = $video->item_url;
            
        }
        
        $video->save();
        return redirect()->route('video.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Video::find($id);
        @unlink($posts->item_url);
        // unlink($posts->thumb_url);

        Video::find($id)->delete();
        return redirect()->route('video.index');
    }
}
