@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Edit Music</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('music.update',$music->id) }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                        <input class="form-control" name="title" type="text" placeholder="Diwali" value="{{ $music->title }}">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Category <b style="color:red">{{ $errors->first('category') }}</b></label>
                            
                            <select class="form-control" name="category" required="required">
                                @foreach ($categories as $c)
                                    <option value="{{$c->id}}" @if($c->id == $music->category_id) selected @endif>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Language <b style="color:red">{{ $errors->first('language') }}</b></label>
                            
                            <select class="form-control" name="language" required="required">
                                @foreach ($languages as $lan)
                                    <option value="{{ $lan->language_code }}" @if($lan->language_code == $music->language) selected @endif>{{ $lan->language_name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Music</label>
                            <input class="form-control" type="file" id="music" name="music" accept=".mp3">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()">
                          </div>
                        </div>
                        
                        
                        
                        
                        <div class="col-md-12 card-body mt-n3">
                            <div class="row mb" id="previewImages">
                                <div class='imageCard col-xl-2 col-sm-3 mb-2'>
                                  <div class='avatar avatar-xxl position-relative'>
                                    <img src='{{ asset($music->thumbnail) }}' id='imge' class='border-radius-md' alt='team-2'>
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
        if(d == 'festival'){
            $('#date_lay').append(
            '<label for="example-text-input" class="form-control-label">Festival Date <b style="color:red">{{ $errors->first("title") }}</b></label>'+
            '<input class="form-control" name="date" type="date" required="">');
        }else{
            $('#date_lay').empty();
        }
    }

    function fileValidation(){
        var fileInput = document.getElementById('image');
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