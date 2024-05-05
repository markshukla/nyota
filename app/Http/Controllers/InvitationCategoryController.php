<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\InvitationCategory;
use Illuminate\Support\Str;

class InvitationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = InvitationCategory::orderBy('id', 'DESC')->paginate(22);
        return view('invitation.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function category_status(Request $request)
    {
        $posts = InvitationCategory::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    public function create()
    {
        return view("invitation.category.create");
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
        ]);
        
        $posts = new InvitationCategory();
        $posts->name = $request->get("title");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/posts', $fileName);
            $item_url = 'uploads/posts/'.$fileName;
            $thumbnail_url = 'uploads/posts/'.$thumbName;
                
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
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('invitationcategory.index');
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
        $data['category'] = InvitationCategory::find($id);
        return view("invitation.category.edit", $data);
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
        ]);
        
        $posts = InvitationCategory::find($id);
        $posts->name = $request->get("title");
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/posts', $fileName);
            $item_url = 'uploads/posts/'.$fileName;
            $thumbnail_url = 'uploads/posts/'.$thumbName;
            
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
            
            imagejpeg($image, $thumbnail_url, 99);
            
            @unlink($item_url);
            @unlink($posts->image);
            
            $posts->image = $thumbnail_url;
        }
        
        $posts->save();
        return redirect()->route('invitationcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = InvitationCategory::find($id);
        @unlink($posts->image);

        InvitationCategory::find($id)->delete();
        return redirect()->route('invitationcategory.index');
    }
}
