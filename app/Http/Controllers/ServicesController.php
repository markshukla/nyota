<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\ServiceInquiries;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Models\Setting;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['services'] = Services::paginate(12);
        return view('services.index',$data);
    }
    
    public function service_inquiries()
    {
        $data['inquiries'] = ServiceInquiries::with('user')->with('service')->paginate(12);
        // echo(json_encode($data));
        return view('services.inquiries',$data);
    }
    
    public function deleteInquiry($id){
        
        ServiceInquiries::find($id)->delete();
        return redirect()->route('ourservices.index');
    }
    
    public function service_status(Request $request)
    {
        $posts = Services::find($request->get("id"));
        $posts->status = ($request->get("checked")=="true")?0:1;
        $posts->save();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("services.create");
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
             'title' => 'required',
             'old_price' => 'required',
             'new_price' => 'required',
             'description' => 'required',
             'image' => 'required',
        ]);
        
        $tamplate = new Services();
        $tamplate->title = $request->get("title");
        $tamplate->old_price = $request->get("old_price");
        $tamplate->new_price = $request->get("new_price");
        $tamplate->description = $request->get("description");
        
        if ($request->file("image") && $request->file('image')->isValid()) 
        {
            
            $image = $request->file('image');
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
                
                imagejpeg($image, $thumbnail_url, 50);
                
                @unlink($item_url);
            }
            
            $tamplate->thumb_url = $thumbnail_url;
        }
        
        $tamplate->save();
        return redirect()->route('ourservices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['service'] = Services::find($id);
        return view("services.edit", $data);
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
             'old_price' => 'required',
             'new_price' => 'required',
             'description' => 'required',
        ]);
        
        $tamplate = Services::find($id);
        $tamplate->title = $request->get("title");
        $tamplate->old_price = $request->get("old_price");
        $tamplate->new_price = $request->get("new_price");
        $tamplate->description = $request->get("description");
        
        if ($request->file("image") && $request->file('image')->isValid()) 
        {
            
            $image = $request->file('image');
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
                
                imagejpeg($image, $thumbnail_url, 50);
                
                @unlink($item_url);
                @unlink($tamplate->thumb_url);
            }
            
            $tamplate->thumb_url = $thumbnail_url;
        }
        
        $tamplate->save();
        return redirect()->route('ourservices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tamplate = Services::find($id);
        @unlink($tamplate->thumb_url);
        Services::find($id)->delete();
        return redirect()->route('ourservices.index');
    }
}
