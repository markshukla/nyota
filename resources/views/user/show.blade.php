@extends('main')

@section('content')
<div class="row">
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-profile">
            <img src="https://ak.picdn.net/shutterstock/videos/1067113702/thumb/1.jpg?ip=x480" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-4 col-lg-4 ">
                <div class="mt-lg-n5 justify-content-center">
                  <img src="@if($user->profile_pic) {{url($user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif" class="rounded-circle border border-4 border-white" style="height:85px;width:85px;">
                </div>
              </div>
            </div>
            
            <div class="table-responsive ps-3 mt-2">
                
                <table class="table align-items-center mb-0 sort ">
                    <tr class="">
                        <button class="btn btn-sm btn-success" style="width:93%" data-id="{{$user->id}}" data-toggle="modal" data-target="#sendModal"><i class="fa fa-whatsapp"></i> Send Whatsapp Message
                        </button>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Name - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Email - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Phone - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->number }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            State - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->state }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            City - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->district }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Balance - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->balance }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Refer Code - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->refer_id }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Register - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{date('d M, y',strtotime($user->created_at))}}
                        </td>
                    </tr>
                    
                    
                    
                </table>
                
            </div>
            
            <p class="text-uppercase ms-3 mt-2 text-sm font-weight-bolder">Subscription</p>
            
            <div class="table-responsive ps-3">
                
                <table class="table align-items-center mb-0 sort">
                    <tr>
                        <td class=" text-sm font-weight-bolder">
                            Plan - 
                        </td>
                        <td class="text-sm" style="color:black">
                            {{ $user->subscription_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            Start - 
                        </td>
                        <td class="text-sm" style="color:black">
                            @if(!empty($user->subscription_date)) {{date('d M, y',strtotime($user->subscription_date))}} @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-bolder">
                            End - 
                        </td>
                        <td class="text-sm" style="color:black">
                            @if(!empty($user->subscription_end_date)) {{ date('d M, y',strtotime($user->subscription_end_date)) }} @endif
                        </td>
                    </tr>
                    
                </table>
                
            </div>
            
            <div class="card-body pt-0 mt-3">
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-center">
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">{{ count($posts) }}</span>
                      <span class="text-sm opacity-8">Poster</span>
                    </div>
                    <div class="d-grid text-center mx-4">
                      <span class="text-lg font-weight-bolder">{{ count($businesses) }}</span>
                      <span class="text-sm opacity-8">Bussiness</span>
                    </div>
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">{{ count($frames) }}</span>
                      <span class="text-sm opacity-8">Frames</span>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            
            <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
              <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-danger mb-0 d-none d-lg-block ps-3 pe-3"  data-id="{{$user->id}}" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i>  Delete Account
                </button>
                <button id="block_btn" class="btn btn-sm btn-primary mb-0 d-none d-lg-block ps-3 pe-3" data-id="{{$user->id}}" value="{{$user->status}}"> @if($user->status == 0) Block User @else Unblock User @endif
                </button>
              </div>
            </div>
            
            <form action="{{ url('users/'.$user->id) }}" method="POST" id="form-user-{{$user->id}}">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
            </form>
          </div>
        </div>
        <div class="col-md-8" >
          <div class="card" style="min-height: 700px;">
              
            <div class="nav-wrapper position-relative end-0 px-2 pt-2">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="true" id="edit_profile_lay-tab" aria-controls="edit_profile_lay" href="#edit_profile_lay">
                    <i class="fa fa-pen"></i>
                    <span class="ms-2">Edit Profile</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="user_post_lay-tab" aria-controls="user_post_lay" href="#user_post_lay">
                    <i class="fa fa-photo-video"></i>
                    <span class="ms-2">Posts</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="frames_lay-tab" aria-controls="frames_lay" href="#frames_lay">
                    <i class="fa fa-image"></i>
                    <span class="ms-2">Frames</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="business_lay-tab" aria-controls="business_lay" href="#business_lay">
                    <i class="fa fa-address-card"></i>
                    <span class="ms-2">Bussiness</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="wallet_lay-tab" aria-controls="wallet_lay" href="#wallet_lay">
                    <i class="fa fa-list-alt"></i>
                    <span class="ms-2">Wallet</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false" id="transaction_lay-tab" aria-controls="transaction_lay" href="#transaction_lay">
                    <i class="fa fa-list-alt"></i>
                    <span class="ms-2">Transaction</span>
                  </a>
                </li>
              </ul>
              
              <!--Edit Profile-->
              <div class="tab-content" id="animateLineContent-4">
                  <div class="tab-pane fade show active" id="edit_profile_lay" role="tabpanel" aria-labelledby="edit_profile_lay-tab">
                        
                        <form method="post" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data" >
                            
                            @csrf
                            @method('PUT')
                    
                            <div class="row p-5">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="" class="form-control-label text-sm text-center">User Details </label>
                                  </div>
                                </div>
                        
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">User Name </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">User Email </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">Phone No </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    @if($errors->first('number')) <label class="text-danger">{{$errors->first('number')}}</label> @endif
                                    <input class="form-control" name="number" type="text" value="{{ $user->number }}">
                                  </div>
                                </div>
                                
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">Profile </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" name="profile_pic" id="profile_pic" type="file" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="profilePicValidation()">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label"> </label>
                                  </div>
                                </div>
                                <div class="col-md-10 card-body mt-n3">
                                    <div class="row mb" id="previewProfileImages">
                                        @if(!empty($user->profile_pic))
                                        <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                          <div class='avatar avatar-xxl position-relative'>
                                            <img src='{{ asset($user->profile_pic) }}' id='imge' class='border-radius-md' alt='team-2'>
                                          </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="example-text-input" class="form-control-label">Available Posts Limit</label>
                                            <input class="form-control" name="post_limit" type="number" value="{{ $user->posts_limit }}" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="example-text-input" class="form-control-label">Business Limit</label>
                                            <input class="form-control" name="business_limit" type="number" value="{{ $user->business_limit }}" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="example-text-input" class="form-control-label">Political Limit</label>
                                            <input class="form-control" name="political_limit" type="number" value="{{ $user->political_limit }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-12 mt-3">
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
                      
                      
                        <form method="post" action="{{ url('users/plan/') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row px-5">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="" class="form-control-label text-sm text-center">User Subscription</label>
                                  </div>
                                </div>
                                <div class="col-md-2 ">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">Select Plan </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                      <select class="form-control" id="plan_type" name="plan_name" onchange="onSubscriptionChange()">
                                          <option>Select Subscription</option>
                                          @foreach($subscriptions as $subscription)
                                          <option value="{{$subscription->id}}" @if($subscription->name == $user->subscription_name) selected @endif)>{{$subscription->name}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                       
                                </div>
                                <input name="user_id" type="hidden" value="{{ $user->id }}">
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">Start date </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" id="start_date" name="start_date" type="date" value="{{ $user->subscription_date }}" required>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">End date </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" id="end_date" name="end_date" type="date" value="{{ $user->subscription_end_date }}" required>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label"></label>
                                  </div>
                                </div>
                                <div class="col-md-10">
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
                  
                  <div class="tab-pane fade" id="user_post_lay" role="tabpanel" aria-labelledby="user_post_lay-tab">
                      <div class="row p-2" >
                        @foreach ($posts as $post)
                        
                    <div class="col-lg-4 col-sm-6 col-xs-12 p-2  bg-transparent">
                        
                      <div style="height:240px;background-size: cover;@if(!str_contains($post->post_url,'.mp4')) background-image: url({{url($post->post_url)}}); @endif" class="border-radius-xl">
                          
                          <div class="position-absolute ">
                              @if(str_contains($post->post_url,'.mp4'))
                              <video class="border-radius-xl position-absolute" width="100%" height="240px" preload="metadata" style="background:gray;object-fit: cover;">
                                  <source src="{{asset($post->post_url)}}#t=6">
                              </video>
                              @endif
                        <div class="card-body position-relative z-index-1 p-3">
                            
                            <div class="mt-9" >
                                
                                <div class="d-flex mt-2" >
                                  <div>
                                    <a class="btn btn-icon-only btn-rounded btn-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center" href="{{asset($post->post_url)}}">
                                        <i class="fas fa-play"></i>
                                    </a>
                                  </div>
                                  
                                  <div>
                                    <button class="btn btn-icon-only btn-rounded btn-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center" data-id="{{$post->id}}" data-toggle="modal" data-target="#deletePostModal">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                  </div>
                                  
                                </div>
                            
                                <form action="{{ url('deleteuserpost/') }}" method="POST" id="form-post-{{ $post->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                </form>
                            </div>
                          </div>
                          </div>
                          
                          
                        
                        </div>
                        
                     </div>
                        @endforeach
                      </div>
                  </div>
                  
                  <div class="tab-pane fade" id="frames_lay" role="tabpanel" aria-labelledby="frames_lay-tab">
                      <div class="row p-2" >
                        @foreach ($frames as $frame)
                        <div class="col-xl-4 col-l-4 col-sm-6 p-2  bg-transparent">
                          <div style="background-image: url({{asset($frame->item_url)}});height:200px;background-size: cover;" class="border-radius-xl">
                            <div class="card-body position-relative z-index-1 p-3">
                                <div class="mt-8 pt-3" >
                                    <div class="d-flex" >
                                      <div>
                                        <button class="btn btn-icon-only btn-rounded btn-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"  data-id="{{$frame->id}}" data-toggle="modal" data-target="#deleteFrameModal">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        
                                      </div>
                                      <div class="form-switch align-items-center justify-content-center" >
                                         <input class="form-check-input frame-switch" type="checkbox" data-id="{{$frame->id}}" @if($frame->status==0) checked @endif>
                                      </div>
                                    </div>
                                    <form action="{{ url('deleteuserframe/') }}" method="POST" id="frame-form-{{$frame->id}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$frame->id}}">
                                    </form>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        @endforeach
                        
                        <div class="col-xl-4 col-l-4 col-sm-6 p-2  bg-transparent">
                          <div class="border-radius-xl" >
                            <div class="card-body px-3 border-radius-xl" style="height:200px;background:#DFDFDF">
                                <div class="text-center" data-toggle="modal" data-target="#frameUploadModal">
                                  <img class="justify-content-center mt-4" style="height:100px;width100px;" src="https://cdn-icons-png.flaticon.com/512/61/61183.png">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane fade" id="business_lay" role="tabpanel" aria-labelledby="business_lay-tab">
                        <div class="card-body pt-4 p-3">
                          <a href="{{ url('users-add-business/'.$user->id)}}" class="btn btn-success "><i class="fas fa-plus"></i>  Add New</a>
                          <ul class="list-group">
                            @foreach($businesses as $business)
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex py-1">
                                  <div>
                                    <img src="@if($business->image) {{url($business->image)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  
                                </div>
                              <div class="d-flex flex-column">
                                <h5 class="mb-2 text-sm">{{ $business->name }}</h5>
                                <span class="mb-0 text-xs">{{ $business->about }}</span>
                              </div>
                              <div class="ms-auto text-end">
                                <a class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt" data-id="{{$business->id}}" data-toggle="modal" data-target="#deleteBussinessModal"></i></a>
                                <a href="{{ url('usersbusiness/'.$business->id.'/edit') }}" class="btn btn-icon-only btn-rounded btn-success"><i class="fas fa-pencil-alt"></i></a>
                                
                              </div>
                              <form action="{{ url('deleteuserbussines/') }}" method="POST" id="business-form-{{$business->id}}">
                                  @csrf
                                  <input type="hidden" name="id" value="{{$business->id}}">
                              </form>
                            </li>
                            
                            @endforeach
                          </ul>
                        </div>
                   </div>
                   
                  <div class="tab-pane fade" id="transaction_lay" role="tabpanel" aria-labelledby="transaction_lay-tab">
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Promocode</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Id</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($transactions as $transaction)
                                   <tr>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->id }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->plan }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ App\Models\Setting::getValue('currency') }} {{ $transaction->amount }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->promocode }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->transaction_id }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($transaction->created_at))}}</span>
                                        </td>
                                        
                                   </tr>
                                   
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                
                
                <div class="tab-pane fade" id="wallet_lay" role="tabpanel" aria-labelledby="wallet_lay-tab">
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($usertransactions as $transaction)
                                   <tr>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->id }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->title }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ App\Models\Setting::getValue('currency') }} {{ $transaction->amount }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaction->type }}</p>
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($transaction->created_at))}}</span>
                                        </td>
                                        
                                   </tr>
                                   
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                
                
              </div>
              <!--End Edit Profile-->
              
              
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
</div>

<div id="frameUploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Add new custome frame</p>
        </div>
        <div class="modal-content">
            <form id="frame_upload_form" method="post" action="addframe" enctype="multipart/form-data">
                @csrf
                <input name="user_id" type="hidden" value="{{$user->id}}">
                <div class="row p-3">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="text-center" class="form-control-label">Select Frame</label>
                        <input class="form-control" id="frame_file" name="image" type="file" onchange="onFrameInputChange();" required accept=".png">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                          <div class='avatar avatar-xxl position-relative'>
                            <img src='{{url("/images/placeholder.jpg")}}' id='frameImage' class='border-radius-md' alt='team-2'>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Upload</button>
          @else
          <button id="frame_upload_btn" class="btn btn-danger">Upload</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div id="deleteBussinessModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="delete_business_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="delete_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div id="deleteFrameModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="delete_frame_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div id="deletePostModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="delete_post_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div id="sendModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Do you really want to send message on whatsapp ?</p>
            
        </div>
        <div class="m-3">
            <div class="row">
                <div class="col-md-12">
                  <div class="form-group" id="type_lay">
                    <label for="example-text-input" class="form-control-label">Message Tamplate</label>
                    
                        <select class="form-control" id="msg_id" name="msg_id" required>
                            @foreach($whatsapp_messages as $message)
                            <option class="res-txt" value="{{ $message->id }}"> {{ $message->msg }} </option>
                            @endforeach
                        </select>
                    
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group d-flex" id="type_lay">
                    @if(Session::get('admin_type') == "Demo")
                    <button class="btn btn-danger demo_action" data-dismiss="modal">Send</button>
                    @else
                    <button id="send_btn" class="btn btn-danger" data-dismiss="modal">Send</button>
                    @endif
                    <button class="btn btn-default ms-2" data-dismiss="modal">Close</button>
                  </div>
                </div>
                
               
            </div>
        </div>
        
      </div>
    </div>
</div>
<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    
    $('#start_date').attr('min',today);
    $('#end_date').attr('min',today);
    
    $("#frame_upload_btn").on("click",function(){
        $("#frame_upload_form").submit();
    });
    
    $("#deleteBussinessModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_business_btn").attr("data-submit",id);
    });
    
    
    $("#delete_business_btn").on("click",function(){
        var id = $(this).data("submit");
        $("#business-form-"+id).submit();
    });
    
    $("#deleteFrameModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_frame_btn").attr("data-submit",id);
    });
    
    
    $("#delete_frame_btn").on("click",function(){
        var id = $(this).data("submit");
        $("#frame-form-"+id).submit();
    });
    
    
    $("#deletePostModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_post_btn").attr("data-submit",id);
    });
    
    
    $("#delete_post_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-post-"+id).submit();
    });
    
    $("#deleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_btn").attr("data-submit",id);
    });
    
    $("#delete_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-user-"+id).submit();
    });
    
    $("#block_btn").on("click",function(){
        
        var checked = true;
        if($(this).val() == 0){
            checked = false;
            $(this).attr('value', '1');
            document.getElementById('block_btn').innerHTML = "Unblock User";
        }else{
            $(this).attr('value', '0');
            document.getElementById('block_btn').innerHTML = "Block User";
        }
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/users-status') }}",
          data: { checked : checked , id : '{{$user->id}}' },
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("User Activated");
              }else{
                  toastr.success("User Deactivated");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    
    function onSubscriptionChange() {
        id = document.getElementById("plan_type").value;
        $.ajax({
          type: "POST",
          url: "{{url('get-subscription-info')}}",
          data: { id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              console.log(data);
            $("#start_date").val(data['start_date']);
            $("#end_date").val(data['end_date']);
          },
        });
    }
    
    function onFrameInputChange(){
        var fileInput = document.getElementById('frame_file');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("frameImage").src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    function profilePicValidation(){
        var fileInput = document.getElementById('profile_pic');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewProfileImages").innerHTML = "";
                $('#previewProfileImages').append(
                "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
                  "<div class='avatar avatar-xxl position-relative'>"+
                    "<img src='"+e.target.result+"' id='imge' class='border-radius-md' alt='team-2'>"+
                  "</div>"+
                "</div>");
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    
    $(".frame-switch").change(function(){
        var checked = $(this).is(':checked');
        var id = $(this).data("id");
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/users/frame-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Frame Activated");
              }else{
                  toastr.success("Frame Deactivated");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    $(document).ready(function () {
        create_custom_dropdowns();
    });
    
    $("#sendModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#send_btn").attr("data-submit",id);
    });
    
    $("#send_btn").on("click",function(){
        var id = $(this).data("submit");
        var msg_id = document.getElementById("msg_id").value;
        // alert(msg_id);
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/send-single-user-msg') }}",
          data: { user_id : id,msg_id : msg_id },
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              console.log(data);
              toastr.success("Msg Send Successfully");
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    
</script>
@endsection