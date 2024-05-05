@extends('main')

@section('content')

<div class="row">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12" >
          <div class="card" style="min-height: 700px;">
            <div class="nav-wrapper position-relative end-0 px-2 pt-2">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="true" id="edit_profile_lay-tab" aria-controls="edit_profile_lay" href="#edit_profile_lay">
                    <i class="fa fa-pen"></i>
                    <span class="ms-2">AppSetting</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="refer_lay-tab" aria-controls="refer_lay" href="#refer_lay">
                    <i class="fa fa-donate"></i>
                    <span class="ms-2">ReferEarn</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="payment_lay-tab" aria-controls="payment_lay" href="#payment_lay">
                    <i class="fa fa-credit-card"></i>
                    <span class="ms-2">Payment</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="notifiacation_lay-tab" aria-controls="notifiacation_lay" href="#notifiacation_lay">
                    <i class="fa fa-bell"></i>
                    <span class="ms-2">Notification</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="Whatsapp_lay-tab" aria-controls="whatsapp_lay" href="#whatsapp_lay">
                    <i class="fa fa-whatsapp"></i>
                    <span class="ms-2">Whatsapp</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="ads_lay-tab" aria-controls="ads_lay" href="#ads_lay">
                    <i class="fa fa-ad"></i>
                    <span class="ms-2">Ads</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="storage_lay-tab" aria-controls="storage_lay" href="#storage_lay">
                    <i class="fa fa-database"></i>
                    <span class="ms-2">Storage</span>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="app_update_lay-tab" aria-controls="app_update_lay" href="#app_update_lay">
                    <i class="fa fa-mobile-alt"></i>
                    <span class="ms-2">Update</span>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="privacy_terms_lay-tab" aria-controls="privacy_terms_lay" href="#privacy_terms_lay">
                    <i class="fa fa-list-alt"></i>
                    <span class="ms-2">Privacy</span>
                  </a>
                </li>
              </ul>
              
                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="edit_profile_lay" role="tabpanel" aria-labelledby="edit_profile_lay-tab">
                        <form method="post" action="{{ url('setting/app') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">App Name </label>
                                <input class="form-control" name="app_name" type="text" value="{{App\Models\Setting::getValue('app_name')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Company Name</label>
                                <input class="form-control" name="company_name" type="text" value="{{App\Models\Setting::getValue('company_name')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">App Logo</label>
                                <input class="form-control" id="appLogo" onchange="appLogoChange()" name="app_logo" type="file">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Company Logo</label>
                                <input class="form-control" id="companyLogo" onchange="companyLogoChange()" name="company_logo" type="file">
                              </div>
                            </div>
                            
                            <div class="col-md-6" id="previewAppLogo">
                              <div class="form-group">
                                <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                  <div class='avatar avatar-xxl position-relative'>
                                    <img src="{{App\Models\Setting::getValue('app_logo')}}" id='frameImage' class='border-radius-md' alt='team-2'>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group" id="previewCompanyLogo">
                                <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                  <div class='avatar avatar-xxl position-relative'>
                                    <img src="{{App\Models\Setting::getValue('company_logo')}}" id='frameImage' class='border-radius-md' alt='team-2'>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Share Image</label>
                                <input class="form-control" id="shareImage" onchange="shareImageChange()" name="share_image" type="file">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Share Text</label>
                                <textarea class="form-control" name="share_text" type="text" value="">{{App\Models\Setting::getValue('share_text')}}</textarea>
                              </div>
                            </div>
                            
                            <div class="col-md-6" id="previewShareImage">
                              <div class="form-group">
                                <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                  <div class='avatar avatar-xxl position-relative'>
                                    <img src="{{App\Models\Setting::getValue('share_image_url')}}" id='frameImage' class='border-radius-md' alt='team-2'>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Contact Number </label>
                                <input class="form-control" name="contact_number" type="text" value="{{App\Models\Setting::getValue('contact_number')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Contact Email</label>
                                <input class="form-control" name="contact_email" type="text" value="{{App\Models\Setting::getValue('contact_email')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Api Key </label>
                                <input class="form-control" name="api_key" type="text" disabled="disabled" value="{{env('API_KEY', '')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Currency</label>
                                <select class="form-control" name="currency" id="currency" name="currency">
                                    <option value="INR" >Rupees</option>
                                    <option value="USD" @if(App\Models\Setting::getValue('currency') == 'USD') selected @endif>USD</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Timezone</label>
                                <select class="form-control" name="timezone" id="timezoneSpiner" name="timezone">
                                    
                                </select>
                              </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                    
                        </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="refer_lay" role="tabpanel" aria-labelledby="refer_lay-tab">
                        <form method="post" action="{{ url('setting/referearn') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="refer_earn" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('refer_earn')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Refer & Earn</label>
                                </div>
                            </div>
                            <hr>
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Refer Bonus</label>
                                <input class="form-control" name="refer_bonus" type="text" value="{{App\Models\Setting::getValue('refer_bonus')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Refer Subscription Bonus(%)</label>
                                <input class="form-control" name="refer_subscription_bonus" type="text" value="{{App\Models\Setting::getValue('refer_subscription_bonus')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Minimum Withdraw</label>
                                <input class="form-control" name="min_withdraw" type="text" value="{{App\Models\Setting::getValue('min_withdraw')}}">
                              </div>
                            </div>
                            
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                  
                    <div class="tab-pane fade" id="payment_lay" role="tabpanel" aria-labelledby="payment_lay-tab">
                        <form method="post" action="{{ url('setting/payment') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="posts_limit_status" type="checkbox" id="posts_limit_status" @if(App\Models\Setting::getValue('posts_limit_status')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="posts_limit_status">Show Posts Limit</label>
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="watch_and_remove_watermark" type="checkbox" id="watch_and_remove_watermark" @if(App\Models\Setting::getValue('watch_and_remove_watermark')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="watch_and_remove_watermark">Watch And Remove Watermark</label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="buy_singal_post" type="checkbox" id="buy_singal_post" @if(App\Models\Setting::getValue('buy_singal_post')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="buy_singal_post">Buy Single Post</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Single Post Buying Price</label>
                                <input class="form-control" name="single_post_subsciption_amount" type="text" value="{{App\Models\Setting::getValue('single_post_subsciption_amount')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="paytm" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('paytm')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Paytm</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Merchant Key</label>
                                <input class="form-control" name="paytm_merchant_key" type="text" value="{{App\Models\Setting::getValue('paytm_merchant_key')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Merchant Id</label>
                                <input class="form-control" name="paytm_merchant_id" type="text" value="{{App\Models\Setting::getValue('paytm_merchant_id')}}">
                              </div>
                            </div>
                            
                            
                            <hr>
                            <hr>
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="razorpay" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('razorpay')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Razorpay Payment</label>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Razorpay Key</label>
                                <input class="form-control" name="razorpay_key" type="text" value="{{App\Models\Setting::getValue('razorpay_key')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Razorpay Secret</label>
                                <input class="form-control" name="razorpay_secret" type="text" value="{{App\Models\Setting::getValue('razorpay_secret')}}">
                              </div>
                            </div>
                            
                            <hr>
                            <hr>
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="instamojo" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('instamojo')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Instamojo Payment</label>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Client Id</label>
                                <input class="form-control" name="client_id" type="text" value="{{App\Models\Setting::getValue('client_id')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Client Secret</label>
                                <input class="form-control" name="client_secret" type="text" value="{{App\Models\Setting::getValue('client_secret')}}">
                              </div>
                            </div>
                            
                            <hr>
                            <hr>
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="stripe" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('stripe')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Stripe Payment</label>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Stripe Public Key</label>
                                <input class="form-control" name="stripe_public_key" type="text" value="{{App\Models\Setting::getValue('stripe_public_key')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Stripe Secret Key</label>
                                <input class="form-control" name="stripe_secret_key" type="text" value="{{App\Models\Setting::getValue('stripe_secret_key')}}">
                              </div>
                            </div>
                            
                            <hr>
                            <hr>
                            <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="offline_payment" type="checkbox"  @if(App\Models\Setting::getValue('offline_payment')=='true') checked @endif>
                                  <label class="text-center form-check-label">Offline Payment</label>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Offline Payment Details</label>
                                <textarea class="form-control" name="offline_details" type="text">{{App\Models\Setting::getValue('offline_details')}}</textarea>
                              </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                  
                    <div class="tab-pane fade" id="notifiacation_lay" role="tabpanel" aria-labelledby="notifiacation_lay-tab">
                       <form method="post" action="{{ url('setting/notification') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">FCM Key</label>
                                <input class="form-control" name="fcm_key" type="text" value="{{App\Models\Setting::getValue('fcm_key')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">OneSignal App Id</label>
                                <input class="form-control" name="onesignal_app_id" type="text" value="{{App\Models\Setting::getValue('onesignal_app_id')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">OneSignal Rest Key</label>
                                <input class="form-control" name="onesignal_key" type="text" value="{{App\Models\Setting::getValue('onesignal_key')}}">
                              </div>
                            </div>
                            
                            {{-- <div class="col-md-12" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="auto_festival_notification" type="checkbox" @if(App\Models\Setting::getValue('auto_festival_notification')=='true') checked @endif>
                                  <label class="text-center form-check-label">Auto Festival Notification</label>
                                </div>
                            </div> --}}
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="whatsapp_lay" role="tabpanel" aria-labelledby="whatsapp_lay-tab">
                       <form method="post" action="{{ url('setting/whatsapp') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Api Key</label>
                                <input class="form-control" name="whatsapp_api_key" type="text" value="{{App\Models\Setting::getValue('whatsapp_api_key')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Instance id</label>
                                <input class="form-control" name="whatsapp_instance_key" type="text" value="{{App\Models\Setting::getValue('whatsapp_instance_id')}}">
                              </div>
                            </div>
                            
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="whatsapp_otp" type="checkbox" id="whatsapp_otp" @if(App\Models\Setting::getValue('whatsapp_otp')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="whatsapp_otp">Whatsapp Otp Authentication</label>
                                </div>
                            </div>
                            <hr>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                  
                    <div class="tab-pane fade" id="ads_lay" role="tabpanel" aria-labelledby="ads_lay-tab">
                        <form method="post" action="{{ url('setting/ads') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="show_ads" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_ads')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Show Ads</label>
                                </div>
                            </div>
                            <hr>
                            <hr>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Ad Network</label>
                                <select class="form-control" name="ad_network" id="ad_network" name="ad_network">
                                    <option value="admob" >Admob</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Admob App Id</label>
                                <input class="form-control" name="publisher_id" type="text" value="{{App\Models\Setting::getValue('publisher_id')}}" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="card mb-2">
                                  <div class="card-header py-0 px-0 bg-primary" >
                                        <div class="d-flex align-items-center card-header py-2 px-2" style="background:#FF003E">
                                           <label class="text-white mt-2" >Admob Banner</label>
                                            <div class="ms-auto my-2">
                                                <div class="form-check form-switch ">
                                                  <input class="form-check-input" name="show_admob_banner" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_admob_banner')=='true') checked @endif >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div >
                                          <div class="form-group">
                                            <input class="form-control" name="admob_banner_id" required type="text" placeholder="Banner Id"value="{{App\Models\Setting::getValue ('admob_banner_id')}} ">
                                          </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="card mb-2">
                                  <div class="card-header py-0 px-0 bg-primary" >
                                        <div class="d-flex align-items-center card-header py-2 px-2" style="background:#FF003E">
                                           <label class="text-white mt-2" >Admob Interstitial</label>
                                            <div class="ms-auto my-2">
                                                <div class="form-check form-switch ">
                                                  <input class="form-check-input" name="show_admob_interstital" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_admob_interstital')=='true') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div >
                                          <div class="form-group">
                                            <input class="form-control" name="admob_interstitial_ad" type="text" placeholder="Interstitial Id"value="{{App\Models\Setting::getValue ('admob_interstitial_ad')}}" required>
                                          </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="card mb-2">
                                  <div class="card-header py-0 px-0 bg-primary" >
                                        <div class="d-flex align-items-center card-header py-2 px-2" style="background:#FF003E">
                                           <label class="text-white mt-2" >Admob Rewarded</label>
                                            <div class="ms-auto my-2">
                                                <div class="form-check form-switch ">
                                                  <input class="form-check-input" name="show_admob_rewarded" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_admob_rewarded')=='true') checked @endif >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div >
                                          <div class="form-group">
                                            <input class="form-control" name="admob_rewarde_id" type="text" placeholder="Rewarded Id"value="{{App\Models\Setting::getValue ('admob_rewarde_id')}}" required>
                                          </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="card mb-2">
                                  <div class="card-header py-0 px-0 bg-primary" >
                                        <div class="d-flex align-items-center card-header py-2 px-2" style="background:#FF003E">
                                           <label class="text-white mt-2" >Admob Native</label>
                                            <div class="ms-auto my-2">
                                                <div class="form-check form-switch ">
                                                  <input class="form-check-input" name="show_admob_native" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_admob_native')=='true') checked @endif >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div >
                                          <div class="form-group">
                                            <input class="form-control" name="admob_native_id" type="text" placeholder="Native Id"value="{{App\Models\Setting::getValue ('admob_native_id')}}" required>
                                          </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            
                            
                            <div class="col-md-6 mt-5">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="storage_lay" role="tabpanel" aria-labelledby="storage_lay-tab">
                        <form method="post" action="{{ url('setting/storage') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Storage</label>
                                <select class="form-control" name="storage_type" onchange="storageChange()" id="storage_type" name="storage_type">
                                    <option value="local" >Local</option>
                                    <option value="digitalOccean" @if(App\Models\Setting::getValue('storage_type') == 'digitalOccean') selected @endif>DigitalOccean</option>
                                </select>
                              </div>
                            </div>
                            
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Bucket Name</label>
                                <input class="form-control" name="do_space_name" id="do_space_name" type="text" value="{{env('DO_SPACES_BUCKET')}}" required>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Space Key</label>
                                <input class="form-control" name="do_key" id="do_key" type="text" value="{{env('DO_SPACES_KEY')}}" required>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Space Secret</label>
                                <input class="form-control" name="do_secret" id="do_secret" type="text" value="{{env('DO_SPACES_SECRET')}}" required>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Bucket Region</label>
                                <input class="form-control" name="do_bucket_region" id="do_bucket_region" type="text" value="{{env('DO_SPACES_REGION')}}" required>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Space Url</label>
                                <input class="form-control" name="do_space_url" id="do_space_url" type="text" value="{{env('DO_SPACES_URL')}}" required>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">DigitalOcean Space Endpoint</label>
                                <input class="form-control" name="do_end_point" id="do_end_point" type="text" value="{{env('DO_SPACES_ENDPOINT')}}" required>
                              </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                   
                    <div class="tab-pane fade" id="app_update_lay" role="tabpanel" aria-labelledby="app_update_lay-tab">
                        <form method="post" action="{{ url('setting/appupdate') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-5">
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="show_update_dialog" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('show_update_dialog')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Show Update Dialog</label>
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="force_update" type="checkbox" id="rememberMe" @if(App\Models\Setting::getValue('force_update')=='true') checked @endif>
                                  <label class="text-center form-check-label" for="rememberMe">Force Update</label>
                                </div>
                            </div>
                            <hr>
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">New Version Code</label>
                                <input class="form-control" name="app_version_code" type="text" value="{{App\Models\Setting::getValue('app_version_code')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">App Link</label>
                                <input class="form-control" name="app_link" type="text" value="{{App\Models\Setting::getValue('app_link')}}">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Update Information</label>
                                <input class="form-control" name="update_information" type="text" value="{{App\Models\Setting::getValue('update_information')}}">
                              </div>
                            </div>
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="privacy_terms_lay" role="tabpanel" aria-labelledby="privacy_terms_lay-tab">
                        <form method="post" action="{{ url('setting/privacyterms') }}" id="termscondition_form" enctype="multipart/form-data">
                            @csrf
                        <div class="row p-3">
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Privacy Policy</label>
                                <textarea name="privacypolicy" id="privacypolicy_et">
                                     {{App\Models\Setting::getValue('privacypolicy')}}
                                </textarea>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="text-center" class="form-control-label">Terms & Condition</label>
                                <textarea name="terms_and_condition"  id="termscondition_et">
                                    
                                    {{App\Models\Setting::getValue('terms_and_condition')}}
                                </textarea>
                              </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-6">
                              <div class="form-group">
                                  @if(Session::get('admin_type') == "Demo")
                                  <div class="form-control btn btn-primary demo_action">Submit</div>
                                  @else
                                  <input class="form-control btn btn-primary" type="submit" value="Update">
                                  @endif
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
              </div>
              
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
</div>

<script>
    $('#privacypolicy_et').summernote({
        placeholder: '',
        tabsize: 2,
        height: 300,
    });
    $('#termscondition_et').summernote({
        placeholder: '',
        tabsize: 2,
        height: 300
    });
    
    $(document).ready(function(){
        storageChange();
    });
    
    function shareImageChange(){
        var fileInput = document.getElementById('shareImage');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewShareImage").innerHTML = "";
                $('#previewShareImage').append(
                "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
                  "<div class='avatar avatar-xxl position-relative'>"+
                    "<img src='"+e.target.result+"' id='imge' class='border-radius-md' alt='team-2'>"+
                  "</div>"+
                "</div>");
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    
    
    function storageChange(){
        d = document.getElementById("storage_type").value;
        if(d == "local")
        {
            document.getElementById("do_space_name").readOnly = true;
            document.getElementById("do_key").readOnly = true;
            document.getElementById("do_secret").readOnly = true;
            document.getElementById("do_bucket_region").readOnly = true;
            document.getElementById("do_end_point").readOnly = true;
            document.getElementById("do_space_url").readOnly = true;
            // $(".do_test_btn").attr('disabled','disabled');
        }
        
        if(d == "digitalOccean")
        {
            document.getElementById("do_space_name").readOnly = false;
            document.getElementById("do_space_name").required = true;
            
            document.getElementById("do_key").readOnly = false;
            document.getElementById("do_key").required = true;
            
            document.getElementById("do_secret").readOnly = false;
            document.getElementById("do_secret").required = true;
            
            document.getElementById("do_bucket_region").readOnly = false;
            document.getElementById("do_bucket_region").required = true;
            
            document.getElementById("do_end_point").readOnly = false;
            document.getElementById("do_end_point").required = true;
            
            document.getElementById("do_space_url").readOnly = false;
            document.getElementById("do_space_url").required = true;
            // $(".do_test_btn").removeAttr('disabled');
        }
    }
    
    function appLogoChange(){
        var fileInput = document.getElementById('appLogo');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewAppLogo").innerHTML = "";
                $('#previewAppLogo').append(
                "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
                  "<div class='avatar avatar-xxl position-relative'>"+
                    "<img src='"+e.target.result+"' id='imge' class='border-radius-md' alt='team-2'>"+
                  "</div>"+
                "</div>");
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    
    function companyLogoChange(){
        var fileInput = document.getElementById('companyLogo');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewCompanyLogo").innerHTML = "";
                $('#previewCompanyLogo').append(
                "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
                  "<div class='avatar avatar-xxl position-relative'>"+
                    "<img src='"+e.target.result+"' id='imge' class='border-radius-md' alt='team-2'>"+
                  "</div>"+
                "</div>");
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    
var tzs = [
    {"label":"(GMT-12:00) International Date Line West","value":"Etc/GMT+12"},
    {"label":"(GMT-11:00) Midway Island, Samoa","value":"Pacific/Midway"},
    {"label":"(GMT-10:00) Hawaii","value":"Pacific/Honolulu"},
    {"label":"(GMT-09:00) Alaska","value":"US/Alaska"},
    {"label":"(GMT-08:00) Pacific Time (US & Canada)","value":"America/Los_Angeles"},
    {"label":"(GMT-08:00) Tijuana, Baja California","value":"America/Tijuana"},
    {"label":"(GMT-07:00) Arizona","value":"US/Arizona"},
    {"label":"(GMT-07:00) Chihuahua, La Paz, Mazatlan","value":"America/Chihuahua"},
    {"label":"(GMT-07:00) Mountain Time (US & Canada)","value":"US/Mountain"},
    {"label":"(GMT-06:00) Central America","value":"America/Managua"},
    {"label":"(GMT-06:00) Central Time (US & Canada)","value":"US/Central"},
    {"label":"(GMT-06:00) Guadalajara, Mexico City, Monterrey","value":"America/Mexico_City"},
    {"label":"(GMT-06:00) Saskatchewan","value":"Canada/Saskatchewan"},
    {"label":"(GMT-05:00) Bogota, Lima, Quito, Rio Branco","value":"America/Bogota"},
    {"label":"(GMT-05:00) Eastern Time (US & Canada)","value":"US/Eastern"},
    {"label":"(GMT-05:00) Indiana (East)","value":"US/East-Indiana"},
    {"label":"(GMT-04:00) Atlantic Time (Canada)","value":"Canada/Atlantic"},
    {"label":"(GMT-04:00) Caracas, La Paz","value":"America/Caracas"},
    {"label":"(GMT-04:00) Manaus","value":"America/Manaus"},
    {"label":"(GMT-04:00) Santiago","value":"America/Santiago"},
    {"label":"(GMT-03:30) Newfoundland","value":"Canada/Newfoundland"},
    {"label":"(GMT-03:00) Brasilia","value":"America/Sao_Paulo"},
    {"label":"(GMT-03:00) Buenos Aires, Georgetown","value":"America/Argentina/Buenos_Aires"},
    {"label":"(GMT-03:00) Greenland","value":"America/Godthab"},
    {"label":"(GMT-03:00) Montevideo","value":"America/Montevideo"},
    {"label":"(GMT-02:00) Mid-Atlantic","value":"America/Noronha"},
    {"label":"(GMT-01:00) Cape Verde Is.","value":"Atlantic/Cape_Verde"},
    {"label":"(GMT-01:00) Azores","value":"Atlantic/Azores"},
    {"label":"(GMT+00:00) Casablanca, Monrovia, Reykjavik","value":"Africa/Casablanca"},
    {"label":"(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London","value":"Etc/Greenwich"},
    {"label":"(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna","value":"Europe/Amsterdam"},
    {"label":"(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague","value":"Europe/Belgrade"},
    {"label":"(GMT+01:00) Brussels, Copenhagen, Madrid, Paris","value":"Europe/Brussels"},
    {"label":"(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb","value":"Europe/Sarajevo"},
    {"label":"(GMT+01:00) West Central Africa","value":"Africa/Lagos"},
    {"label":"(GMT+02:00) Amman","value":"Asia/Amman"},
    {"label":"(GMT+02:00) Athens, Bucharest, Istanbul","value":"Europe/Athens"},
    {"label":"(GMT+02:00) Beirut","value":"Asia/Beirut"},
    {"label":"(GMT+02:00) Cairo","value":"Africa/Cairo"},
    {"label":"(GMT+02:00) Harare, Pretoria","value":"Africa/Harare"},
    {"label":"(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius","value":"Europe/Helsinki"},
    {"label":"(GMT+02:00) Jerusalem","value":"Asia/Jerusalem"},
    {"label":"(GMT+02:00) Minsk","value":"Europe/Minsk"},
    {"label":"(GMT+02:00) Windhoek","value":"Africa/Windhoek"},
    {"label":"(GMT+03:00) Kuwait, Riyadh, Baghdad","value":"Asia/Kuwait"},
    {"label":"(GMT+03:00) Moscow, St. Petersburg, Volgograd","value":"Europe/Moscow"},
    {"label":"(GMT+03:00) Nairobi","value":"Africa/Nairobi"},
    {"label":"(GMT+03:00) Tbilisi","value":"Asia/Tbilisi"},
    {"label":"(GMT+03:30) Tehran","value":"Asia/Tehran"},
    {"label":"(GMT+04:00) Abu Dhabi, Muscat","value":"Asia/Muscat"},
    {"label":"(GMT+04:00) Baku","value":"Asia/Baku"},
    {"label":"(GMT+04:00) Yerevan","value":"Asia/Yerevan"},
    {"label":"(GMT+04:30) Kabul","value":"Asia/Kabul"},
    {"label":"(GMT+05:00) Yekaterinburg","value":"Asia/Yekaterinburg"},
    {"label":"(GMT+05:00) Islamabad, Karachi, Tashkent","value":"Asia/Karachi"},
    {"label":"(GMT+05:30) Kolkata","value":"Asia/Calcutta"},
    {"label":"(GMT+05:45) Kathmandu","value":"Asia/Katmandu"},
    {"label":"(GMT+06:00) Almaty, Novosibirsk","value":"Asia/Almaty"},
    {"label":"(GMT+06:00) Astana, Dhaka","value":"Asia/Dhaka"},
    {"label":"(GMT+06:30) Yangon (Rangoon)","value":"Asia/Rangoon"},
    {"label":"(GMT+07:00) Bangkok, Hanoi, Jakarta","value":"Asia/Bangkok"},
    {"label":"(GMT+07:00) Krasnoyarsk","value":"Asia/Krasnoyarsk"},
    {"label":"(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi","value":"Asia/Hong_Kong"},
    {"label":"(GMT+08:00) Kuala Lumpur, Singapore","value":"Asia/Kuala_Lumpur"},
    {"label":"(GMT+08:00) Irkutsk, Ulaan Bataar","value":"Asia/Irkutsk"},
    {"label":"(GMT+08:00) Perth","value":"Australia/Perth"},
    {"label":"(GMT+08:00) Taipei","value":"Asia/Taipei"},
    {"label":"(GMT+09:00) Osaka, Sapporo, Tokyo","value":"Asia/Tokyo"},
    {"label":"(GMT+09:00) Seoul","value":"Asia/Seoul"},
    {"label":"(GMT+09:00) Yakutsk","value":"Asia/Yakutsk"},
    {"label":"(GMT+09:30) Adelaide","value":"Australia/Adelaide"},
    {"label":"(GMT+09:30) Darwin","value":"Australia/Darwin"},
    {"label":"(GMT+10:00) Brisbane","value":"Australia/Brisbane"},
    {"label":"(GMT+10:00) Canberra, Melbourne, Sydney","value":"Australia/Canberra"},
    {"label":"(GMT+10:00) Hobart","value":"Australia/Hobart"},
    {"label":"(GMT+10:00) Guam, Port Moresby","value":"Pacific/Guam"},
    {"label":"(GMT+10:00) Vladivostok","value":"Asia/Vladivostok"},
    {"label":"(GMT+11:00) Magadan, Solomon Is., New Caledonia","value":"Asia/Magadan"},
    {"label":"(GMT+12:00) Auckland, Wellington","value":"Pacific/Auckland"},
    {"label":"(GMT+12:00) Fiji, Kamchatka, Marshall Is.","value":"Pacific/Fiji"},
    {"label":"(GMT+13:00) Nuku'alofa","value":"Pacific/Tongatapu"}
];
var options = [];
select = document.getElementById("timezoneSpiner");
for (var i=0; i<tzs.length; i++){
  var tz = tzs[i];
  option = document.createElement("option");
  option.value = tz.value;
  if(tz.value == "{{App\Models\Setting::getValue('timezone')}}"){
      option.selected = true;
  }
  option.appendChild(document.createTextNode(tz.label));
  select.appendChild(option);
}


$(document).ready(function () {
    create_custom_dropdowns();
});
</script>
@endsection