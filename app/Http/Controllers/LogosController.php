<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Logos;
use App\Models\LogoCategory;
use Illuminate\Support\Str;
use Storage;

class LogosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = LogoCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['logos'] = Logos::orderBy('id', 'DESC')->paginate(12);
        
        return view('logo.index',$data);
    }
    
    public function filterby_category($id){
        
        $data['categories'] = LogoCategory::where('status','0')->orderBy('id', 'DESC')->get();
        $data['logos'] = Logos::where('category_id',$id)->orderBy('id', 'DESC')->paginate(12);
        $data['category'] = LogoCategory::find($id)->name;
        return view('logo.index',$data);
    }
    
    public function logos_status(Request $request)
    {
        // echo("okk");
        $posts = Logos::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function logos_premium_action(Request $request)
    {
        $festivals = Logos::find($request->get("id"));
        $festivals->premium = $request->get("type");
        $festivals->save();
    }
    
    public function logos_action(Request $request)
    {
        $ids = explode(",",$request->posts_ids);
        if($request->posts_ids != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $posts = Logos::find($id);
                    $posts->status = 0;
                    $posts->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $posts = Logos::find($id);
                    $posts->status = 1;
                    $posts->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    
                    $posts = Logos::find($id);
                    @unlink($posts->item_url);
                    Logos::find($id)->delete();
                    
                }
            }
            
        }
        return redirect()->route("logos.index");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = LogoCategory::where('status','0')->orderBy('id', 'DESC')->get();
        return view('logo.create',$data);
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
             'code' => 'required',
             'category' => 'required'
        ]);
        
        $sicker = new Logos();
        $sicker->title = $request->get("title");
        $sicker->category_id = $request->get("category");
        $sicker->code = $request->get("code");
                
        if ($request->file("image") && $request->file('image')->isValid()) 
        {
            $image = $request->file('image');
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
             if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/logos/'.$fileName, file_get_contents($image),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/logos/'.$fileName;
            }else{
                $image->move('uploads/logos', $fileName);
                $item_url = 'uploads/logos/'.$fileName;
            }
            
            $sicker->thumb_url = $item_url;
        }
        
        $sicker->save();
        return redirect()->route('logos.index');
        
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
        $data['logo'] = Logos::find($id);
        $data['categories'] = LogoCategory::where('status','0')->orderBy('id', 'DESC')->get();
        // echo(json_encode($data['posts']));
        // die();
        return view('logo.edit',$data);
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
             'code' => 'required',
             'category' => 'required'
        ]);
        
        $sicker = Logos::find($id);
        $sicker->title = $request->get("title");
        $sicker->category_id = $request->get("category");
        $sicker->code = $request->get("code");
                
        if ($request->file("image") && $request->file('image')->isValid()) 
        {
            $image = $request->file('image');
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
             if(Setting::getValue('storage_type') == "digitalOccean"){
                $item_url = Storage::disk('spaces')->put('uploads/logos/'.$fileName, file_get_contents($image),'public');
                $item_url = env("DO_SPACES_URL").'/uploads/logos/'.$fileName;
            }else{
                $image->move('uploads/logos', $fileName);
                $item_url = 'uploads/logos/'.$fileName;
            }
            
            $sicker->thumb_url = $item_url;
        }
        
        $sicker->save();
        return redirect()->route('logos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sicker = Logos::find($id);
        
        @unlink($sicker->thumb_url);

        Logos::find($id)->delete();
        
        return redirect()->route('logos.index');
    }
}
