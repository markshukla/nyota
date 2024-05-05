<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBusiness;
use App\Models\Category;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;

class UserBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
             'user_id' => 'required',
             'number' => 'required|int',
             'email' => 'required',
        ]);
        
        $business = new UserBusiness();
        
        $business->company = $request->get("name");
        $business->name = $request->get("owner");
        $business->designation = $request->get("designation");
        $business->category_id = $request->get("category");
        
        $business->user_id = $request->get("user_id");
        $business->number = $request->get("number");
        $business->email = $request->get("email");
        
        
        if($request->has("about") && !empty($request->has("about"))){
            $business->about = $request->get("about");
        }
        if($request->has("number") && !empty($request->has("number"))){
            $business->number = $request->get("number");
        }
        if($request->has("email") && !empty($request->has("email"))){
            $business->email = $request->get("email");
        }
        if($request->has("website") && !empty($request->has("website"))){
            $business->website = $request->get("website");
        }
        if($request->has("address") && !empty($request->has("address"))){
            $business->address = $request->get("address");
        }
        if($request->has("whatsapp") && !empty($request->has("whatsapp"))){
            $business->whatsapp = $request->get("whatsapp");
        }
        if($request->has("facebook") && !empty($request->has("facebook"))){
            $business->facebook = $request->get("facebook");
        }
        if($request->has("youtube") && !empty($request->has("youtube"))){
            $business->youtube = $request->get("youtube");
        }
        if($request->has("instagram") && !empty($request->has("instagram"))){
            $business->instagram = $request->get("instagram");
        }
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            // $path = $image->storeAs('public/profile',$fileName);
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            @unlink($business->image);
            $business->image = $item_url;
        }
        
        $business->save();
        return redirect()->route('users.show',$business->user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data['business'] = UserBusiness::find($id);
        return view('user.business.show',$data);
    }
    
    public function addbusiness($id)
    {
        
        $data['user'] = User::find($id);
        $data['categories'] = Category::where('type','business')->where('status','0')->get();
        return view('user.business.create',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data['business'] = UserBusiness::find($id);
        $data['categories'] = Category::where('type','business')->where('status','0')->get();
        return view('user.business.edit',$data);
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
             'name' => 'required',
             'number' => 'required',
             'email' => 'required',
        ]);
        
        $business = UserBusiness::find($id);
        
        $business->company = $request->get("name");
        $business->name = $request->get("owner");
        $business->designation = $request->get("designation");
        $business->category_id = $request->get("category");
        
        $business->number = $request->get("number");
        $business->email = $request->get("email");
        
        if($request->has("about") && !empty($request->has("about"))){
            $business->about = $request->get("about");
        }
        if($request->has("number") && !empty($request->has("number"))){
            $business->number = $request->get("number");
        }
        if($request->has("email") && !empty($request->has("email"))){
            $business->email = $request->get("email");
        }
        if($request->has("website") && !empty($request->has("website"))){
            $business->website = $request->get("website");
        }
        if($request->has("address") && !empty($request->has("address"))){
            $business->address = $request->get("address");
        }
        if($request->has("whatsapp") && !empty($request->has("whatsapp"))){
            $business->whatsapp = $request->get("whatsapp");
        }
        if($request->has("facebook") && !empty($request->has("facebook"))){
            $business->facebook = $request->get("facebook");
        }
        if($request->has("youtube") && !empty($request->has("youtube"))){
            $business->youtube = $request->get("youtube");
        }
        if($request->has("instagram") && !empty($request->has("instagram"))){
            $business->instagram = $request->get("instagram");
        }
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            // $path = $image->storeAs('public/profile',$fileName);
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            @unlink($business->image);
            $business->image = $item_url;
        }
        
        $business->save();
        return redirect()->route('users.show',$business->user_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
