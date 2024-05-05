<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\LiveChannelController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\GreetingSectionController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\StickerCategoryController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\FrameCategoryController;
use App\Http\Controllers\OfferDialogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserBusinessController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\BusinessCardTamplateController;
use App\Http\Controllers\BusinessCardDigitalController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\InvitationCategoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PoliticalController;
use App\Http\Controllers\MusicCategoryController;
use App\Http\Controllers\MusicController;
use App\Models\Setting;
use App\Http\Controllers\VideoTamplateCategoryController;
use App\Http\Controllers\VideoTamplateController;
use App\Http\Controllers\WhatsappMessageController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LogosController;
use App\Http\Controllers\LogoCategoryController;
use App\Http\Controllers\BackgroundController;

use App\Models\VideoTamplateCategory;
use App\Models\Section;
/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('login', [AdminController::class, 'goToLogin'])->name('login');
Route::get('logout', [AdminController::class, 'logout']);
Route::get('setup', [AdminController::class, 'setupView']);
Route::post('databasesetup', [AdminController::class, 'databaseSetup']);
Route::post('login', [AdminController::class, 'login']);

Route::group(['middleware' => "web"],function(){
    
    Route::get('/', [HomeController::class, 'index']);
    
    //Category
    Route::resource('category', CategoryController::class);
    Route::get('festivalCategory', [CategoryController::class,'festivalCategory']);
    Route::get('businessCategory', [CategoryController::class,'businessCategory']);
    Route::get('customCategory', [CategoryController::class,'customCategory']);
    Route::get('politicalCategory', [CategoryController::class,'politicalCategory']);
    Route::get('categorytype/{type}', [CategoryController::class,'filterby_type']);
    Route::post('category/search', [CategoryController::class,'searchCategory']);
    Route::post('category-status', [CategoryController::class,'category_status']);
    Route::get('get-category-by-type', [CategoryController::class,'getCategoryByType']);
    
    //Sub Category
    Route::resource('subcategory', SubCategoryController::class);
    Route::get('businessSubCategory', [SubCategoryController::class,'businessCategory']);
    Route::post('subcategory/search', [SubCategoryController::class,'searchCategory']);
    Route::post('subcategory-status', [SubCategoryController::class,'category_status']);
    
    Route::get('get-sub-category-by-id', [SubCategoryController::class,'subCategoryByCategoryId']);
    
    // All posts action handle
    Route::post('posts-action', [FestivalController::class,'posts_action']);
    
    // All posts status change
    Route::post('posts-premium-action', [FestivalController::class,'posts_premium_action']);
    Route::post('posts-status', [FestivalController::class,'posts_status']);
    Route::post('posts-remove-section', [FestivalController::class,'posts_remove_section']);
    
    //Festival Posts
    Route::resource('festival', FestivalController::class);
    Route::get('festivalCategory/{id}', [FestivalController::class,'filterby_category']);
    
    //political Posts
    Route::resource('political', PoliticalController::class);
    Route::get('politicalCategory/{id}', [PoliticalController::class,'filterby_category']);
    
    //Business Posts
    Route::resource('business', BusinessController::class);
    Route::get('businessCategory/{id}', [BusinessController::class,'filterby_category']);
    
    //Custom Posts
    Route::resource('custom', CustomController::class);
    Route::get('customCategory/{id}', [CustomController::class,'filterby_category']);
    
    //Greeting Posts
    Route::resource('greeting', GreetingController::class);
    Route::get('greetingSection/{id}', [GreetingController::class,'filterby_section']);
    Route::post('greeting-action', [GreetingController::class,'greeting_action']);
    Route::post('greeting-status', [GreetingController::class,'greeting_status']);
    Route::post('greeting-premium-action', [GreetingController::class,'greeting_premium_action']);
    
    //Greeting Section
    Route::resource('greetingsection', GreetingSectionController::class);
    Route::post('greeting-section-status',[GreetingSectionController::class,'greeting_section_status']);
    Route::post('greeting-section-order', [GreetingSectionController::class,'greeting_section_order']);
    
    //Video
    Route::resource('video', VideoController::class);
    Route::get('videotype/{type}', [VideoController::class,'filterby_type']);
    Route::post('video-action', [VideoController::class,'video_action']);
    Route::post('video-status', [VideoController::class,'video_status']);
    Route::post('video-premium-action', [VideoController::class,'video_premium_action']);
    
    //Music
    Route::resource('music', MusicController::class);
    Route::post('music-status', [MusicController::class,'music_status']);
    Route::post('music-premium-action', [MusicController::class,'premium_status']);
    Route::get('musicCategory/{$id}', [MusicController::class,'filterby_category']);
    
    Route::resource('musiccategory', MusicCategoryController::class);
    Route::post('music-category-status', [MusicCategoryController::class,'category_status']);
    Route::post('music-category-order', [MusicCategoryController::class,'category_order']);
    
    //Section
    Route::resource('section', SectionController::class);
    Route::post('section-status', [SectionController::class,'section_status']);
    Route::post('section-order', [SectionController::class,'section_order']);
    
    //Slider
    Route::resource('slider', SliderController::class);
    Route::post('slider-status', [SliderController::class,'slider_status']);
    
    //language
    Route::resource('language', LanguageController::class);
    Route::post('language-status', [LanguageController::class,'language_status']);
    
    //Stickers
    Route::resource('sticker', StickerController::class);
    Route::post('sticker-status', [StickerController::class,'sticker_status']);
    Route::get('stickerCategory/{id}', [StickerController::class,'filterby_category']);
    Route::post('sticker-action', [StickerController::class,'sticker_action']);
    Route::post('sticker-premium-action', [StickerController::class,'sticker_premium_action']);
    
    //Stickers Category
    Route::resource('stickercategory', StickerCategoryController::class);
    Route::post('stickercategory-status', [StickerCategoryController::class,'stickercategory_status']);
    
    //Logos
    Route::resource('logos', LogosController::class);
    Route::post('logos-status', [LogosController::class,'logos_status']);
    Route::get('logosCategory/{id}', [LogosController::class,'filterby_category']);
    Route::post('logos-action', [LogosController::class,'logos_action']);
    Route::post('logos-premium-action', [LogosController::class,'logos_premium_action']);
    
    //Stickers Category
    Route::resource('logocategory', LogoCategoryController::class);
    Route::post('logocategory-status', [LogoCategoryController::class,'logocategory_status']);
    
    //Video Tamplate
    Route::resource('videotamplate', VideoTamplateController::class);
    Route::post('video-tamplate-status', [VideoTamplateController::class,'video_status']);
    Route::post('video-tamplate-action', [VideoTamplateController::class,'video_action']);
    Route::post('video-tamplate-premium-action', [VideoTamplateController::class,'premium_action']);
    
    Route::get('videotamplatebytype/{type}', [VideoTamplateController::class,'filterby_type']);
    
    //Video Tamplate Category
    Route::resource('videotamplatecategory', VideoTamplateCategoryController::class);
    Route::post('videotamplatecategory-status', [VideoTamplateCategoryController::class,'tamplate_status']);
    Route::post('videotamplatecategory-premium-action', [VideoTamplateCategoryController::class,'Tamplate_premium_action']);
    
    //Business Card Tamplate
    Route::resource('businesscardtamplate', BusinessCardTamplateController::class);
    Route::post('bsns-tmplt-card-status', [BusinessCardTamplateController::class,'card_status']);
    Route::post('bsns-tmplt-premium-action', [BusinessCardTamplateController::class,'card_premium_action']);
    
    //Business Card Tamplate
    Route::resource('businesscarddigital', BusinessCardDigitalController::class);
    Route::post('bsns-digital-card-status', [BusinessCardDigitalController::class,'card_status']);
    Route::post('bsns-digital-premium-action', [BusinessCardDigitalController::class,'card_premium_action']);
    
    //Our Services
    Route::resource('ourservices', ServicesController::class);
    Route::post('ourservices-status', [ServicesController::class,'service_status']);
    Route::get('inquiries', [ServicesController::class,'service_inquiries']);
    Route::delete('inquiry/{id}', [ServicesController::class,'deleteInquiry']);
    
    
    //Invitaion
    Route::resource('invitationcard', InvitationController::class);
    Route::post('invitationcard-status', [InvitationController::class,'card_status']);
    Route::post('invitationcard-premium-action', [InvitationController::class,'card_premium_action']);
    
    //Invitation Category
    Route::resource('invitationcategory', InvitationCategoryController::class);
    Route::post('invitationcategory-status', [InvitationCategoryController::class,'category_status']);
    
    //Frame
    Route::resource('frame', FrameController::class);
    Route::post('frame-status', [FrameController::class,'frame_status']);
    Route::get('frameCategory/{id}', [FrameController::class,'filterby_category']);
    Route::post('frame-action', [FrameController::class,'frame_action']);
    Route::post('frame-premium-action', [FrameController::class,'frame_premium_action']);
    
    //Frame Category
    Route::resource('framecategory', FrameCategoryController::class);
    Route::post('framecategory-status', [FrameCategoryController::class,'framecategory_status']);
    
    //Offer Dialog
    Route::resource('offerdialog', OfferDialogController::class);
    Route::post('offerdialog-status', [OfferDialogController::class,'dialog_status']);
    
    //Notification
    Route::resource('pushnotification', NotificationController::class);
    Route::post('pushnotification-status', [NotificationController::class,'notification_status']);
    
    //Whatsapp Message
    Route::resource('whatsappmessage', WhatsappMessageController::class);
    Route::post('send-whatsapp-msg', [WhatsappMessageController::class,'sendWhatsappMessage']);
    Route::post('send-single-user-msg', [WhatsappMessageController::class,'sendSingleUserWhatsappMessage']);
    
    //Subscription
    Route::resource('subscription', SubscriptionController::class);
    Route::post('subscription-status', [SubscriptionController::class,'subscription_status']);
    Route::post('get-subscription-info', [SubscriptionController::class,'get_subscription_info']);
    
    Route::get('withdraws', [UserController::class,'withdrawList']);
    Route::post('withdraw-status', [UserController::class,'withdrawstatus']);
    Route::post('deletewithdraw', [UserController::class,'deletewithdraw']);
    
    //Contacts
    Route::resource('contacts', ContactController::class);
    
    //Transaction
    Route::resource('transaction', TransactionController::class);
    Route::post('complete-offline-payment', [TransactionController::class,"completeOfflinePayment"]);
    
    //Promocode
    Route::resource('promocode', PromocodeController::class);
    Route::post('promocode-status', [PromocodeController::class,'promocode_status']);
    
    //Users
    Route::resource('users', UserController::class);
    Route::post('users-status', [UserController::class,'users_status']);
    Route::post('user/search', [UserController::class,'search']);
    
    Route::post('users/plan', [UserController::class,'update_user_plan']);
    Route::post('deleteuserpost', [UserController::class,'deleteuserpost']);
    Route::post('deleteuserframe', [UserController::class,'deleteuserframe']);
    
    Route::post('users/addframe', [UserController::class,'add_user_frame']);
    Route::post('users/frame-status', [UserController::class,'change_frame_status']);
    Route::post('deleteuserbussines', [UserController::class,'deleteuserbussines']);
    
    Route::resource('usersbusiness', UserBusinessController::class);
    Route::get('users-add-business/{id}', [UserBusinessController::class,'addbusiness']);
    
    //App Setting
    Route::get('setting', [SettingController::class,'index']);
    Route::post('setting/app', [SettingController::class,'updateAppSetting']);
    Route::post('setting/referearn', [SettingController::class,'referEearnSetting']);
    Route::post('setting/payment', [SettingController::class,'updatePaymentSetting']);
    Route::post('setting/notification', [SettingController::class,'updateNotificationSetting']);
    Route::post('setting/ads', [SettingController::class,'updateAdsSetting']);
    Route::post('setting/storage', [SettingController::class,'updateStorageSetting']);
    Route::post('setting/appupdate', [SettingController::class,'updateAppUpdateSetting']);
    Route::post('setting/privacyterms', [SettingController::class,'privacytermsUpdateSetting']);
    Route::post('setting/whatsapp', [SettingController::class,'whatsappSetting']);
    
    //Payment 
    Route::get('/payment/instamojo', [PaymentController::class, 'createInstaMojoPayment']);
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess']);
    
    //Background
    Route::resource('backgrounds', BackgroundController::class);

    
    Route::get("test",function (){
        
        // $out['section'] = Section::with(array('posts'=>function($query){
        //         $query->inRandomOrder()->limit(7);
        //     }))->where('status','0')->orderBy('orders',"ASC")->get();
            
        $out['video_tamplate_category'] = VideoTamplateCategory::with(array('videos'=>function($query){
                 $query->inRandomOrder()->limit(1);
            }))->where('status','0')->orderBy('orders',"ASC")->get();
        return response()->json($out);
    });
    
    Route::get("cardview",function (){
        $data = [
            'image' => "https://cdn-icons-png.flaticon.com/512/124/124034.png",
            'name'    => "Hello Solution",
            'designation'    => "Designatio of my",
            'email'    => "visticsolutions@gmail.com",
            'address'    => "Mandsaur Madhya Pradesh",
            'number'    => "1234567890",
            'website'    => "visticsolutions.com",
            'twitter'    => "altafmansuri",
            'facebook'    => "altafmansuri",
            'whatsapp'    => "6263020998",
            'linkedin'    => "altafmansuri",
            'about' => "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.",
            'company' => "Vistic Solution",
            'instagram' => "altafmansuri",
            'youtube' => "altafmansuri",
        ];
        return view("cardtamplate.card3",$data);
    });
    //Admin
    Route::resource('admins', AdminController::class);
});







