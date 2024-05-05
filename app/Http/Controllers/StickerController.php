<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Sticker;
use App\Models\StickerCategory;
use Illuminate\Support\Str;
use Storage;

class StickerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['categories'] = StickerCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['stickers'] = Sticker::orderBy('id', 'DESC')->paginate(12);
        
        return view('stickers.index',$data);
    }
    
    public function filterby_category($id){
        
        $data['categories'] = StickerCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['stickers'] = Sticker::where('category_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['category'] = StickerCategory::find($id)->name;
        return view('stickers.index',$data);
    }
    
    public function sticker_status(Request $request)
    {
        // echo("okk");
        $posts = Sticker::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function sticker_premium_action(Request $request)
    {
        $festivals = Sticker::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    public function sticker_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Sticker::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Sticker::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Sticker::find($id);
                    @unlink($posts->item_url);
                    Sticker::find($id)->delete();
                    
                }
            }
            
        }
        return redirect()->route("sticker.index");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['categories'] = StickerCategory::where('status','0')->orderBy('id', 'DESC')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('stickers.create',$data);
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
             'category' => 'required'
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
                    $item_url = Storage::disk('spaces')->put('uploads/sticker/'.$fileName, file_get_contents($image),'public');
                    $item_url = env("DO_SPACES_URL").'/uploads/sticker/'.$fileName;
                }else{
                    $image->move('uploads/sticker', $fileName);
                    $item_url = 'uploads/sticker/'.$fileName;
                }
                
                
                $sicker = new Sticker();
                $sicker->name = $request->get("title");
                $sicker->category_id = $request->get("category");
                $sicker->item_url = $item_url;
                $sicker->save();

            }
            // return $request->get("premium");
            return redirect()->route('sticker.index');
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
        
        $data['sticker'] = Sticker::find($id);
        $data['categories'] = StickerCategory::where('status','0')->orderBy('id', 'DESC')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('stickers.edit',$data);
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
             'category' => 'required'
        ]);
        $sicker = Sticker::find($id);
        $sicker->name = $request->get("title");
        $sicker->category_id = $request->get("category");
        
        if ($request->file("image") && $request->file('image')->isValid()) 
        {
            $image = $request->file('image');
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
             if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/sticker/'.$fileName, file_get_contents($image),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/sticker/'.$fileName;
            }else{
                $image->move('uploads/sticker', $fileName);
                $item_url = 'uploads/sticker/'.$fileName;
            }
            
            @unlink($sicker->item_url);
            $sicker->item_url = $item_url;
        }
       
        $sicker->save();
        return redirect()->route('sticker.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sicker = Sticker::find($id);
        
        @unlink($sicker->item_url);

        Sticker::find($id)->delete();
        
        return redirect()->route('sticker.index');
    }
}
