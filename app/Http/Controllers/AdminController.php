<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['admins'] = Admin::get();
        return view('admin.index',$data);
    }
    
    public function setupView()
    {
        return view('installation.setup');
    }
    
    
    public function databaseSetup(Request $request)
    {
		            
        $env = file_get_contents(base_path('.env'));
        $dbName = $request->get('db_name');
        $dbHost = $request->get('db_host');
        $dbUsername = $request->get('db_username');
        $dbPassword = $request->get('db_password');
        $databaseSetting = '
            DB_HOST="' . $dbHost . '"
            DB_DATABASE="' . $dbName . '"
            DB_USERNAME="' . $dbUsername . '"
            DB_PASSWORD="' . $dbPassword . '"
            ';
        // @ignoreCodingStandard
        $rows = explode("\n", $env);
        $unwanted = "DB_HOST|DB_DATABASE|DB_USERNAME|DB_PASSWORD";
        $cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);

        $cleanString = implode("\n", $cleanArray);

        $env = $cleanString . $databaseSetting;
        try {
            
            $dbh = new \PDO('mysql:host=' . $dbHost, $dbUsername, $dbPassword);
            
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // First check if database exists
            $stmt = $dbh->query('CREATE DATABASE IF NOT EXISTS ' . $dbName . ' CHARACTER SET utf8 COLLATE utf8_general_ci;');
            // Save settings in session
            session_start();
            $_SESSION['db_username'] = $dbUsername;
            $_SESSION['db_password'] = $dbPassword;
            $_SESSION['db_name'] = $dbName;
            $_SESSION['db_host'] = $dbHost;
            $_SESSION['db_success'] = true;
            $message = 'Database settings correct';

            try {
                
                file_put_contents(base_path('.env'), $env);
                
                $database = DB::unprepared(file_get_contents(public_path('nyota.sql')));

                if($database == 'true') 
                {
                    file_put_contents(public_path('install'), 'nyota');
                    return json_encode(array("code" => "200","description" => "Success"));
                    
                } else {
                    abort(404);
                }
                
            } catch (Exception $e) {
                $message = "Unable to save the .env file, Please create it manually";
            }

            return json_encode(array("code" => "404","description" => $message));

        } catch (\PDOException $e) {
            
            return json_encode(array("code" => "404","description" => 'PDO -> '.$e->getMessage()));

        } catch (\Exception $e) {

            return json_encode(array("code" => "404","description" => 'E -> '.$e->getMessage()));

        }
    }
    
    function goToLogin(){
         return view('login');
    }
    
    function logout(){
        Session::flush();
        return view('login');
    }
    
    function login(Request $request){
        
        $request->validate([
            
            'username' => 'required',
            'password' => 'required',
            
        ]);
        
        $data = Admin::where('username',$request->username)->first();
        if($data){
            if (Hash::check($request->password,$data->password)) {
                Session::put('userid', $data->id);
                Session::put('username', $data->username);
                Session::put('profile', $data->profile_pic);
                Session::put('admin_type', $data->role);
                return redirect("/");
            }else{
                return redirect()->back()->withErrors(['loginerror' => 'Username password not match']);
            }
        }else{
            return redirect()->back()->withErrors(['loginerror' => 'Username password not match']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'required',
        ]);
        $admin = new Admin();
        $admin->username = $request->get('username');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));
        
        $permission = array();
        !empty($request->get('section')) ? $permission['section']='true' : $permission['section']='false';
        !empty($request->get('category')) ? $permission['category']='true' : $permission['category']='false';
        !empty($request->get('posts')) ? $permission['posts']='true' : $permission['posts']='false';
        !empty($request->get('greeting')) ? $permission['greeting']='true' : $permission['greeting']='false';
        !empty($request->get('video')) ? $permission['video']='true' : $permission['video']='false';
        !empty($request->get('slider')) ? $permission['slider']='true' : $permission['slider']='false';
        !empty($request->get('frame')) ? $permission['frame']='true' : $permission['frame']='false';
        !empty($request->get('subscription')) ? $permission['subscription']='true' : $permission['subscription']='false';
        !empty($request->get('offerdialog')) ? $permission['offerdialog']='true' : $permission['offerdialog']='false';
        !empty($request->get('pushnotification')) ? $permission['pushnotification']='true' : $permission['pushnotification']='false';
        !empty($request->get('contacts')) ? $permission['contacts']='true' : $permission['contacts']='false';
        !empty($request->get('transaction')) ? $permission['transaction']='true' : $permission['transaction']='false';
        !empty($request->get('user')) ? $permission['user']='true' : $permission['user']='false';
        !empty($request->get('setting')) ? $permission['setting']='true' : $permission['setting']='false';
        !empty($request->get('admin')) ? $permission['admin']='true' : $permission['admin']='false';
        
        $admin->permissions = json_encode($permission);
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            $admin->profile_pic = $item_url;
        }
        
        $admin->save();
        return redirect()->route('admins.index');
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
        $data['admin'] = Admin::find($id);
        $data['permission'] = json_decode($data['admin']['permissions'],true);
        return view('admin.edit',$data);
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
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $admin =Admin::find($id);
        $admin->username = $request->get('username');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));
        
        $permission = array();
        !empty($request->get('section')) ? $permission['section']='true' : $permission['section']='false';
        !empty($request->get('category')) ? $permission['category']='true' : $permission['category']='false';
        !empty($request->get('posts')) ? $permission['posts']='true' : $permission['posts']='false';
        !empty($request->get('greeting')) ? $permission['greeting']='true' : $permission['greeting']='false';
        !empty($request->get('video')) ? $permission['video']='true' : $permission['video']='false';
        !empty($request->get('slider')) ? $permission['slider']='true' : $permission['slider']='false';
        !empty($request->get('frame')) ? $permission['frame']='true' : $permission['frame']='false';
        !empty($request->get('subscription')) ? $permission['subscription']='true' : $permission['subscription']='false';
        !empty($request->get('offerdialog')) ? $permission['offerdialog']='true' : $permission['offerdialog']='false';
        !empty($request->get('pushnotification')) ? $permission['pushnotification']='true' : $permission['pushnotification']='false';
        !empty($request->get('contacts')) ? $permission['contacts']='true' : $permission['contacts']='false';
        !empty($request->get('transaction')) ? $permission['transaction']='true' : $permission['transaction']='false';
        !empty($request->get('user')) ? $permission['user']='true' : $permission['user']='false';
        !empty($request->get('setting')) ? $permission['setting']='true' : $permission['setting']='false';
        !empty($request->get('admin')) ? $permission['admin']='true' : $permission['admin']='false';
        
        $admin->permissions = json_encode($permission);
        
        if ($request->file("image") && $request->file('image')->isValid()) {
            $image = $request->file("image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/profile', $fileName);
            $item_url = 'uploads/profile/'.$fileName;
            $admin->profile_pic = $item_url;
        }
        
        $admin->save();
        return redirect()->route('admins.index');
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
