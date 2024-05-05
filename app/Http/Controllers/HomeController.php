<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Models\Category;
use App\Models\Posts;
use App\Models\Video;
use App\Models\Transaction;
use App\Models\Contact;
use Carbon\Carbon;
use File;

class HomeController extends Controller
{
    function index(){
        
        $path = public_path().'/uploads/pdf/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/frame/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/logos/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/music/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/posts/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/profile/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/sticker/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/tamplate/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/thumbnail/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $path = public_path().'/uploads/video/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        
        $data['user_count'] = User::count();
        $data['category_count'] = Category::count();
        $data['posts_count'] = Posts::count();
        $data['videos_count'] = Video::count();
        
        $data['recent_user'] = User::latest()->take(10)->get();
        $data['recent_transaction'] = Transaction::with('user')->latest()->take(10)->get();
        $data['recent_contact'] = Contact::with('user')->latest()->take(10)->get();
        
        $data['today_payment'] = $this->formatPrice(Transaction::where('created_at',date('Y-m-d',strtotime('today')))->sum('amount'));
        $data['weekly_payment'] = $this->formatPrice(Transaction::whereBetween('created_at',[date('Y-m-d',strtotime('this week')),date('Y-m-d',strtotime('today'))])->sum('amount'));
        $data['monthly_payment'] = $this->formatPrice(Transaction::whereBetween('created_at',[date('Y-m-d',strtotime('first day of this month')),date('Y-m-d',strtotime('today'))])->sum('amount'));
        $data['total_payment'] = $this->formatPrice(Transaction::sum('amount'));
        
        $data['subs_end_usr'] = User::whereBetween('subscription_end_date',[date('Y-m-d',strtotime('today')),date('Y-m-d',strtotime('+20 days'))])->get();
        
        $subuser = User::where('subscription_name','!=','')->get();
        foreach ($subuser as $user){
            $date1 = Carbon::createFromFormat('Y-m-d', date('Y-m-d',time()));
            $date2 = Carbon::createFromFormat('Y-m-d', $user->subscription_end_date);
            
            $result = $date1->gt($date2);
            if($result){
                $u = User::find($user->id);
                $user->subscription_name = null;
                $user->subscription_price = null;
                $user->subscription_date = null;
                $user->subscription_end_date = null;
                $user->save();
            }
        }
        
        $today_event = Category::where('event_date',date('Y-m-d',strtotime('today')))->take(12)->get();
        foreach ($today_event as $key => $value) {
            $today_event[$key]['posts'] = Posts::where('category_id',$value->id)->count();
            $today_event[$key]['video'] = Video::where('category_id',$value->id)->count();
        }
        $data['today_event'] = $today_event;
        
        $month_payment_report = Transaction::select('id','amount',DB::raw("DATE_FORMAT(created_at, '%M, %Y') as month"))->get()->groupBy('month');
        
        $sum = [];
        $transa = [];

        foreach ($month_payment_report as $key => $value) {
            $total = 0;
            foreach ($value as $key1 => $val) 
            {
                $total = $total + $val->amount;
            }
            $sum[$key] = $total;
        }
       
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($sum[date("F, Y", mktime(0,0,0,$i,1))])) {
                $transa[$i]['count'] = $sum[date("F, Y", mktime(0,0,0,$i,1))];
            } else {
                $transa[$i]['count'] = 0;
            }
            $transa[$i]['month'] = date("M", mktime(0,0,0,$i,1));
            $transa[$i]["fullMonth"] = date("F, Y", mktime(0,0,0,$i,1));
        }
        
        $data['tran_chart']=$transa;
        
        $user_month_report = User::select('id', DB::raw("DATE_FORMAT(created_at, '%M, %Y') as month"))->get()->groupBy('month');
        
        $usermcount = [];
        $userArr = [];
        
        foreach ($user_month_report as $key => $value) {
            $usermcount[$key] = count($value);
        }
    
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($usermcount[date("F, Y", mktime(0,0,0,$i,1))])) {
                $userArr[$i]['count'] = $usermcount[date("F, Y", mktime(0,0,0,$i,1))];
            } else {
                $userArr[$i]['count'] = 0;
            }
            $userArr[$i]['month'] = date("M", mktime(0,0,0,$i,1));
            $transa[$i]["fullMonth"] = date("F, Y", mktime(0,0,0,$i,1));
        }
        
        $data['user_chart']=$userArr;
        
        
        $data['setting'] = Setting::where('id','1')->first();
        return view('dashboard',$data);
    }
    
    public function formatPrice( $n, $precision = 1 ) 
    {
        if ($n < 900) {
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        return $n_format . $suffix;
    }

}
