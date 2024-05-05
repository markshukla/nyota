@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Subscription</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('subscription.store') }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Enter Name<b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" placeholder="Starter" required>
                          </div>
                          
                          <div class="form-group">
                            <div class="">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="example-text-input" class="form-control-label">Price {{ App\Models\Setting::getValue('currency') }}</label>
                                        <input class="form-control" name="price" type="number" value="0" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="example-text-input" class="form-control-label">Discount Price {{ App\Models\Setting::getValue('currency') }}</label>
                                        <input class="form-control" name="discount_price" type="number" value="0" required>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Enter Duration</label>
                            <div class="">
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-control" name="value" type="number" placeholder="30" required>
                                    </div>
                                    <div class="col-6">
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="DAY" >Day</option>
                                        <option value="WEEK" >Week</option>
                                        <option value="MONTH" >Month</option>
                                        <option value="YEAR" >Year</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                          </div>
                          
                          <div class="form-group">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="example-text-input" class="form-control-label">Posts Limit</label>
                                        <input class="form-control" name="post_limit" type="number" placeholder="10" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="example-text-input" class="form-control-label">Business Limit</label>
                                        <input class="form-control" name="business_limit" type="number" placeholder="2" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="example-text-input" class="form-control-label">Political Limit</label>
                                        <input class="form-control" name="political_limit" type="number" placeholder="2" required>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Image <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()" required>
                          </div>
                          
                          <div class="form-group row mb" id="previewImages">
                                
                          </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <label for="example-text-input" class="form-control-label">Plan Benefit :</label>
                            <div class="text-center">
                                <span id="add_plan"><i class="btn btn-primary col-md-12 fa fa-plus"></i></span>
                            </div>
                                    
                            <div id="add_text">
                                
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
    
    $(function() {
        $('#add_plan').on('click', function(e){
            e.preventDefault();
            $('#add_text').append('<div class="row mb-2"><div class="col-11"><input type="text" class="form-control" name="detail[]" placeholder="Enter Detail"></div><div class="col-1"><button type="button" class="btn btn-danger remove"><i class="fa fa-close"></i></button></div></div>');
        });
        $(document).on('click', 'button.remove', function( e ) {
            e.preventDefault();
            $(this).closest( 'div.row' ).remove();
        });
    });
    
    $(document).ready(function () {
        create_custom_dropdowns();
    });

</script>
@endsection