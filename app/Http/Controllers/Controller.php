<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Posts;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Section;
use App\Models\UserBusiness;
use App\Models\User;
use App\Models\VideoCategory;
use App\Models\GreetingSection;
use App\Models\Greeting;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Video;
use App\Models\FrameCategory;
use App\Models\UserFrame;
use App\Models\Frame;
use App\Models\UserPost;
use App\Models\StickerCategory;
use App\Models\OfferDialog;
use App\Models\Promocode;
use App\Models\Contact;
use App\Models\Music;
use App\Models\MusicCategory;
use App\Models\BusinessCardTamplate;
use App\Models\BusinessCardDigital;
use App\Models\Services;
use App\Models\ServiceInquiries;
use App\Models\Withdraw;
use App\Models\InvitationCategory;
use App\Models\InvitationCard;
use App\Models\PaytmChecksum;
use App\Models\UserTransaction;
use App\Models\SubCategory;
use App\Models\LogoCategory;
use App\Models\Background;

use App\Models\VideoTamplate;
use App\Models\VideoTamplateCategory;

use Illuminate\Support\Facades\Storage;
use PDF;
use File;

class Controller extends BaseController

{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    function getAllSettings(){
        return Setting::get();
    }
    
    function getLanguage(){
        return Language::where('status','0')->get();
    }
    
    function whatsappOtp(Request $request){
        
        $number = $request->get('number');
        $otp = random_int(100000, 999999);

       
        $data['apikey'] = Setting::getValue('whatsapp_api_key');
        $data['instance'] = Setting::getValue('whatsapp_instance_id');
        
        $data['msg'] = "<#>".$otp." is your one time password to proceed on ".Setting::getValue('app_name')." ";
        $url = "https://app.wapify.net/api/text-message.php";
        
        $data['number'] = $number;
    
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
        
        // $result = json_decode($result,true);
        // if($result['error'] == false){
            $out['code'] = 200;
            $out['message'] = "Success";
            $out['otp'] = $otp;
        // }else{
        //     $out['code'] = 201;
        //     $out['message'] = "Faild to send otp";
        //     $out['otp'] = "";
        // }
        
        return response()->json($out);
    }
    
    function getVideoTamplates(Request $request){
        $category = $request->get('category');
        $videos = VideoTamplate::where('status','0');
        
        if($category != ""){
            $videos->where('category_id',$category);
        }
        
        $out = $videos->latest()->get();
        return response()->json($out);
    }
    
    function getMusicbyCategory(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['musiccategories'] = MusicCategory::with('musics')->where('status','0')->orderBy('orders','ASC')->get();
        return response()->json($out);
    }
    
    function getInvitationCategories(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['invitationcategories'] = InvitationCategory::with('invitationcards')->where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function getInvitationCardsByCatId(Request $request){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['customTamplates'] = InvitationCard::where('category_id',$request->get('category'))->where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function getServices(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['services'] = Services::where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    
    function getBackgrounds(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['backgrounds'] = Background::orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function getUserCategory(Request $request){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['usercategory'] = Category::find($request->get('category_id'));
        return response()->json($out);
    }
    
    
    function getUserTransactionList(Request $request){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['transactionlist'] = UserTransaction::where('user_id',$request->get('user_id'))->orderBy('id','DESC')->get();
        return response()->json($out);
    }
    
    function getUserWithdrawList(Request $request){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['balance'] = User::find($request->get('user_id'))->balance;
        $out['total_withdraw'] = Withdraw::where('user_id',$request->get('user_id'))->sum('amount');
        $out['withdrawlist'] = Withdraw::where('user_id',$request->get('user_id'))->orderBy('id','DESC')->get();
        return response()->json($out);
    }
    
    function withdrawRequest(Request $request){
        
        $user = User::find($request->get('user_id'));
        $upi= $request->get('upi');
        if($user){
            $withdraw = new Withdraw();
            $withdraw->user_id = $user->id;
            $withdraw->amount = $user->balance;
            $withdraw->upi_id = $upi;
            $withdraw->status = "pending";
            $withdraw->save();
            
            $userTrans = new UserTransaction();
            $userTrans->user_id = $user->id;
            $userTrans->other_user_id = 0;
            $userTrans->title = "Withdraw Amount";
            $userTrans->amount = $user->balance;
            $userTrans->type = "debit";
            $userTrans->save();
                
            $user->balance = 0;
            $user->save();
            
            $out['message'] = "Withdraw Success";
        }else{
            $out['message'] = "Withdraw faild";
        }
        
        $out['code'] = 200;
        return response()->json($out);
    }
    
    function getUserInviteList(Request $request){
        $user = User::find($request->get('user_id'));
        if($user){
            $out['code'] = 200;
            $out['message'] = "Success";
            $out['userslist'] = User::where('refered',$user->refer_id)->orderBy('id','DESC')->get();
        }else{
            $out['code'] = 201;
            $out['message'] = "No user found";
            $out['userslist'] = array();
        }
        
        return response()->json($out);
    }
    
    function getBusinessCards(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['businesscarddigital'] = BusinessCardDigital::where('status','0')->get();
        $out['businesscardtamplate'] = BusinessCardTamplate::where('status','0')->get();
        return response()->json($out);
    }
    
    function getDailyPosts(Request $request){
        
        $page = $request->get("page");
        
        $languages = "";
        
        if($request->get("language") != ""){
            $languages = json_decode($request->get("language"),true);
        }else{
            $languages = Language::select('language_code')->where('status','0')->get();
        }
        
        $posts = Posts::whereIn('language',$languages)->where('status','0');
        
        if($request->get("search") == 'daily'){
            $today_event = Category::select('id')->where('event_date',date('Y-m-d',strtotime('today')))->get();
            $posts->whereIn('category_id',$today_event);
        }else{
            $posts->where('category_id',$request->get("search"));
        }
        
        
        $posts->skip($page*20)->take(20);
        $out['daily_post'] = $posts->inRandomOrder()->get();
        $out['custom_category'] = Category::where('type','custom')->where('status','0')->orderBy('name','ASC')->get();
        
        return response()->json($out);
        
    }
    
    
    
    function getHomeData(Request $request){
        
        $languages = "";
        if($request->get("language") != ""){
            $languages = json_decode($request->get("language"),true);
        }else{
            $languages = Language::select('language_code')->where('status','0')->get();
        }
        
        $out['code'] = 200;
        $out['message'] = "Success";
        
        $out['slider'] = Slider::where('status','0')->get();
        
        $offerdialog = OfferDialog::where('status','0')->inRandomOrder()->take(1)->get();
        if(count($offerdialog) > 0){
            $out['offerdialog'] = $offerdialog[0];
        }
        

        $user = User::find($request->get('user_id'));
        $category = $user->category_id;
        if($request->get("category") != ""){
            $category = $request->get("category");
        }
        
        if($user){
            $out['foryou'] = Posts::whereIn('language',$languages)->where('status','0')->where('category_id',$category)->inRandomOrder()->take(7)->get();
        }
        
        $out['section'] = Section::with(array('posts'=>function($query){
                $query->inRandomOrder()->limit(7);
            }))->where('status','0')->orderBy('orders',"ASC")->get();
        
        $out['video_tamplate_category'] = VideoTamplateCategory::with(array('videos'=>function($query){
                 $query->latest()->limit(1);
            }))->where('status','0')->orderBy('orders',"ASC")->get();
        
        $out['upcoming_event'] = Category::whereBetween('event_date',[date('Y-m-d',strtotime('today')),date('Y-m-d',strtotime('+7 days'))])->where('status','0')->orderBy('event_date','ASC')->get();
        $out['customTamplateCategory'] = InvitationCategory::where('status','0')->inRandomOrder()->get();
        $out['festival_category'] = Category::where('type','festival')->where('status','0')->orderBy('name','ASC')->take(8)->get();
        $out['business_category'] = Category::where('type','business')->where('status','0')->orderBy('name','ASC')->take(9)->get();
        $out['political_category'] = Category::where('type','political')->where('status','0')->orderBy('name','ASC')->take(12)->get();
        $out['custom_category'] = Category::where('type','custom')->where('status','0')->orderBy('name','ASC')->take(12)->get();
        $out['daily_post'] = Posts::whereIn('language',$languages)->where('type','custom')->where('status','0')->take(6)->inRandomOrder()->get();
        $out['recent'] = Posts::whereIn('language',$languages)->where('status','0')->orderBy('id','DESC')->take(12)->get();
        return response()->json($out);
    }
    
    
    function getBusinessPoliticalCategory(Request $request){
        $category = Category::where('type','!=','festival')->where('type','!=','custom')->where('status','0');
        if($request->search != ""){
            $category->where('name','like',"%".$request->search."%");
        }
        if($request->type != "" && $request->type != "all"){
            $category->where('type',$request->type);
        }
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['business_political_category'] = $category->get();
        return response()->json($out);
    }
    
    
    function getVideoCategoryData(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['upcoming_event'] = VideoCategory::whereBetween('event_date',[date('Y-m-d',strtotime('today')),date('Y-m-d',strtotime('+7 days'))])->where('status','0')->get();
        $out['festival_category'] = VideoCategory::where('type','festival')->where('status','0')->get();
        $out['business_category'] = VideoCategory::where('type','business')->where('status','0')->get();
        $out['custom_category'] = VideoCategory::where('type','custom')->where('status','0')->get();
        return response()->json($out);
    }
    
    function getGreetingData(Request $request){
        
        $languages = "";
        $page = $request->get("page");
        $search = $request->get('search');
        
        if($request->get("language") != ""){
            $languages = json_decode($request->get("language"),true);
        }else{
            $languages = Language::select('language_code')->where('status','0')->get();
        }
        
        $posts = GreetingSection::with(array('posts'=>function($query){
                $query->where('status','0');
                $query->latest()->limit(7);
            }))->where('status','0');
        
        if($search != ""){
            $posts->where('name','like',"%".$search."%");
        }else{
            $posts->orderBy('orders',"ASC")->skip($page*5)->take(5);
        }
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['greeting_section'] = $posts->get();
        return response()->json($out);
    }
    
    function getFrames(Request $request){
        $CategoryList = FrameCategory::where('status','0')->orderBy('id',"DESC")->get();
        foreach ($CategoryList as $key => $framec){
            $frameList = Frame::where('category_id',$framec->id)->where('ratio',$request->get('ratio'))->where('status','0')->get();
            $CategoryList[$key]['frames'] = $frameList;
        }
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['framecategories'] = $CategoryList;
        return response()->json($out);
    }
    
    function getFramesByType(Request $request){
       
        
        $out['frames'] = Frame::where('type',$request->get('type'))->where('ratio',$request->get('ratio'))->where('status','0')->inRandomOrder()->get();
        $out['userframes'] = UserFrame::where('user_id',$request->get('user_id'))->where('status','0')->inRandomOrder()->get();
        
        $out['code'] = 200;
        $out['message'] = "Success";
        return response()->json($out);
    }
    
    function getStickerbyCategory(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['stickercategory'] = StickerCategory::with('stickers')->where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function getLogosbyCategory(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['logoscategory'] = LogoCategory::with('logos')->where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function showFrameView($id){
        $data['data'] = Frame::find($id);
        return view('frame.show',$data);
    }
    
    
    function cheakPromocode(Request $request){
        
        $code = $request->get('code');
        $promo = Promocode::where('code',$code)->where('status','0')->first();
        if($promo){
            $total = Transaction::where('promocode',$code)->count();
            if($total >= $promo->total_use){
                $out['code'] = 201;
                $out['message'] = "Promocode Limit Reached";
                return response()->json($out);
            }else{
                $out['code'] = 200;
                $out['message'] = "Applied";
                $out['promocode'] = $promo;
                return response()->json($out);
            }
        }else{
            $out['code'] = 201;
            $out['message'] = "Invalid Promocode";
            return response()->json($out);
        }
    }
    
    
    function getUserFrames(Request $request){
        $user_id = $request->get('user_id');
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['userframes'] = UserFrame::where('user_id',$user_id)->where('status','0')->orderBy('id',"DESC")->get();
        
        return response()->json($out);
    }
    
    function getPremiumPostsbyCategory($type){
        $out['code'] = 200;
        $out['message'] = "Success";
        if($type == "video"){
            $out['categories'] = VideoCategory::with('premiumposts')->where('status','0')->inRandomOrder()->get();
        }else{
            $out['categories'] = Category::with('premiumposts')->where('type',$type)->where('status','0')->inRandomOrder()->get();
        }
        return response()->json($out);
    }
    
    function getCategoriesbyPage(Request $request){
        $page = $request->get('page');
        $type = $request->get('type');
        $search = $request->get('search');
        
        $categories = Category::where('status','0');
        
        if($type != ""){
            $categories->where('type',$type);
        }
        
        if($search != ""){
            $categories->where('name','like',"%".$search."%");
        }
        
        if($search == ""){
            $categories->skip($page*20)->take(20);
        }
        
        if($type == "festival"){
            $categories->orderBy('updated_at','DESC');
        }else{
            $categories->orderBy('id','DESC');
        }
        
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['categories'] = $categories->get();
        return response()->json($out);
    }
    
    function getSearchSuggestion(Request $request){
        $out = array();
        if($request->get('search') != ""){
            $categories = Category::select('name')->where('name','like',"%".$request->get('search')."%")->get();
            foreach ($categories as $category){
                $out[]=$category['name'];
            }
        }
        return response()->json($out);
    }
    
    function getVideoTamplateCategoriesBypage(Request $request){
        $page = $request->get('page');
        $type = $request->get('type');
        $search = $request->get('search');
        
        $categories = VideoTamplateCategory::with(array('videos'=>function($query){
                 $query->latest()->limit(1);
            }))->where('status','0');
        
        if($type != ""){
            $categories->where('type',$type);
        }
        
        if($search != ""){
            $categories->where('name','like',"%".$search."%");
        }
        
        if($search == ""){
            $categories->skip($page*20)->take(20);
        }
        
        $categories->orderBy('id','DESC');
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['video_tamplate_category'] = $categories->get();
        return response()->json($out);
    }
    
    function addContact(Request $request){
        $user_id = $request->get('user_id');
        $number = $request->get('number');
        $message = $request->get('message');
        
        $contact = new Contact();
        $contact->user_id = $user_id;
        $contact->number = $number;
        $contact->message = $message;
        
        $contact->save();
        return response()->json([
            'code' => 200,
            'message' => "Message Send Successfully"
        ]);
    }
    
    function addInquiry(Request $request){
        $user_id = $request->get('user_id');
        $service_id = $request->get('service_id');
        $number = $request->get('number');
        $message = $request->get('message');
        
        $contact = new ServiceInquiries();
        $contact->user_id = $user_id;
        $contact->service_id = $service_id;
        $contact->number = $number;
        $contact->message = $message;
        
        $contact->save();
        return response()->json([
            'code' => 200,
            'message' => "Inquiry Submit Successfully"
        ]);
    }
    
    function getPostsbyPage(Request $request){
        $page = $request->get('page');
        $type = $request->get('type');
        $post_type = $request->get('post_type');
        $item_id = $request->get('item_id');
        $search = $request->get('search');
        $subcategory = $request->get('subcategory');
        $postid = $request->get('postid');
        
        $languages = "";
        if($request->get("language") != ""){
            $languages = json_decode($request->get("language"),true);
        }else{
            $languages = Language::select('language_code')->where('status','0')->get();
        }
        
        if($post_type == "video"){
            $posts = Video::where('status','0');
        }else if($post_type == "greeting"){
            $posts = Greeting::where('status','0');
        }else {
            $posts = Posts::where('status','0');
        }
        
        if($subcategory != ''){
            $posts->where('sub_category_id',$subcategory);
        }
        
        if($type == "category"){
            $posts->where('category_id',$item_id);
            $out['subcategories'] = SubCategory::where('category_id',$item_id)->where('status','0')->get();
        }
        
        if($postid != "" && $post_type != "greeting"){
            $p = Posts::find($postid);
            $out['subcategories'] = SubCategory::where('category_id',$p->category_id)->where('status','0')->get();
        }else{
            $out['subcategories'] = array();
        }
        
        if($languages != ""){
            $posts->whereIn('language',$languages);
        }
        
        if($type == "section"){
            $posts->where('section_id',$item_id);
        }
        
        if($search != ""){
            $posts->where('title','like',"%".$search."%");
        }
        
        if($search == ""){
            $posts->skip($page*20)->take(20);
        }
        
        $posts->orderBy('id','DESC');
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['posts'] = $posts->get();
        
        return response()->json($out);
    }
    
    function updatePostViews(Request $request){
        $id = $request->get('id');
        $type = $request->get('type');
        
        if($type == "video"){
            $posts = Video::find($id);
        }else if($type == "greeting"){
            $posts = Greeting::find($id);
        }else {
            $posts = Posts::find($id);
        }
        
        $posts->views = $posts->views+1;
        $posts->save();
        $out['code'] = 200;
        $out['message'] = "Success";
        return response()->json($out);
    }
    
    function getSubscriptionPlan(){
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['subscriptions'] = Subscription::where('status','0')->orderBy('id',"DESC")->get();
        return response()->json($out);
    }
    
    function offlineSuscription(Request $request){
        
        $user_id = $request->get('user_id');
        $subs_id = $request->get('subscription_id');
        $promocode = $request->get('promocode');
        $type = $request->get('type');
        $amount = $request->get('amount');
        
        if ($request->file("image")) {
            if ($request->file("image") && $request->file('image')->isValid()) {
                $image = $request->file("image");
                
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                $image->move('uploads/profile', $fileName);
                $item_url = 'uploads/profile/'.$fileName;
                
                $subs = Subscription::find($subs_id);
                $trans = new Transaction();
                
                $trans = new Transaction();
                $trans->user_id = $user_id;
                $trans->plan = $subs->name;
                $trans->amount = $amount;
                $trans->promocode = $promocode;
                $trans->payment_type = $type;
                $trans->status = "pending";
                $trans->receipt = $item_url;
                $trans->transaction_id = "Offline";
                $trans->save();
                
                return response()->json([
                    'code' => 200,
                    'message' => "We have received your request, action will be taken soon.",
                ]);
            }
        }else{
            return response()->json([
                'code' => 201,
                'message' => "No file found",
                'user' => ""
            ]);
        }
    }
    
    
    function updateDeviceToken(Request $request){
        $user_id = $request->get('user_id');
        $token = $request->get('token');
        
        $user = User::find($user_id);
        $user->device_token = $token;
        $user->save();
        
        return response()->json([
                'code' => 200,
                'message' => "Update Success",
                'user' => $user
            ]);
    }
    
    function updateUserSubscription(Request $request){
        $user_id = $request->get('user_id');
        $subs_id = $request->get('subscription_id');
        $transaction_id = $request->get('transaction_id');
        $promocode = $request->get('promocode');
        $type = $request->get('type');
        $amount = $request->get('amount');
        
        $user = User::find($user_id);
        $subs = Subscription::find($subs_id);
        
        if($user && $subs){
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime($subs->value." ".$subs->type));
            
            if($user->refered != null){
                $refer_user = User::where('refer_id',$user->refered)->first();
                $percentage = Setting::getValue('refer_subscription_bonus');
                $uamount = ($percentage / 100) * $amount;
                $refer_user->balance = $refer_user->balance + $uamount;
                $refer_user->save();
                
                $userTrans = new UserTransaction();
                $userTrans->user_id = $refer_user->id;
                $userTrans->other_user_id = $user->id;
                $userTrans->title = "Subscription Bonus By ".$user->name;
                $userTrans->amount = $amount;
                $userTrans->type = "credit";
                $userTrans->save();
            }
            
            $user->subscription_name = $subs->name;
            $user->subscription_price = $amount;
            $user->subscription_date = $start_date;
            $user->subscription_end_date = $end_date;
            
            $user->posts_limit = $user->posts_limit+$subs->posts_limit;
            $user->business_limit = $subs->business_limit;
            $user->political_limit = $subs->political_limit;
            
            $user->save();
            
            $trans = new Transaction();
            $trans->user_id = $user_id;
            $trans->plan = $subs->name;
            $trans->amount = $amount;
            $trans->promocode = $promocode;
            $trans->payment_type = $type;
            $trans->transaction_id = $transaction_id;
            $trans->save();
            
            return response()->json([
                'code' => 200,
                'message' => "Subscription has been applied Successfully",
                'user' => $user
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'message' => "Faild to upadte",
                'user' => $user
            ]);
        }
    }
    
    
    
    function loginUser(Request $request){
        
        
        $allusers = User::where('login',null)->get();
        foreach ($allusers as $alluser){
            $edit = User::find($alluser->id);
            if($alluser->social == "google"){
                $edit->login = $alluser->email;
            }else{
                $edit->login = $alluser->number;
            }
            $edit->save();
        }
        
        $social = $request->get('social');
        $social_id = $request->get('social_id');
        $auth_token = $request->get('auth_token');
        $device_token = $request->get('device_token');
        $name = $request->get('name');
        $email = $request->get('email');
        $number = $request->get('number');
        $profile_pic = $request->get('profile_pic');
        $login = '';
        $user = array();
        if($social == "phone"){
            $user = User::where('login',$number)->where('social','phone')->first();
            $login = $number;
        }elseif ($social == "whatsapp") {
            $user = User::where('login',$number)->where('social','whatsapp')->first();
            $login = $number;
        }elseif ($social == "google") {
            $user = User::where('login',$email)->where('social','google')->first();
            $login = $email;
        }elseif ($social == "facebook") {
            $user = User::where('login',$email)->first();
            $login = $email;
        }else{
            $user = User::where('login',$email)->first();
            $login = $email;
        }
        
        if($user){
            return response()->json([
                'code' => 200,
                'message' => "Login Successfull",
                'user' => $user
            ]);
        }else{
            
            $referCode = $this->createRandomPassword();
            
            $user = new User();
            $user->name = $name;
            $user->profile_pic = $profile_pic;
            $user->email = $email;
            $user->number = $number;
            $user->login = $login;
            $user->social = $social;
            $user->social_id = $social_id;
            $user->auth_token = $auth_token;
            $user->device_token = $device_token;
            $user->refer_id = $referCode;
            $user->save();
            return response()->json([
                'code' => 200,
                'message' => "Register Successfull",
                'user' => $user
            ]);
        }
    }
    
    function cheakReferCode(Request $request){
        $user = User::where('refer_id',$request->get('code'))->first();
        return response()->json([
            'code' => 200,
            'message' => "Success",
            'user' => $user
        ]);
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
    
    function updateProfile(Request $request){
        $user = User::find($request->get('user_id'));
        if ($user) {
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->number = $request->get('number');
            $user->state = $request->get('state');
            $user->district = $request->get('district');
            $user->designation = $request->get('designation');
            
            $user->category_id = $request->get('category');
            
            
            if($request->get('refer_code') != ""){
                $user->refered = $request->get('refer_code');
                $refer_user = User::where('refer_id',$request->get('refer_code'))->first();
                if($refer_user){
                    $refer_user->balance = ($refer_user->balance +  Setting::getValue('refer_bonus'));
                    $refer_user->save();
                    
                    $userTrans = new UserTransaction();
                    $userTrans->user_id = $refer_user->id;
                    $userTrans->other_user_id = $user->id;
                    $userTrans->title = $user->name." Join by your refer code ";
                    $userTrans->amount = Setting::getValue('refer_bonus');
                    $userTrans->type = "credit";
                    $userTrans->save();
                
                }
            }
            $user->save();
            return response()->json([
                'code' => 200,
                'message' => "Successfull",
                'user' => $user
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no file found",
                'user' => $user
            ]);
        }
    }
    function updateProfilePicture(Request $request){
        
        $user = User::find($request->get('user_id'));
        
        if ($user && $request->file("image")) {
            if ($request->file("image") && $request->file('image')->isValid()) {
                $image = $request->file("image");
                
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                $image->move('uploads/profile', $fileName);
                $item_url = 'uploads/profile/'.$fileName;
                
                $user->profile_pic = $item_url;
                $user->save();
                
                return response()->json([
                    'code' => 200,
                    'message' => "Successfull",
                    'user' => $user
                ]);
            }
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no file found",
                'user' => $user
            ]);
        }
    }
    
    
    function getUserPosts(Request $request){
        
        $user = User::find($request->get('user_id'));
        
        if ($user) {
            
            $userpost = UserPost::where('user_id',$user->id)->orderBy('id','DESC')->get();
            
            return response()->json([
                'code' => 200,
                'message' => "Successfull",
                'userposts' => $userpost
            ]);
            
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no user found",
                'userposts' => []
            ]);
        }
    }
    function uploadUserPost(Request $request){
        
        $user = User::find($request->get('user_id'));
        
        if ($user) {
            if ($request->file("image") && $request->file('image')->isValid()) {
                
                $image = $request->file("image");
                
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                $image->move('uploads/profile', $fileName);
                $item_url = 'uploads/profile/'.$fileName;
            }else{
                $video = $request->file("video");
                $extension = $video->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                $video->move('uploads/profile', $fileName);
                $item_url = 'uploads/profile/'.$fileName;
            }
            
            $user->posts_limit = $user->posts_limit-1;
            $user->save();
            
            $userpost = new UserPost();
            $userpost->user_id = $request->get('user_id');
            $userpost->post_url = $item_url;
            $userpost->save();
            
            return response()->json([
                'code' => 200,
                'message' => "Successfull",
                'user' => $user
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no user found",
                'user' => $user
            ]);
        }
    }
    
    function geUserProfile(Request $request){
        
        $user = User::find($request->get('user_id'));
        if ($user) {
            if($user->status == 0){
                return response()->json([
                    'code' => 200,
                    'message' => "Success",
                    'user' => $user
                ]);
            }else{
                return response()->json([
                    'code' => 201,
                    'message' => "Your Account Blocked By Admin",
                    'user' => ''
                ]);
            }
        }else{
            return response()->json([
                'code' => 201,
                'message' => "Invalid user",
                'user' => $user
            ]);
        }
    }
    
    function getUserBusiness(Request $request){
        $user = User::find($request->get('user_id'));
        if ($user) {
            if($user->status == 0){
                
                return response()->json([
                    'code' => 200,
                    'message' => "Success",
                    'businesses' => UserBusiness::with('category')->where('user_id',$user->id)->where('type',$request->get('type'))->get()
                ]);
            }else{
                return response()->json([
                    'code' => 201,
                    'message' => "Your Account Blocked By Admin",
                    'businesses' => ''
                ]);
            }
        }else{
            return response()->json([
                'code' => 201,
                'message' => "Invalid user",
                'businesses' => ''
            ]);
        }
    }
    
    function getUserBusinessDetail(Request $request){
        $business = UserBusiness::find($request->get('id'));
        if ($business) {
            return response()->json([
                'code' => 200,
                'message' => "Success",
                'business' =>$business
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no business found",
                'business' => ''
            ]);
        }
    }
    
    function deleteBusiness(Request $request){
        $business = UserBusiness::find($request->get('id'));
        if ($business) {
            @unlink($business->image);
            $business->delete();
            return response()->json([
                'code' => 200,
                'message' => "Delete Successfully"
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no business found",
                'business' => ''
            ]);
        }
    }
    
    function addUserBusiness(Request $request){
        $user = User::find($request->get('user_id'));
        if ($user) {
            if($user->status == 0){
                
                $business = null;
                if($request->get('id') != ""){
                    $business = UserBusiness::find($request->get('id'));
                }
                
                if(!$business){
                    $business = new UserBusiness();
                }
                
                
                if($request->file("image") && $request->file('image')->isValid()){
                    
                    $image = $request->file("image");
                
                    $extension = $image->getClientOriginalExtension();
                    $fileName = Str::uuid() . '.' . $extension;
                    $image->move('uploads/profile', $fileName);
                    $item_url = 'uploads/profile/'.$fileName;
                    
                    @unlink($business->image);
                    $business->image = $item_url;
                    
                }
                
                $business->user_id = $request->get('user_id');
                $business->company = $request->get('company');
                $business->name = $request->get('name');
                $business->about = $request->get('about');
                $business->number = $request->get('number');
                $business->designation = $request->get('designation');
                $business->address = $request->get('address');
                $business->email = $request->get('email');
                $business->category_id = $request->get('category_id');
                $business->website = $request->get('website');
                $business->whatsapp = $request->get('whatsapp');
                $business->facebook = $request->get('facebook');
                $business->twitter = $request->get('twitter');
                $business->youtube = $request->get('youtube');
                $business->instagram = $request->get('instagram');
                $business->type = $request->get('type');
                $business->save();
                
                $business['category'] = Category::find($business->category_id);
                
                return response()->json([
                    'code' => 200,
                    'message' => "Bussiness Saved Successfully",
                    'business' => $business,
                ]);
            }else{
                return response()->json([
                    'code' => 201,
                    'message' => "Your Account Blocked By Admin",
                    'business' => ''
                ]);
            }
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no user found",
                'business' => ''
            ]);
        }
    }
    
    function createUserBusinessCard(Request $request){
        $card = BusinessCardDigital::find($request->get('card_id'));
        $business = UserBusiness::find($request->get('business_id'));
        if($business){
            
            $customPaper = array(0,0,660,439);
            $pdf = PDF::loadView('cardtamplate.'.$card->blade_name,$business->toArray())->setPaper($customPaper, 'landscape');
            $random = Str::random(10);
            
            
            $path = public_path().'/uploads/pdf/';
            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            
            file_put_contents("uploads/pdf/".$random.".pdf", $pdf->output());
            
            return response()->json([
                'code' => 200,
                'message' => asset('uploads/pdf/'.$random.".pdf"),
            ]);
        
        }else{
            return response()->json([
                'code' => 201,
                'message' => "no business found"
            ]);
        }
    }
    
    function paytmPayment(Request $request){
        
        $order_id = $request->get("order_id");
        $cust_id = $request->get("cust_id");
        $amount = $request->get("amount");
        
        $paytmParams = array();
            
        $callback_url = "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=".$order_id;
        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => Setting::getValue('paytm_merchant_id'),
            "websiteName"   => "Hello",
            "orderId"       => $order_id,
            "callbackUrl"   => $callback_url,
            "txnAmount"     => array(
                "value"     => $amount,
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => 1,
            ),
        );

        $paytm_checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES),Setting::getValue('paytm_merchant_key'));

        $paytmParams["head"] = array(
            "signature"    => $paytm_checksum
        );
            
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
        
        $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".Setting::getValue('paytm_merchant_id')."&orderId=".$order_id;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = json_decode(curl_exec($ch),true);
        
        if($response['body']['resultInfo']['resultStatus'] == "S")
        {
            return response()->json([
                'code' => 200,
                'message' => "Data Retrived Successfully...!",
                'signature' => $response['body']['txnToken'],
                'callback_url' => $callback_url
            ]);
        }
        else
        {
            return response()->json([
                'code' => 201,
                'message' => "Invalid Access Key"
            ]);
        }
        
    }
    
    function verifyPaytmPayment(Request $request){
        $order_id = $request->get("order_id");
        $paytmParams["body"] = array(
            "mid" => Setting::getValue('paytm_merchant_id'),
            "orderId" => $order_id,
        );
        
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), Setting::getValue('paytm_merchant_key'));
        $paytmParams["head"] = array(
            /* put generated checksum value here */
            "signature"    => $checksum
        );
    
        /* prepare JSON string for request */
        $post_data = json_encode($paytmParams);
        $url = "https://securegw.paytm.in/v3/order/status";
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        $response = json_decode(curl_exec($ch),true);
        return response()->json([
            'code' => 200,
            'message' => "Success",
            'response' => $response['body']['resultInfo']['resultStatus']
        ]);
    
    }
    
    function cashfreePayment(Request $request){
        $order_id = $request->get("order_id");
        $amount = $request->get("amount");
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://test.cashfree.com/api/v2/cftoken/order',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "orderId": "'.$order_id.'",
          "orderAmount":'.$amount.',
          "orderCurrency": "INR"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-client-id: '.Setting::getValue('cashfree_client_id'),
            'x-client-secret: '.Setting::getValue('cashfree_client_secret')
          ),
        ));
        
        $response = json_decode(curl_exec($curl),true);
        curl_close($curl);
        
        return response()->json([
            'code' => 200,
            'message' => "Success",
            'response' => $response['cftoken']
        ]);
    }
    
    function createStripePayment(Request $request){
        
        $amount = $request->get("amount");
        $user_id = $request->get("user_id");
        
        try {
            $stripe = new \Stripe\StripeClient(Setting::getValue('stripe_secret_key'));

            $customer = $stripe->customers->create();

            $ephemeralKey = $stripe->ephemeralKeys->create([
            'customer' => $customer->id,
            ], [
            'stripe_version' => '2022-08-01',
            ]);

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $request->amount*100,
                'currency' => Setting::getValue('currency'),
                'customer' => $customer->id,
                'automatic_payment_methods' => [
                    'enabled' => 'true',
                ],
            ]);
            
            $data = [
                'code' => 200,
                'message' => "Success",
                'publishableKey' => Setting::getValue('stripe_public_key'),
                'clientSecret' => $paymentIntent->client_secret,
                'ephemeralKey' => $ephemeralKey->secret,
                'customer' => $customer->id,
            ];
            
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error_msg = $e->getError()->message;
            $data = [
                'code' => 201,
                'message' => json_encode($error_msg)
            ];
        }
        
        
        return response()->json($data);
    }

}
