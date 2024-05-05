@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Whatsapp Message</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('whatsappmessage.store') }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    
                    <div class="row">
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Message *<b style="color:red">{{ $errors->first('message') }}</b></label>
                            <textarea class="form-control" name="message" type="text" placeholder="Write message here" required ></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="type_lay">
                            <label for="example-text-input" class="form-control-label">Select Type *<b style="color:red">{{ $errors->first('type') }}</b></label>
                            
                                <select class="form-control" id="type" name="type" onchange="onTypeChange()" required>
                                    <option value="text" >Text Message</option>
                                    <option value="media" >Media Message</option>
                                    <option value="button" >Button Message</option>
                                </select>
                            
                          </div>
                        </div>
                        
                        
                        
                        
                        <div class="row" id="action_lay">
                          
                        </div>
                        
                        <div class="col-md-6 card-body mt-n3">
                            <div class="row mb" id="previewImages">
                                
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12" >
                          <div class="form-group">
   
                            @if(Session::get('admin_type') == "Demo")
                              <div class="btn btn-primary col-md-6 demo_action">Create</div>
                              @else
                              <input class="btn btn-primary col-md-6" type="submit" value="Create">
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
                
        if(d == 'text'){
            $('#action_lay').empty();
        }else if(d == 'media'){
            $('#action_lay').empty();
            $('#previewImages').empty();
            $('#action_lay').append(
                
            '<div class="col-md-6">'+
              '<div class="form-group">'+
                '<label for="example-text-input" class="form-control-label">Image *<b style="color:red">{{ $errors->first("image_posts") }}</b></label>'+
                '<input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()" required>'+
              '</div>'+
            '</div>'
            
            );
        }else if(d == 'button'){
            $('#action_lay').empty();
            $('#action_lay').append(
                '<div class="col-md-4">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Btn1 *</label>'+
                    '<input class="form-control" name="btn1" type="text" placeholder="Open Now" required>'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-4">'+
                  '<div class="form-group" id="btn1type_lay">'+
                    '<label for="example-text-input" class="form-control-label">Btn1 Type *</label>'+
                        '<select class="form-control" id="btn1type" name="btn1type" required>'+
                            '<option value="replyButton" >Reply Button</option>'+
                            '<option value="callButton" >Call Button</option>'+
                            '<option value="urlButton" selected>Url Button</option>'+
                        '</select>'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-4">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Btn1 Value *</label>'+
                    '<input class="form-control" name="btn1value" type="text" placeholder="{{ url("") }}" required>'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-4">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Btn2</label>'+
                    '<input class="form-control" name="btn2" type="text" placeholder="Call Now">'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-4">'+
                  '<div class="form-group" id="btn2type_lay">'+
                    '<label for="example-text-input" class="form-control-label">Btn2 Type</label>'+
                        '<select class="form-control" id="btn2type" name="btn2type">'+
                            '<option value="replyButton" >Reply Button</option>'+
                            '<option value="callButton" selected>Call Button</option>'+
                            '<option value="urlButton" >Url Button</option>'+
                        '</select>'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-4">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Btn2 Value</label>'+
                    '<input class="form-control" name="btn2value" type="text" placeholder="{{App\Models\Setting::getValue("contact_number")}}">'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Image <b style="color:red">{{ $errors->first("image_posts") }}</b></label>'+
                    '<input class="form-control" type="file" id="image_posts" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()">'+
                  '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                  '<div class="form-group">'+
                    '<label for="example-text-input" class="form-control-label">Footer</label>'+
                    '<input class="form-control" name="footer" type="text" placeholder="Footer">'+
                  '</div>'+
                '</div>'
            );
            create_custom_dropdowns();
        }
        
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