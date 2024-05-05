@extends('main')

@section('content')
    @if($admin->id == 1 && Session::get('userid') != 1)
        <script>window.location = "{{ url('/') }}" </script>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Edit Admin</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('admins.update',$admin->id) }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Username <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="username" type="text" value="{{ $admin->username }}">
                          </div>
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Email <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="email" type="email"  value="{{ $admin->email }}">
                          </div>
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Password <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="password" autocomplete="off" type="password" >
                          </div>
                          
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Profile <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()">
                          </div>
                           
                           <div class="col-md-12 card-body mt-n3">
                               <div class="row mb" id="previewImages">
                                   <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                     <div class='avatar avatar-xxl position-relative'>
                                       <img src='{{ asset($admin->profile_pic) }}' id='imge' class='border-radius-md' alt='team-2'>
                                     </div>
                                   </div>
                               </div>
                           </div>
                           
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class=" font-weight-bolder text-sm">Permissions</h6>
                            <table class="table">
                                <thead>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Section</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="section" @if($permission['section']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Category</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="category" @if($permission['category']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="font-weight-bolder text-sm">Posts</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="posts" @if($permission['posts']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class="font-weight-bolder text-sm">Greeting</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="greeting" @if($permission['greeting']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Video</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="video" @if($permission['video']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Slider</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="slider" @if($permission['slider']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Frame</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="frame" @if($permission['frame']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Subscription</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="subscription" @if($permission['subscription']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Offer Dialog</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="offerdialog" @if($permission['offerdialog']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Push Notification</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="pushnotification" @if($permission['pushnotification']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Contacts</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="contacts" @if($permission['contacts']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Transaction</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="transaction" @if($permission['transaction']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">User</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="user" @if($permission['user']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">Setting</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="setting" @if($permission['setting']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" font-weight-bolder text-sm">Admin</td>
                                        <td class="text-center">
                                            <div class="form-switch align-items-center justify-content-center" >
                                               <input name="admin" @if($permission['admin']=='true') checked @endif class="form-check-input status-switch" type="checkbox">
                                            </div>
                                        </td>
                                        <td class=" font-weight-bolder text-sm">
                                            -
                                        </td>
                                        <td class="text-center">
                                            -
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                        <div class="col-md-12" >
                          <div class="form-group">
   
                            @if(Session::get('admin_type') == "Demo")
                            <div class="btn btn-primary col-md-6 demo_action">Submit</div>
                            @else
                            <input class="btn btn-primary col-md-6" type="submit" value="Submit">
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
<!--<p class='remove pull-right bg-danger' style='cursor:pointer;position: absolute;top: 0px;right: 15px;padding: 6px 10px;' id='"+i+"'><i class='fa fa-close'></i></p>-->
<script type="text/javascript">

    function fileValidation(){
        var fileInput = document.getElementById('image_posts');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewImages").innerHTML = "";
                $('#previewImages').append(
                "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
                  "<div class='avatar avatar-xxl position-relative'>"+
                    "<img src='"+e.target.result+"' id='imge' class='border-radius-md' alt='team-2'>"+
                  "</div>"+
                "</div>");
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    
    $(document).ready(function () {
        create_custom_dropdowns();
    });
    
    
</script>
@endsection