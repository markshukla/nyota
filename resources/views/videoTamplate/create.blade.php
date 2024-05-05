@extends('main')

@section('content')
    
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Video Tamplate</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('videotamplate.store') }} " id="addform" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" placeholder="Happy diwali" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Type</label>
                            
                            <select class="form-control" id="type" name="type" required>
                                <option value="business" selected>Festival</option>
                                <option value="business">Business</option>
                                <option value="political">Political</option>
                                <option value="political">Custom</option>
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Language <b style="color:red">{{ $errors->first('language') }}</b></label>
                            
                            <select class="form-control" name="language" required="required">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->language_code }}">{{ $language->language_name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Category</label>
                            
                            <select class="form-control" id="category" name="category" required>
                                @foreach ($categories as $festival)
                                <option value="{{ $festival->id }}" selected>{{ $festival->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Video<b style="color:red">{{ $errors->first('video') }}</b></label>
                            <input class="form-control" type="file" id="video" name="video" accept=".mp4" onchange="videoPreview()" required="required">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Zip<b style="color:red">{{ $errors->first('zip') }}</b></label>
                            <input class="form-control" type="file" id="zip" name="zip" accept=".zip" required="required">
                          </div>
                        </div>
                        
                        <div class="card-body mt-n3">
                            <div class="mb" id="previewImages">
                                <video width="250" height="auto" controls>
                                   <source id="videoplayer">
                                </video>
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

    $("#video").change(function () {
        
        var $source = $('#videoplayer');
        
        $source[0].src = URL.createObjectURL(this.files[0]);
        
        $source.parent()[0].load();
        
    });
    
    $(document).ready(function () {
        create_custom_dropdowns();
    });

</script>
@endsection