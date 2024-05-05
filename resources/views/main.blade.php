<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
  
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" href="{{ asset(App\Models\Setting::getValue('app_logo')) }}">
        <title>
            {{ App\Models\Setting::getValue('app_name') }}
        </title>
        
        <link href="{{ url('/css/nucleo-icons.css?p=825') }}" rel="stylesheet">
        <link href="{{ url('/css/nucleo-svg.css') }}" rel="stylesheet">
        <link href="{{ url('/css/app.css?t='.time()) }}" rel="stylesheet">
        <link href="{{ url('/css/style.css?t='.time()) }}" rel="stylesheet">
        <link href="{{ url('/css/argon-dashboard.css?t='.time()) }}" rel="stylesheet">
        
        <script src="{{ url('/js/plugin/charts.js') }}"></script>
        
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
       

        <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
        
        
        <!--Toaster-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        
    </head>
    <body class="g-sidenav-show   bg-gray-100">
        
  <!--<div class="min-height-300 bg-primary position-absolute w-100"></div>-->
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/" target="_blank">
        <img src="{{ asset(App\Models\Setting::getValue('app_logo')) }}" class="avatar avatar-sm navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{ App\Models\Setting::getValue('app_name') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    
    <div id="sidenav-collapse-main">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='/' ? 'active' : ''}}" href="/">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='language' ? 'active' : ''}}" href="{{ url('language') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-language text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Language</span>
          </a>
        </li>
        @if(App\Models\Admin::isPermission('section')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='section' ? 'active' : ''}}" href="{{ url('section') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-list-ul text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sections</span>
          </a>
        </li>
        @endif
        
        
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#festivalSection" class="nav-link {{ Request::path()=='festivalCategory' || Request::path()=='festival' ? 'active' : ''}}" aria-controls="festivalSection" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-gifts text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Festival Data</span>
            </a>
            <div class="collapse {{ Request::path()=='festivalCategory' || Request::path()=='festival' ? 'show' : ''}}" id="festivalSection">
              <ul class="nav ms-4">
                  @if(App\Models\Admin::isPermission('posts')  == 'true')
                <li class="nav-item {{ Request::path()=='festival' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/festival') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Festival Posts</span>
                  </a>
                </li>
                @endif
                @if(App\Models\Admin::isPermission('category') == 'true')
                <li class="nav-item {{ Request::path()=='festivalCategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/festivalCategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Festival Category</span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
        </li> --}}
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#businessSection" class="nav-link {{ Request::path()=='businessCategory' ||Request::path()=='businessSubCategory' || Request::path()=='business' ? 'active' : ''}}" aria-controls="businessSection" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-business-time text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Business Data</span>
            </a>
            <div class="collapse {{ Request::path()=='businessCategory' ||Request::path()=='businessSubCategory' || Request::path()=='business' ? 'show' : ''}}" id="businessSection">
              <ul class="nav ms-4">
                  @if(App\Models\Admin::isPermission('posts')  == 'true')
                <li class="nav-item {{ Request::path()=='business' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/business') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Business Posts</span>
                  </a>
                </li>
                @endif
                @if(App\Models\Admin::isPermission('category') == 'true')
                <li class="nav-item {{ Request::path()=='businessCategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/businessCategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Business Category</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='businessSubCategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/businessSubCategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Business Sub Category</span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
        </li> --}}
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#politicalSection" class="nav-link {{ Request::path()=='politicalCategory' || Request::path()=='political' ? 'active' : ''}}" aria-controls="politicalSection" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-handshake-o text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Political Data</span>
            </a>
            <div class="collapse {{ Request::path()=='politicalCategory' || Request::path()=='political' ? 'show' : ''}}" id="politicalSection">
              <ul class="nav ms-4">
                @if(App\Models\Admin::isPermission('posts')  == 'true')
                <li class="nav-item {{ Request::path()=='political' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/political') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Political Posts</span>
                  </a>
                </li>
                @endif
                @if(App\Models\Admin::isPermission('category') == 'true')
                <li class="nav-item {{ Request::path()=='politicalCategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/politicalCategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Political Category</span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
        </li> --}}
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#customSection" class="nav-link {{ Request::path()=='customCategory' || Request::path()=='custom' ? 'active' : ''}}" aria-controls="customSection" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-solid fa-image text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Template</span>
            </a>
            <div class="collapse {{ Request::path()=='customCategory' || Request::path()=='custom' ? 'show' : ''}}" id="customSection">
              <ul class="nav ms-4">
                @if(App\Models\Admin::isPermission('posts')  == 'true')
                <li class="nav-item {{ Request::path()=='custom' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/custom') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Template Posts</span>
                  </a>
                </li>
                @endif
                @if(App\Models\Admin::isPermission('category') == 'true')
                <li class="nav-item {{ Request::path()=='customCategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/customCategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Template Category</span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
        </li>
        
        {{-- @if(App\Models\Admin::isPermission('greeting')  == 'true')
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#greetingExamples" class="nav-link {{ Request::path()=='greeting' || Request::path()=='greetingsection' ? 'active' : ''}}" aria-controls="greetingExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-gift text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Greeting</span>
            </a>
            <div class="collapse {{ Request::path()=='greeting' || Request::path()=='greetingsection' ? 'show' : ''}}" id="greetingExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='greeting' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/greeting') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Greeting Post</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='greetingsection' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/greetingsection') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Greeting Section</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        @endif --}}
        
        @if(App\Models\Admin::isPermission('video')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='video' ? 'active' : ''}}" href="{{ url('video') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-video text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Video</span>
          </a>
        </li>
        @endif
        
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#videoTamplateExamples" class="nav-link {{ Request::path()=='videotamplate' || Request::path()=='videotamplatecategory' ? 'active' : ''}}" aria-controls="videoTamplateExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-video text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Video Tamplates</span>
            </a>
            <div class="collapse {{ Request::path()=='videotamplate' || Request::path()=='videotamplatecategory' ? 'show' : ''}}" id="videoTamplateExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='videotamplate' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/videotamplate') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Tamplates</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='videotamplatecategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/videotamplatecategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Categories</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#musicExamples" class="nav-link {{ Request::path()=='music' || Request::path()=='musiccategory' ? 'active' : ''}}" aria-controls="musicExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-music text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Music</span>
            </a>
            <div class="collapse {{ Request::path()=='music' || Request::path()=='musiccategory' ? 'show' : ''}}" id="musicExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='music' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/music') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Musics</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='musiccategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/musiccategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Music Category</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#stickerExamples" class="nav-link {{ Request::path()=='sticker' || Request::path()=='stickercategory' || str_contains(Request::path(),'stickerCategory') ? 'active' : ''}}" aria-controls="stickerExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-laugh-wink text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sticker</span>
            </a>
            <div class="collapse {{ Request::path()=='sticker' || Request::path()=='stickercategory' || str_contains(Request::path(),'stickerCategory') ? 'show' : ''}}" id="stickerExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='sticker' || str_contains(Request::path(),'stickerCategory') ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/sticker') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Stickers</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='stickercategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/stickercategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Sticker Category</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        
        {{-- @if(App\Models\Admin::isPermission('frame')  == 'true')
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#frameExamples" class="nav-link {{ Request::path()=='frame' || Request::path()=='framecategory' || str_contains(Request::path(),'frameCategory') ? 'active' : ''}}" aria-controls="frameExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-square text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Frames</span>
            </a>
            <div class="collapse {{ Request::path()=='frame' || Request::path()=='framecategory' || str_contains(Request::path(),'frameCategory') ? 'show' : ''}}" id="frameExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='frame' || str_contains(Request::path(),'frameCategory') ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/frame') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Frames</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='framecategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/framecategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Frame Category</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#logoExamples" class="nav-link {{ Request::path()=='logos' || Request::path()=='logocategory' || str_contains(Request::path(),'logocategory') ? 'active' : ''}}" aria-controls="logoExamples" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-square text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Logos</span>
            </a>
            <div class="collapse {{ Request::path()=='logos' || Request::path()=='logocategory' || str_contains(Request::path(),'logocategory') ? 'show' : ''}}" id="logoExamples">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='logos' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/logos') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Logos</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='logocategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/logocategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Logo Category</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li>
        @endif --}}
        
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#businesscardtamplate" class="nav-link {{ Request::path()=='businesscardtamplate' || Request::path()=='businesscarddigital' ? 'active' : ''}}" aria-controls="businesscardtamplate" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-address-card text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Business Card</span>
            </a>
            <div class="collapse {{ Request::path()=='businesscardtamplate' || Request::path()=='businesscarddigital' ? 'show' : ''}}" id="businesscardtamplate">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='businesscardtamplate' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/businesscardtamplate') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Visiting Card</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='businesscarddigital' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/businesscarddigital') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Clickable Card</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li> --}}
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#invitationcardtamplate" class="nav-link {{ Request::path()=='invitationcard' || Request::path()=='invitationcategory' ? 'active' : ''}}" aria-controls="invitationcardtamplate" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-glass-cheers text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Custom Tamplate</span>
            </a>
            <div class="collapse {{ Request::path()=='invitationcard' || Request::path()=='invitationcategory' ? 'show' : ''}}" id="invitationcardtamplate">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='invitationcard' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/invitationcard') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Tamplates</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='invitationcategory' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/invitationcategory') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Category</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li> --}}
        
        
        {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#ourservices" class="nav-link {{ Request::path()=='ourservices' || Request::path()=='inquiries' ? 'active' : ''}}" aria-controls="businesscardtamplate" role="button" aria-expanded="false">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa fa-store text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Our Services</span>
            </a>
            <div class="collapse {{ Request::path()=='ourservices' || Request::path()=='inquiries' ? 'show' : ''}}" id="ourservices">
              <ul class="nav ms-4">
                <li class="nav-item {{ Request::path()=='ourservices' ? 'active' : ''}}">
                  <a class="nav-link " href="{{ url('/ourservices') }}">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal">Services</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::path()=='inquiries' ? 'active' : ''}}">
                  <a class="nav-link" href="{{ url('/inquiries') }}">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal">Inquiries</span>
                  </a>
                </li>
                
              </ul>
            </div>
        </li> --}}
        
        
        @if(App\Models\Admin::isPermission('slider')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='slider' ? 'active' : ''}}" href="{{ url('slider') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-exchange-alt text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Image Slider</span>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='backgrounds' ? 'active' : ''}}" href="{{ url('backgrounds') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-file-image-o text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Backgrounds</span>
          </a>
        </li>
        @if(App\Models\Admin::isPermission('user')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='users' ? 'active' : ''}}" href=" {{ url('users') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-users text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        @endif
        
        {{-- <li class="nav-item">
          <a class="nav-link {{ Request::path()=='withdraws' ? 'active' : ''}}" href=" {{ url('withdraws') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-wallet text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Withdraws</span>
          </a>
        </li> --}}
        
        @if(App\Models\Admin::isPermission('contacts')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='contacts' ? 'active' : ''}}" href=" {{ url('contacts') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-envelope-open text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Contacts</span>
          </a>
        </li>
        @endif
        
        @if(App\Models\Admin::isPermission('transaction')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='transaction' ? 'active' : ''}}" href=" {{ url('transaction') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-tasks text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Transaction</span>
          </a>
        </li>
        @endif
        
        
        @if(App\Models\Admin::isPermission('subscription')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='subscription' ? 'active' : ''}}" href=" {{ url('subscription') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-chess-queen text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Subscription</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='promocode' ? 'active' : ''}}" href=" {{ url('promocode') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-credit-card text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Promocodes</span>
          </a>
        </li>
        @endif
        
        @if(App\Models\Admin::isPermission('offerdialog')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='offerdialog' ? 'active' : ''}}" href=" {{ url('offerdialog') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-receipt text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Offer Dialog</span>
          </a>
        </li>
        @endif
        
        @if(App\Models\Admin::isPermission('pushnotification')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='pushnotification' ? 'active' : ''}}" href=" {{ url('pushnotification') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-paper-plane text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Push Notification</span>
          </a>
        </li>
        @endif
        
        
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='whatsappmessage' ? 'active' : ''}}" href=" {{ url('whatsappmessage') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-whatsapp text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Whatsapp Message</span>
          </a>
        </li>
        
        
        @if(App\Models\Admin::isPermission('setting')  == 'true')
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='setting' ? 'active' : ''}}" href=" {{ url('setting') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-cog text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Setting</span>
          </a>
        </li>
        @endif
        
        @if(App\Models\Admin::isPermission('admin')  == 'true')
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::path()=='admins' ? 'active' : ''}}" href="{{ url('admins') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Admins</span>
          </a>
        </li>
        @endif
        
        <li class="nav-item">
          <a class="nav-link " href="{{ url('logout') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-sign-out-alt text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Log Out</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
    <main class="main-content position-relative" >
        <nav class="navbar navbar-main shadow-none" id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3 bg">
                <nav aria-label="breadcrumb">
                    <ul class="navbar-nav" >
                        <li class="nav-item d-xl-none d-flex align-items-center">
                          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                              <i class="sidenav-toggler-line bg-white"></i>
                              <i class="sidenav-toggler-line bg-white"></i>
                              <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                          </a>
                        </li>
                        <li>
                            <h6 class="font-weight-bolder text-white mb-0 ps-3">Dashboard</h6>
                        </li>
                    </ul>
                </nav>
                <a href="{{ url('admins/'.Session::get('userid')).'/edit' }}"><img src="{{ url(Session::get('profile')) }}" class="avatar avatar-sm "></a>
            
            </div>
        </nav>
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
    
    
    <script src="{{ url('/js/plugin/perfectscrollbar.js') }}"></script>
    <script src="{{ url('/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/core/argondash.min.js') }}"></script>
    <script src="{{ url('/js/app.js?t='.time()) }}"></script>
    <script src="{{ url('/js/fstdropdown.js?t='.time()) }}"></script>
    
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "300",
            "timeOut": "3000",
            "extendedTimeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
          
        $('.demo_action').click(function() {
          toastr.error("Demo user can't perform this action");
        });
    </script>
    </body>
</html>