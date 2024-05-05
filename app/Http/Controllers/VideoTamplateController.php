<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoTamplate;
use App\Models\VideoTamplateCategory;
use App\Models\Setting;
use App\Models\Language;
use Illuminate\Support\Str;

class VideoTamplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = VideoTamplate::orderBy('id', 'DESC')->paginate(12);
        return view('videoTamplate.index',$data);
    }
    
    public function filterby_type($type)
    {
        $data['posts'] = VideoTamplate::where('type',$type)->orderBy('id', 'DESC')->paginate(12);
        $data['type'] = $type;
         
        return view("videoTamplate.index", $data);
    }
    
    public function video_status(Request $request)
    {
        // echo("okk");
        $festivals = VideoTamplate::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    
    public function premium_action(Request $request)
    {
        $festivals = VideoTamplate::find($request->get("id"));
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
                    $posts = VideoTamplate::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = VideoTamplate::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = VideoTamplate::find($id);
                    @unlink($posts->video_url);
                    @unlink($posts->zip_url);
                    VideoTamplate::find($id)->delete();
                    
                }
            }
        }
        return redirect()->route("videotamplate.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = VideoTamplateCategory::where('status','0')->get();
        
        return view('videoTamplate.create',$data);
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
             'zip' => 'required',
             'title' => 'required',
             'type' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        $video = new VideoTamplate();
        $video->title = $request->get("title");
        $video->category_id = $request->get("category");
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
            }
            
            $video->thumb_url = $item_url;
            $video->video_url = $item_url;
            
        }
        if ($request->file("zip") && $request->file('zip')->isValid()) {
            
            $zip = $request->file("zip");
            
            $extension = $zip->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $zip_url = Storage::disk('spaces')->put('uploads/videoTamplate/'.$fileName, file_get_contents($zip),'public');
                $zip_url = env("DO_SPACES_URL").'/uploads/videoTamplate/'.$fileName;
            }else{
                $zip->move('uploads/videoTamplate', $fileName);
                $zip_url = 'uploads/videoTamplate/'.$fileName;
            }
            $video->zip_url = $zip_url;
            
        }
        $video->save();
        return redirect()->route('videotamplate.index');
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
        $data['video'] = VideoTamplate::find($id);
        $data['languages'] = Language::where('status','0')->get();
        $data['categories'] = VideoTamplateCategory::where('status','0')->get();
        return view('videoTamplate.edit',$data);
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
             'type' => 'required',
             'category' => 'required',
             'language' => 'required',
        ]);
        
        $video = VideoTamplate::find($id);
        $video->title = $request->get("title");
        $video->category_id = $request->get("category");
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
                @unlink($video->video_url);
            }
            $video->thumb_url = $item_url;
            $video->video_url = $item_url;
            
        }
        if ($request->file("zip") && $request->file('zip')->isValid()) {
            
            $zip = $request->file("zip");
            
            $extension = $zip->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                $zip_url = Storage::disk('spaces')->put('uploads/videoTamplate/'.$fileName, file_get_contents($zip),'public');
                $zip_url = env("DO_SPACES_URL").'/uploads/videoTamplate/'.$fileName;
            }else{
                $zip->move('uploads/videoTamplate', $fileName);
                $zip_url = 'uploads/videoTamplate/'.$fileName;
            }
            @unlink($video->zip_url);
            $video->zip_url = $zip_url;
        }
        $video->save();
        return redirect()->route('videotamplate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = videoTamplate::find($id);
        @unlink($posts->video_url);
        @unlink($posts->zip_url);

        videoTamplate::find($id)->delete();
        return redirect()->route('videotamplate.index');
    }
}
