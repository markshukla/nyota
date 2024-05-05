<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    function index(){
        
        $data['setting'] = Setting::where('id','1')->first();
        return view('setting.index',$data);
        
    }
    
    function updateAppSetting(Request $request){
        
        $validatedData = $request->validate([
             'app_logo' => 'nullable|mimes:jpg,png,jpeg',
             'company_logo' => 'nullable|mimes:jpg,png,jpeg',
             'share_image' => 'nullable|mimes:jpg,png,jpeg',
             'app_name' => 'required',
             'company_name' => 'required',
             'contact_number' => 'required',
             'contact_email' => 'required',
             'currency' => 'required',
             'timezone' => 'required',
        ]);

        Setting::setValue('app_name',$request->get('app_name'));
        Setting::setValue('company_name',$request->get('company_name'));
        Setting::setValue('contact_number',$request->get('contact_number'));
        Setting::setValue('contact_email',$request->get('contact_email'));
        Setting::setValue('api_key',$request->get('api_key'));
        Setting::setValue('timezone',$request->get('timezone'));
        Setting::setValue('currency',$request->get('currency'));
        Setting::setValue('share_text',$request->get('share_text'));
        if ($request->file("app_logo") && $request->file('app_logo')->isValid()) {
            $image = $request->file("app_logo");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            // $path = $image->storeAs('public/uploads',$fileName);
            $image->move('uploads/', $fileName);
            $item_url = 'uploads/'.$fileName;
            
            @unlink(Setting::getValue('app_logo'));
            Setting::setValue('app_logo',$item_url);
        }
        if ($request->file("share_image") && $request->file('share_image')->isValid()) {
            $image = $request->file("share_image");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/', $fileName);
            $item_url = 'uploads/'.$fileName;
            
            @unlink(Setting::getValue('share_image_url'));
            Setting::setValue('share_image_url',$item_url);
        }
        if ($request->file("company_logo") && $request->file('company_logo')->isValid()) {
            $image = $request->file("company_logo");
            
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $thumbName = Str::uuid() . '.' .$extension;
            
            $image->move('uploads/', $fileName);
            $item_url = 'uploads/'.$fileName;
            
            @unlink(Setting::getValue('company_logo'));
            Setting::setValue('company_logo',$item_url);
        }
        return redirect()->back();
    }
    
    function updatePaymentSetting(Request $request){
        
        
        $validatedData = $request->validate([
             'razorpay_key' => 'required',
             'razorpay_secret' => 'required',
        ]);
        
        Setting::setValue('razorpay','false');
        Setting::setValue('paytm','false');
        Setting::setValue('stripe','false');
        Setting::setValue('instamojo','false');
        Setting::setValue('buy_singal_post','false');
        Setting::setValue('watch_and_remove_watermark','false');
        Setting::setValue('offline_payment','false');
        Setting::setValue('posts_limit_status','false');
        
        if(!empty($request->get('instamojo'))){
            Setting::setValue('instamojo','true');
        }
        if(!empty($request->get('posts_limit_status'))){
            Setting::setValue('posts_limit_status','true');
        }
        if(!empty($request->get('buy_singal_post'))){
            Setting::setValue('buy_singal_post','true');
        }
        if(!empty($request->get('watch_and_remove_watermark'))){
            Setting::setValue('watch_and_remove_watermark','true');
        }
        if(!empty($request->get('paytm'))){
            Setting::setValue('paytm','true');
        }
        if(!empty($request->get('razorpay'))){
            Setting::setValue('razorpay','true');
        }
        if(!empty($request->get('stripe'))){
            Setting::setValue('stripe','true');
        }
        if(!empty($request->get('offline_payment'))){
            Setting::setValue('offline_payment','true');
        }
        
        Setting::setValue('client_id',$request->get('client_id'));
        Setting::setValue('client_secret',$request->get('client_secret'));
        
        Setting::setValue('stripe_public_key',$request->get('stripe_public_key'));
        Setting::setValue('stripe_secret_key',$request->get('stripe_secret_key'));
        
        Setting::setValue('paytm_merchant_key',$request->get('paytm_merchant_key'));
        Setting::setValue('paytm_merchant_id',$request->get('paytm_merchant_id'));
        
        Setting::setValue('razorpay_key',$request->get('razorpay_key'));
        Setting::setValue('razorpay_secret',$request->get('razorpay_secret'));
        Setting::setValue('single_post_subsciption_amount',$request->get('single_post_subsciption_amount'));
        
        Setting::setValue('offline_details',$request->get('offline_details'));
        
        return redirect()->back();
    }
    
    function referEearnSetting(Request $request){
        
        
        $validatedData = $request->validate([
             'refer_bonus' => 'required',
             'min_withdraw' => 'required',
        ]);
        
        Setting::setValue('refer_earn','false');
        
        if(!empty($request->get('refer_earn'))){
            Setting::setValue('refer_earn','true');
        }
        
        Setting::setValue('refer_bonus',$request->get('refer_bonus'));
        Setting::setValue('min_withdraw',$request->get('min_withdraw'));
        
        return redirect()->back();
    }
    
    function privacytermsUpdateSetting(Request $request){
        
        
        $validatedData = $request->validate([
             'privacypolicy' => 'required',
             'terms_and_condition' => 'required',
        ]);
        
        Setting::setValue('privacypolicy',$request->get('privacypolicy'));
        Setting::setValue('terms_and_condition',$request->get('terms_and_condition'));
        
        return redirect()->back();
    }
    
    function updateAppUpdateSetting(Request $request){
        
        $validatedData = $request->validate([
             'app_version_code' => 'required',
             'app_link' => 'required',
             'update_information' => 'required',
        ]);
        
        if(!empty($request->get('show_update_dialog'))){
            Setting::setValue('show_update_dialog','true');
        }else{
            Setting::setValue('show_update_dialog','false');
        }
        if(!empty($request->get('force_update'))){
            Setting::setValue('force_update','true');
        }else{
            Setting::setValue('force_update','false');
        }
        
        Setting::setValue('app_version_code',$request->get('app_version_code'));
        Setting::setValue('app_link',$request->get('app_link'));
        Setting::setValue('update_information',$request->get('update_information'));
        
        return redirect()->back();
    }
    
    function updateNotificationSetting(Request $request){
        
        
        $validatedData = $request->validate([
             'onesignal_app_id' => 'required',
             'onesignal_key' => 'required',
        ]);
        
        if(!empty($request->get('auto_festival_notification'))){
            Setting::setValue('auto_festival_notification','true');
        }else{
            Setting::setValue('auto_festival_notification','false');
        }
        
        Setting::setValue('fcm_key',$request->get('fcm_key'));
        Setting::setValue('onesignal_key',$request->get('onesignal_key'));
        Setting::setValue('onesignal_app_id',$request->get('onesignal_app_id'));
        
        return redirect()->back();
    }
    
    function whatsappSetting(Request $request){
        
        
        $validatedData = $request->validate([
             'whatsapp_api_key' => 'required',
             'whatsapp_instance_key' => 'required',
        ]);
        Setting::setValue('whatsapp_otp','false');
        if(!empty($request->get('whatsapp_otp'))){
            Setting::setValue('whatsapp_otp','true');
        }
        
        Setting::setValue('whatsapp_api_key',$request->get('whatsapp_api_key'));
        Setting::setValue('whatsapp_instance_id',$request->get('whatsapp_instance_key'));
        
        return redirect()->back();
    }
    
    function updateStorageSetting(Request $request){
        if($request->get('storage_type') == "digitalOccean"){
            $validatedData = $request->validate([
                 'do_space_name' => 'required',
                 'do_key' => 'required',
                 'do_secret' => 'required',
                 'do_bucket_region' => 'required',
                 'do_end_point' => 'required',
            ]);
            
            Setting::setValue('storage_type',$request->get('storage_type'));
            
            $env = file_get_contents(base_path('.env'));
            $storageSetting = 
               'DO_SPACES_KEY="' . $request->get('do_key') . '"
                DO_SPACES_SECRET="' . $request->get('do_secret') . '"
                DO_SPACES_REGION="' . $request->get('do_bucket_region') . '"
                DO_SPACES_BUCKET="' . $request->get('do_space_name') . '"
                DO_SPACES_URL="' . $request->get('do_space_url') . '"
                DO_SPACES_ENDPOINT="' . $request->get('do_end_point') . '"
                ';

            $rows = explode("\n", $env);
            $unwanted = "DO_SPACES_KEY|DO_SPACES_SECRET|DO_SPACES_REGION|DO_SPACES_BUCKET|DO_SPACES_URL|DO_SPACES_ENDPOINT";
            $cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);
    
            $cleanString = implode("\n", $cleanArray);
    
            $newenv = $cleanString . $storageSetting;

            file_put_contents(base_path('.env'), $newenv);
            
        }else{
            Setting::setValue('storage_type',$request->get('storage_type'));
        }
        
        return redirect()->back();
    }

    function updateAdsSetting(Request $request){
        
        $validatedData = $request->validate([
             'publisher_id' => 'required',
             'admob_banner_id' => 'required',
             'admob_interstitial_ad' => 'required',
             'admob_rewarde_id' => 'required',
             'admob_native_id' => 'required',
        ]);
        
        if(!empty($request->get('show_ads'))){
            Setting::setValue('show_ads','true');
        }else{
            Setting::setValue('show_ads','false');
        }
        
        if(!empty($request->get('show_admob_banner'))){
            Setting::setValue('show_admob_banner','true');
        }else{
            Setting::setValue('show_admob_banner','false');
        }
        
        if(!empty($request->get('show_admob_interstital'))){
            Setting::setValue('show_admob_interstital','true');
        }else{
            Setting::setValue('show_admob_interstital','false');
        }
        
        if(!empty($request->get('show_admob_rewarded'))){
            Setting::setValue('show_admob_rewarded','true');
        }else{
            Setting::setValue('show_admob_rewarded','false');
        }
        
        if(!empty($request->get('show_admob_native'))){
            Setting::setValue('show_admob_native','true');
        }else{
            Setting::setValue('show_admob_native','false');
        }
        
        
        Setting::setValue('publisher_id',$request->get('publisher_id'));
        Setting::setValue('admob_banner_id',$request->get('admob_banner_id'));
        Setting::setValue('admob_interstitial_ad',$request->get('admob_interstitial_ad'));
        Setting::setValue('admob_rewarde_id',$request->get('admob_rewarde_id'));
        Setting::setValue('admob_native_id',$request->get('admob_native_id'));
        
        return redirect()->back();
    }
    
}
