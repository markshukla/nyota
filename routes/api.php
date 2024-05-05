<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace ('Api')->middleware(['throttle'])->group(function(){
    
    //User Activity
    Route::post('login',[Controller::class,'loginUser']);
    Route::post('updateProPic',[Controller::class,'updateProfilePicture']);
    Route::post('updateUserProfile',[Controller::class,'updateProfile']);
    Route::get('profile',[Controller::class,'geUserProfile']);
    Route::post('uploadspost',[Controller::class,'uploadUserPost']);
    Route::get('userposts',[Controller::class,'getUserPosts']);
    
    //Required Data
    Route::get('settings',[Controller::class,'getAllSettings']);
    Route::get('language',[Controller::class,'getLanguage']);
    
    //HomeData
    Route::get('homedata',[Controller::class,'getHomeData']);
    
    //HomeVideo
    Route::get('videocategory',[Controller::class,'getVideoCategoryData']);
    
    //Greeting
    Route::get('greetingdata',[Controller::class,'getGreetingData']);
    
    //DailyPost
    Route::get('dailyPosts',[Controller::class,'getDailyPosts']);
    
    //Subscriptions
    Route::get('subscriptions',[Controller::class,'getSubscriptionPlan']);
    Route::post('updateUserSubscription',[Controller::class,'updateUserSubscription']);
    Route::post('offlineSuscription',[Controller::class,'offlineSuscription']);
    
    //Prmium Posts
    Route::get('premiumpostsbycategory/{type}',[Controller::class,'getPremiumPostsbyCategory']);
    
    //Category
    Route::get('categoriesbypage',[Controller::class,'getCategoriesbyPage']);
    
    //Posts
    Route::get('postsbypage',[Controller::class,'getPostsbyPage']);
    Route::get('updatepostviews',[Controller::class,'updatepostviews']);
    
    //User Bussiness
    Route::get('userbusiness',[Controller::class,'getUserBusiness']);
    Route::get('userbusinessdetail',[Controller::class,'getUserBusinessDetail']);
    Route::post('adduserbusiness',[Controller::class,'addUserBusiness']);//Add & Update
    Route::post('deletebusiness',[Controller::class,'deleteBusiness']);
    
    Route::get('frames',[Controller::class,'getFrames']);
    Route::get('framesbytype',[Controller::class,'getFramesByType']);
    Route::get('showframe/{id}',[Controller::class,'showFrameView']);
    Route::get('userframes',[Controller::class,'getUserFrames']);
    
    //Stickeres
    Route::get('stickercategory',[Controller::class,'getStickerbyCategory']);
    
    //Logos
    Route::get('logoscategory',[Controller::class,'getLogosbyCategory']);
    
    //Music
    Route::get('musiccategory',[Controller::class,'getMusicbyCategory']);
    
    //Contact
    Route::post('addcontact',[Controller::class,'addContact']);
    
    //Add Inquiry
    Route::post('addinquiry',[Controller::class,'addInquiry']);
    
    //Select Category
    Route::get('businesspoliticalcategory',[Controller::class,'getBusinessPoliticalCategory']);
    
    //Cheak Promo
    Route::get('cheakPromo',[Controller::class,'cheakPromocode']);
    
    //Cheak Promo
    Route::post('cheakReferCode',[Controller::class,'cheakReferCode']);
    
    //Cheak Promo
    Route::post('usercategory',[Controller::class,'getUserCategory']);
    
    //Business Card Digital / Tamplate
    Route::get('businesscards',[Controller::class,'getBusinessCards']);
    
    //Create user business card
    Route::post('createuserbusinesscard',[Controller::class,'createUserBusinessCard']);
    
    //Our Services
    Route::get('ourservices',[Controller::class,'getServices']);
    
    //userinvitelist
    Route::get('userinvitelist',[Controller::class,'getUserInviteList']);
    
    //withdrawlist
    Route::get('withdrawlist',[Controller::class,'getUserWithdrawList']);
    
    //withdrawlist
    Route::post('withdrawrequest',[Controller::class,'withdrawRequest']);
    
    //withdrawlist
    Route::get('invitationcategories',[Controller::class,'getInvitationCategories']);
    
    //withdrawlist
    Route::get('transactionlist',[Controller::class,'getUserTransactionList']);
    
    //Paytm
    Route::post('paytmPayment',[Controller::class,'paytmPayment']);
    Route::post('verifyPaytmPayment',[Controller::class,'verifyPaytmPayment']);
    
    //Cashfree
    Route::post('cashfreePayment',[Controller::class,'cashfreePayment']);
    
    //Stripe
    Route::post('createStripePayment',[Controller::class,'createStripePayment']);
    
    //WhatsappOtp
    Route::post('whatsappotp',[Controller::class,'whatsappOtp']);
    
    //Video Tamplate
    Route::get('videoTamplates',[Controller::class,'getVideoTamplates']);
    Route::get('videotamplatecategoriesbypage',[Controller::class,'getVideoTamplateCategoriesBypage']);
    
    //withdrawlist
    Route::get('searchSuggestion',[Controller::class,'getSearchSuggestion']);
    
    //Background
    Route::get('backgrounds',[Controller::class,'getBackgrounds']);
    
    Route::get('autoFestivalNotification', [NotificationController::class, 'sendAutoFestivalNotification']);
    
    Route::get('invitationcardsbycateid', [Controller::class, 'getInvitationCardsByCatId']);
    
    Route::post('updatedevicetoken', [Controller::class, 'updateDeviceToken']);
});

// Route::get('liveChannel',[Controller::class,'getLiveChannel']);
// Route::get('category',[Controller::class,'getCategory']);
// Route::get('setting',[Controller::class,'getSetting']);

// Route::post('news/{id}',[Controller::class,'getNews']);
// Route::get('admin',[Admin::class,'setAdminData']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
