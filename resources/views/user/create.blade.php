@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                  
                <p class="mb-0 font-weight-bolder">Add User</p>
                <label class="btn btn-{{ $errors->any() ? 'warning' : 'primary'  }} btn-sm ms-auto">{{$errors->any ? $errors->first() : ''}}
                </label>

              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('users.store') }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Enter Name<b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="name" type="text" placeholder="name" required>
                          </div>
                          
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Enter Email<b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="email" type="text" placeholder="email" required>
                          </div>
                          
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Enter Number<b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="number" type="text" placeholder="number" required>
                          </div>
                          <div class="form-group">
                              <label for="example-text-input" class="form-control-label">Login with</label>
                               <select class="form-control" id="loginus" name="loginus">
                                  <option value="google">Email</option>
                                  <option value="phone">Phone</option>
                               </select>
                         </div>
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Profile Pic <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()" required>
                          </div>
                          
                          <div class="form-group row mb" id="previewImages">
                                
                          </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <!--<label for="example-text-input" class="form-control-label">User Plan:</label>-->
                            <div class="row">
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
                                          <option value="{{$subscription->id}}">{{$subscription->name}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                       
                                </div>
                                
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">Start date </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" id="start_date" name="start_date" type="date" value="">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label">End date </label>
                                  </div>
                                </div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input class="form-control" id="end_date" name="end_date" type="date" value="" >
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="text-center" class="form-control-label"></label>
                                  </div>
                                </div>
                               
                            </div>
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