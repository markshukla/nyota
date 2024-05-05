@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Edit Offer Dialog</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('offerdialog.update',$offerdialog->id) }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        
                        <div class="col-md-6">
                          <div class="form-group" id="type_lay">
                            <label for="example-text-input" class="form-control-label">Select Type <b style="color:red">{{ $errors->first('type') }}</b></label>
                            
                                <select class="form-control" id="type" name="type" onchange="onTypeChange()" required>
                                    <option value="custom" >Custom</option>
                                    <option value="category" @if($offerdialog->action == "category") selected @endif>Category</option>
                                    <option value="subscription" @if($offerdialog->action == "subscription") selected @endif>Subscription</option>
                                    <option value="url" @if($offerdialog->action == "url") selected @endif>Url</option>
                                </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Image <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="action_lay">
                                @if($offerdialog->action == "category")
                                <label for="example-text-input" class="form-control-label">Select Category</label>
                                <select class="form-control" id="type" name="category" required>
                                    @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @if($c->id == $offerdialog->action_item) selected @endif>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                
                                @elseif($offerdialog->action == "subscription")
                                
                                <label for="example-text-input" class="form-control-label">Select Category</label>
                                <select class="form-control" id="type" name="category" required>
                                    @foreach ($subscriptions as $c)
                                    <option value="{{ $c->id }}" @if($c->id == $offerdialog->action_item) selected @endif>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                
                                @elseif($offerdialog->action == "url")
                                
                                <label for="example-text-input" class="form-control-label">Url <b style="color:red">{{ $errors->first("title") }}</b></label>
                                <input class="form-control" name="url" type="text" value="{{ $offerdialog->action_item }}" required> 
                                @endif
                          </div>
                        </div>
                        
                        <div class="col-md-12 card-body mt-n3">
                            <div class="row mb" id="previewImages">
                                <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                  <div class='avatar avatar-xxl position-relative'>
                                    <img src='{{ asset($offerdialog->item_url) }}' id='imge' class='border-radius-md' alt='team-2'>
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

    
    function onTypeChange() {
        d = document.getElementById("type").value;
        // $('#type_lay').empty();
        // $('#type_lay').append(
        //         '<label for="example-text-input" class="form-control-label">Select Type</label>'+
        //         '<select name="subscription" onchange="onTypeChange()"  id="type" class="form-control" required>'+
        //         '<option value="custom">Custom</option>'+
        //         '<option value="category">Category</option>'+
        //         '<option value="subscription">Subscription</option>'+
        //         '<option value="url">Url</option>'+
        //         '</select>');
                
        if(d == 'custom'){
            $('#action_lay').empty();
        }else if(d == 'url'){
            $('#action_lay').empty();
            $('#action_lay').append(
            '<label for="example-text-input" class="form-control-label">Url <b style="color:red">{{ $errors->first("title") }}</b></label>'+
            '<input class="form-control" name="url" type="text" placeholder="www.google.com" required>');
        }else if(d == 'category'){
            $('#action_lay').empty();
            $('#action_lay').append(
                '<label for="example-text-input" class="form-control-label">Select Category</label>'+
                '<select name="category" class="form-control" required>'+
                '<option value="">Select Category</option>@foreach($categories as $c)<option value="{{$c->id}}">{{$c->name}}</option>@endforeach</select>');
        }else if(d == 'subscription'){
            $('#action_lay').empty();
            $('#action_lay').append(
                '<label for="example-text-input" class="form-control-label">Select Subscription</label>'+
                '<select name="subscription" class="form-control" required>'+
                '<option value="">Select Subscription</option>@foreach($subscriptions as $c)<option value="{{$c->id}}">{{$c->name}}</option>@endforeach</select>');
        }
        create_custom_dropdowns();
    }

    function fileValidation(){
        var fileInput = document.getElementById('image_posts');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewImages").innerHTML = "";
                $('#previewImages').append(
                "<div class='imageCard col-xl-4 col-sm-4 mb-2'>"+
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