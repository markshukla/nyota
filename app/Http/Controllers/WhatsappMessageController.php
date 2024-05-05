<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappMessage;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;
use Carbon\Carbon;

class WhatsappMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['messages'] = WhatsappMessage::orderBy('id', 'DESC')->paginate(12);
        return view('whatsapp.index',$data);
    }
    
    public function sendSingleUserWhatsappMessage(Request $request){
        
        $id = $request->get('msg_id');
        $user_id = $request->get('user_id');
        
        $whtspMsg = WhatsappMessage::find($id);
        $user = User::find($user_id);
        
        
        $data['apikey'] = Setting::getValue('whatsapp_api_key');
        $data['instance'] = Setting::getValue('whatsapp_instance_id');
        $data['msg'] = $whtspMsg->msg;
        $url = "https://app.wapify.net/api/text-message.php";
        
        
        if(!str_starts_with($user->number,"+")) {
            $user->number = "+91".$user->number;
        }
        $data['number'] = $user->number;
        
        if($whtspMsg->type == "media"){
            
            $url = "https://app.wapify.net/api/media-message.php";
            $data['media'] = url($whtspMsg->media);
            
        }
        
        if($whtspMsg->type == "button"){
            
            $url = "https://app.wapify.net/api/button-message.php";
            $data['btn1'] = $whtspMsg->btn1;
            $data['btn1value'] = $whtspMsg->btn1value;
            $data['btn1type'] = $whtspMsg->btn1type;
            
            if($whtspMsg->btn2 != "" && $whtspMsg->btn2value != "" && $whtspMsg->btn2type != ""){
                $data['btn2'] = $whtspMsg->btn2;
                $data['btn2value'] = $whtspMsg->btn2value;
                $data['btn2type'] = $whtspMsg->btn2type;
            }
            
            $data['footer'] = $whtspMsg->footer;
            
            if($whtspMsg->media != ""){
                $data['media'] = url($whtspMsg->media);
            }
            
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
    
    
    public function sendWhatsappMessage(Request $request)
    {
        
        $id = $request->get('id');
        
        $quantity = $request->get('quantity');
        $user_type = $request->get('user_type');
        
        $whtspMsg = WhatsappMessage::find($id);
        
        $data['apikey'] = Setting::getValue('whatsapp_api_key');
        $data['instance'] = Setting::getValue('whatsapp_instance_id');
        $data['msg'] = $whtspMsg->msg;
        $url = "https://app.wapify.net/api/text-message.php";
        
        $users_final = "";
        $users = array();
        if($user_type == "newest"){
            $users = User::where('number','!=','')->latest()->limit($quantity)->get();
        }else if($user_type == "older"){
            $users = User::where('number','!=','')->where('created_at','>=',Carbon::now()->subdays(20))->limit($quantity)->get();
        }else {
            $users = User::where('number','!=','')->inRandomOrder()->limit($quantity)->get();
        }
        die();
        foreach ($users as $key => $user){
            if(str_starts_with($user->number,"+")) {
                if($users_final == ""){
                    $users_final = $user->number;
                }else{
                    $users_final = $users_final.",".$user->number;
                }
                
            }else{
                if($users_final == ""){
                    $users_final = "+91".$user->number;
                }else{
                    $users_final = $users_final.","."+91".$user->number;
                }
                
            }
        }
        
        $data['number'] = $users_final;
        if($whtspMsg->type == "media"){
            
            $url = "https://app.wapify.net/api/media-message.php";
            $data['media'] = url($whtspMsg->media);
            
        }
        
        if($whtspMsg->type == "button"){
            
            $url = "https://app.wapify.net/api/button-message.php";
            $data['btn1'] = $whtspMsg->btn1;
            $data['btn1value'] = $whtspMsg->btn1value;
            $data['btn1type'] = $whtspMsg->btn1type;
            
            if($whtspMsg->btn2 != "" && $whtspMsg->btn2value != "" && $whtspMsg->btn2type != ""){
                $data['btn2'] = $whtspMsg->btn2;
                $data['btn2value'] = $whtspMsg->btn2value;
                $data['btn2type'] = $whtspMsg->btn2type;
            }
            
            $data['footer'] = $whtspMsg->footer;
            
            if($whtspMsg->media != ""){
                $data['media'] = url($whtspMsg->media);
            }
            
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
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
        return view("whatsapp.create", $data);
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
             'message' => 'required',
             'type' => 'required',
        ]);
        
        $posts = new WhatsappMessage();
        $posts->msg = $request->get("message");
        $posts->type = $request->get("type");
        
        if($request->get("type") == 'button'){
            
            $posts->btn1 = $request->get("btn1");
            $posts->btn1value = $request->get("btn1value");
            $posts->btn1type = $request->get("btn1type");
            
            $posts->btn2 = $request->get("btn2");
            $posts->btn2value = $request->get("btn2value");
            $posts->btn2type = $request->get("btn2type");
            
            $posts->footer = $request->get("footer");
            
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
            
            $posts->media = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('whatsappmessage.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = WhatsappMessage::find($id);
        @unlink($posts->media);
        WhatsappMessage::find($id)->delete();
        return redirect()->route('whatsappmessage.index');
    }
}
