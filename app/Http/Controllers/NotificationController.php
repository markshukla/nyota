<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Storage;

class NotificationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        
        $data['notifications'] = Notification::orderBy('id', 'DESC')->paginate(12);
        return view('notification.index',$data);
    }
    
    public function notification_status(Request $request)
    {
        // echo("okk");
        $festivals = Notification::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
        
    }
    
    public function sendAutoFestivalNotification(Request $request)
    {
        if(Setting::getValue('auto_festival_notification') == "true"){
            $festivals = Category::where('event_date',date('Y-m-d',time()))->get();
            $tokens = User::select('device_token')->where('device_token','!=',NULL)->get();
            foreach($tokens as $t){
                $reg_tokens[] = $t->device_token;
            }
           
            foreach ($festivals as $festival){
                
                $url = 'https://fcm.googleapis.com/fcm/send';
                $headers = array (
                  'Authorization:key=' . Setting::getValue('fcm_key'),
                  'Content-Type:application/json'
                );
                
                $dataPayload = [
                  'title' => "Today is ".$festival->name,
                  'message' => "💥Create you business poster and 🤝 share to social media 🌐",
                  "cat_id"=>$festival->id,
                  "big_picture" => !empty(url($festival->image)) ? asset($festival->image) : '',
                ];

                $apiBody = [
                  'channelId' => "notify",
                  'android_channel_id' => "notify",
                  'channel_id' => "notify", 
                  'priority'=>'high',
                  'data' => $dataPayload,
                  'registration_ids'  => $reg_tokens,
                ];

                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_POST, true);
                curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody,JSON_UNESCAPED_SLASHES));
              
                $result = curl_exec($ch);
                print( json_encode($apiBody,JSON_UNESCAPED_SLASHES));
                curl_close($ch);
                $response = json_decode($result);
                return $response;
  
               
            }
        }else{
            return "Disabled";
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['subscriptions'] = Subscription::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->get();
        return view("notification.create", $data);
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
             'image' => 'nullable|mimes:jpg,png,jpeg',
             'title' => 'required',
             'message' => 'required',
             'type' => 'required',
        ]);
        
        $posts = new Notification();
        $posts->title = $request->get("title");
        $posts->message = $request->get("message");
        $posts->action = $request->get("type");
        
        if($request->get("type") == 'category'){
            $posts->action_item = $request->get("category");
        }
        if($request->get("type") == 'url'){
            $posts->action_item = $request->get("url");
        }
        if($request->get("type") == 'subscription'){
            $posts->action_item = $request->get("subscription");
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
                
                imagejpeg($image, $thumbnail_url, 80);
                
                @unlink($item_url);
            }
            
            $posts->thumbnail = $thumbnail_url;
        }
        
        $setting = Setting::where('id','1')->first();
        $data = array(
            "action" => $posts->action,
            "action_item" => $posts->action_item,
        );
        $title = array(
            "en" => $posts->title,
        );
        $message  = array(
            "en" => $posts->message,
        );
        $fields = array(
            "app_id" => Setting::getValue('onesignal_app_id'),
            "headings" => $title,
            "title" => $title,
            "data" => $data,
            'included_segments' => array(
                'Subscribed Users'
            ),
            "big_picture" => !empty($posts->thumbnail) ? asset($posts->thumbnail) : '',
            "content_available" => true,
            "contents" => $message,
        );
        $headers = array(
            "Accept: application/json",
            "Authorization: Basic ".Setting::getValue('onesignal_key'),
            "Content-Type: application/json"
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result);
        
        if(!empty($response->errors)){
            @unlink($posts->thumbnail);
            return back()->withErrors($response->errors)->withInput();
        }
        
        $posts->save();
        return redirect()->route('pushnotification.index');
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
        
        $data['subscriptions'] = Subscription::where('status','0')->get();
        $data['categories'] = Category::where('status','0')->get();
        $data['notification'] = Notification::find($id);
        return view("notification.edit", $data);
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
             'message' => 'required',
             'type' => 'required',
        ]);
        
        $posts = Notification::find($id);
        $posts->title = $request->get("title");
        $posts->message = $request->get("message");
        $posts->action = $request->get("type");
        
        if($request->get("type") == 'category'){
            $posts->action_item = $request->get("category");
        }
        if($request->get("type") == 'url'){
            $posts->action_item = $request->get("url");
        }
        if($request->get("type") == 'subscription'){
            $posts->action_item = $request->get("subscription");
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
                
                imagejpeg($image, $thumbnail_url, 80);
                
                @unlink($item_url);
                @unlink($posts->thumbnail);
            }
            
            $posts->thumbnail = $thumbnail_url;
        }
        
        if($request->get("send_push")){
            $setting = Setting::where('id','1')->first();
            $data = array(
                "action" => $posts->action,
                "action_item" => $posts->action_item,
            );
            $title = array(
                "en" => $posts->title,
            );
            $message  = array(
                "en" => $posts->message,
            );
            $fields = array(
                "app_id" => Setting::getValue('onesignal_app_id'),
                "headings" => $title,
                "title" => $title,
                "data" => $data,
                'included_segments' => array(
                    'Subscribed Users'
                ),
                "big_picture" => !empty($posts->thumbnail) ? asset($posts->thumbnail) : '',
                "content_available" => true,
                "contents" => $message,
            );
            $headers = array(
                "Accept: application/json",
                "Authorization: Basic ".Setting::getValue('onesignal_key'),
                "Content-Type: application/json"
            );
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($result);
            
            if(!empty($response->errors)){
                @unlink($posts->thumbnail);
                return back()->withErrors($response->errors)->withInput();
            }
        }
        
        $posts->save();
        return redirect()->route('pushnotification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Notification::find($id);
        @unlink($posts->thumbnail);
        Notification::find($id)->delete();
        return redirect()->route('pushnotification.index');
    }
}
