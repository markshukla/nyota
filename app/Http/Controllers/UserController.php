<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserTransaction;
use App\Models\UserPost;
use App\Models\UserBusiness;
use App\Models\UserFrame;
use App\Models\Withdraw;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\WhatsappMessage;
use Illuminate\Support\Str;
use Redirect;

class UserController extends Controller
{
    
    public function index()
    {
        $data['users'] = User::orderBy('id', 'DESC')->paginate(22);
        return view('user.index',$data);
    } 
    
    
    public function withdrawList()
    {
        $data['withdraws'] = Withdraw::with('user')->orderBy('id', 'DESC')->paginate(22);
        // echo(json_encode($data));
        return view('user.withdraws',$data);
    }
    
    public function users_status(Request $request)
    {
        $festivals = User::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    public function withdrawstatus(Request $request)
    {
        $festivals = Withdraw::find($request->get("id"));
        $festivals->status = $request->get("type");
        $festivals->save();
    }
    
    public function deletewithdraw(Request $request)
    {
        $festivals = Withdraw::find($request->get("id"));
        $festivals->delete();
        return redirect()->back();
    }
    
    public function deleteuserpost(Request $request)
    {
        $festivals = UserPost::find($request->get("id"));
        @unlink($festivals->post_url);
        UserPost::find($request->get("id"))->delete();
        return redirect()->back();
    } 
    
    public function deleteuserframe(Request $request)
    {
        $festivals = UserFrame::find($request->get("id"));
        @unlink($festivals->item_url);
        UserFrame::find($request->get("id"))->delete();
        return redirect()->back();
    }
    public function deleteuserbussines(Request $request)
    {
        $festivals = UserBusiness::find($request->get("id"));
        @unlink($festivals->image);
        UserBusiness::find($request->get("id"))->delete();
        return redirect()->back();
    }
    
    public function search(Request $request)
    {
        $data['search'] = $request->get("search");
        $data['users'] = User::where('name','like',"%".$request->get("search")."%")->orWhere('email','like',"%".$request->get("search")."%")->orWhere('number','like',"%".$request->get("search")."%")->get();
        return view('user.index',$data);
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subscriptions'] = Subscription::where('status','0')->orderBy('id','DESC')->get();
        return view('user.create',$data);
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
             'name' => 'required',
             'email' => 'required',
             'number' => 'required',
        ]);
        
        
        $user = User::where('number',$request->get('number'))->orWhere('email',$request->get('email'))->first();
        if($user){
            return Redirect::back()->withErrors(['msg' => 'User already exist']);
        }
        
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->number = $request->get('number');
        $user->social = $request->get('loginus');
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            if(Setting::getValue('storage_type') == "digitalOccean"){
                
                $item_url = Storage::disk('spaces')->put('uploads/profile/'.$fileName, file_get_contents($image),'public');
                $thumbnail_url = env("DO_SPACES_URL").'/uploads/profile/'.$fileName;
                $user->profile_pic = $thumbnail_url;
                
            }else{
            
                $image->move('uploads/profile', $fileName);
                $item_url = 'uploads/profile/'.$fileName;
                
                $user->profile_pic = $item_url;
                
            }
            
        }
        
        $referCode = $this->createRandomPassword();
        $user->refer_id = $referCode;
        
        $plan = Subscription::find($request->get("plan_name"));
        
        if($plan){
            $user->subscription_name = $plan->name;
            $user->subscription_price = $plan->price;
            $user->subscription_date = ($request->get("start_date"));
            $user->subscription_end_date = ($request->get("end_date"));
            
            $user->posts_limit = $user->posts_limit+$plan->posts_limit;
            $user->business_limit = $plan->business_limit;
            $user->political_limit = $plan->political_limit;
        }
            
        $user->save();
        
        
        return redirect()->route('users.index');
    }
    
    function createRandomPassword() { 

        $chars = "ABCDEFGHIJKLMNOPQESTUVWXYZ023456789"; 
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '';
    
        while ($i <= 7) {
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        }
    
        return $pass; 
    
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['businesses'] = UserBusiness::where('user_id',$id)->get();
        $data['posts'] = UserPost::where('user_id',$id)->orderBy('id','DESC')->get();
        $data['frames'] = UserFrame::where('user_id',$id)->orderBy('id','DESC')->get();
        $data['transactions'] = Transaction::where('user_id',$id)->orderBy('id','DESC')->get();
        $data['usertransactions'] = UserTransaction::where('user_id',$id)->orderBy('id','DESC')->get();
        $data['subscriptions'] = Subscription::where('status','0')->orderBy('id','DESC')->get();
        $data['user'] = User::find($id);
        $data['whatsapp_messages'] = WhatsappMessage::get();
        return view('user.show',$data);
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
    public function update_user_plan(Request $request)
    {
        $validatedData = $request->validate([
             'plan_name' => 'required',
             'start_date' => 'required',
             'end_date' => 'required',
        ]);
        
        $plan = Subscription::find($request->get("plan_name"));
        
        $user = User::find($request->get("user_id"));
        $user->subscription_name = $plan->name;
        $user->subscription_price = $plan->price;
        $user->subscription_date = ($request->get("start_date"));
        $user->subscription_end_date = ($request->get("end_date"));
        
        $user->posts_limit = $user->posts_limit+$plan->posts_limit;
        $user->business_limit = $plan->business_limit;
        $user->political_limit = $plan->political_limit;
            
        $user->save();
        return redirect()->back();
    }
    
    public function add_user_frame(Request $request)
    {
        $validatedData = $request->validate([
             'image' => 'required|mimes:jpg,png,jpeg',
             'user_id' => 'required',
        ]);
        
        $user = User::find($request->get('user_id'));
        if(!$user){
            return redirect()->back();
        }
        
        $frame = new UserFrame;
        $frame->user_id = $user->id;
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            // $path = $image->storeAs('public/profile',$fileName);
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            
            $frame->item_url = $item_url;
        }
        
        $frame->save();
        return redirect()->back();
    }
    
    public function change_frame_status(Request $request)
    {
        $festivals = UserFrame::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?0:1;
        $festivals->save();
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
             'profile_pic' => 'nullable|mimes:jpg,png,jpeg',
             'name' => 'required',
             'number' => 'nullable|int',
        ]);
        
        $user = User::find($id);
        $user->name = $request->get("name");
        
        if($request->has("email")){
            $user->email = $request->get("email");
        }
        if($request->has("number")){
            $user->number = $request->get("number");
        }
        
        if($request->has("post_limit")){
            $user->posts_limit = $request->get("post_limit");
        }
        if($request->has("business_limit")){
            $user->business_limit = $request->get("business_limit");
        }
        if($request->has("political_limit")){
            $user->political_limit = $request->get("political_limit");
        }
        
        
        if ($request->file("profile_pic") && $request->file('profile_pic')->isValid()) {
            $image = $request->file("profile_pic");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            
            @unlink($user->profile_pic);
            
            $user->profile_pic = $item_url;
        }
        
        $user->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = User::find($id);
        @unlink($posts->profile_pic);

        Transaction::where('user_id',$id)->delete();
        UserTransaction::where('user_id',$id)->delete();
        Contact::where('user_id',$id)->delete();
        
        User::find($id)->delete();
        
        return redirect()->route('users.index');
    }
}
