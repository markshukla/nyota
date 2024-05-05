<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Setting;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['subscriptions'] = Subscription::orderBy('id', 'DESC')->paginate(12);
        return view('subscription.index',$data);
    }
    
    public function subscription_status(Request $request)
    {
        // echo("okk");
        $festivals = Subscription::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    
    public function get_subscription_info(Request $request)
    {
        // echo("okk");
        $subs = Subscription::find($request->get("id"));
        $data['start_date'] = date('Y-m-d');
        $data['end_date'] = date('Y-m-d', strtotime($subs->value." ".$subs->type));
        return $data;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view("subscription.create");
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
             'image' => 'required|mimes:jpg,png,jpeg',
             'title' => 'required',
             'price' => 'required',
             'value' => 'required',
             'type' => 'required',
        ]);
        
        $posts = new Subscription();
        $posts->name = $request->get("title");
        $posts->price = $request->get("price");
        $posts->discount_price = $request->get("discount_price");
        $posts->value = $request->get("value");
        $posts->type = $request->get("type");
        $posts->posts_limit = $request->get("post_limit");
        $posts->business_limit = $request->get("business_limit");
        $posts->political_limit = $request->get("political_limit");
        $posts->details = json_encode($request->get('detail'));
        
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
                
                imagejpeg($image, $thumbnail_url, 80);
                
                @unlink($item_url);
            }
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('subscription.index');
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
        
        $data['subscription'] = Subscription::find($id);
        $data['plan_detail'] = json_decode($data['subscription']['details'],true);
        
        return view("subscription.edit", $data);
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
             'price' => 'required',
             'value' => 'required',
             'type' => 'required',
        ]);
        
        $posts = Subscription::find($id);
        $posts->name = $request->get("title");
        $posts->price = $request->get("price");
        $posts->discount_price = $request->get("discount_price");
        $posts->value = $request->get("value");
        $posts->type = $request->get("type");
        $posts->posts_limit = $request->get("post_limit");
        $posts->business_limit = $request->get("business_limit");
        $posts->political_limit = $request->get("political_limit");
        $posts->details = json_encode($request->get('detail'));
        
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
                
                imagejpeg($image, $thumbnail_url, 80);
                
                @unlink($item_url);
                @unlink($posts->image);
            }
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('subscription.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Subscription::find($id);
        @unlink($posts->image);
        Subscription::find($id)->delete();
        return redirect()->route('subscription.index');
    }
}
