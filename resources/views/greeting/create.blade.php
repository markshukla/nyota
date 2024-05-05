@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Greeting Post</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('greeting.store') }} " id="addform" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" placeholder="Happy diwali" >
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Section <b style="color:red">{{ $errors->first('category') }}</b></label>
                            
                            <select class="form-control" name="category" required="required">
                                @foreach ($sections as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Premium <b style="color:red">{{ $errors->first('premium') }}</b></label>
                            <select class="form-control" name="premium" required="required">
                                <option value="0">Free</option>
                                <option value="1">Premium</option>
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
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Greeting Images <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="image_posts" name="image_posts[]" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="imagePreview()" multiple required="required">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">
                                <small class="form-text text-muted">
                                    Recommendation Post Size: 
                                    <ul>
                                        <li>1024*1024 px (1:1 Square)</li>
                                        <li>1080*1350 px (4:5 Portrait)</li>
                                        <li>1280*720 px (16:9 Landscap)</li>
                                        <li>1080*1920 px (9:16 Story)</li>
                                    </ul>
                                </small>
                            </label>
                          </div>
                        </div>
                        
                        
                        <input type="hidden" name="removed_files" class="removed_files" id="removed_files"  value="[]">
                        
                        <div class="col-md-12 card-body mt-n3">
                            <div class="row mb" id="previewImages">
                                
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

    function imagePreview(fileInput) 
    {
        window.newFileList = [];
        var total_file = document.getElementById("image_posts").files.length;
        document.getElementById("previewImages").innerHTML = "";
        document.getElementById('removed_files').value = '';
        
        for(var i=0;i<total_file;i++)
        {
            $('#previewImages').append(
            "<div class='imageCard col-xl-2 col-sm-3 mb-2'>"+
              "<div class='avatar avatar-xxl position-relative'>"+
                "<img src='"+URL.createObjectURL(event.target.files[i])+"' id='imge' class='border-radius-md' alt='team-2'>"+
                "<a id='"+i+"' class='remove_img btn btn-sm btn-icon-only bg-gradient-danger position-absolute end-0 mb-n2 me-n2'>"+
                  "<i class='fa fa-close top-0'></i>"+
                  "<span class='sr-only'>Edit Image</span>"+
                "</a>"+
              "</div>"+
            "</div>");
            
            
        }
    }
    
    window.newFileList = [];
    $(document).on('click', 'a.remove_img', function( e ) {
        e.preventDefault();
        var id = $(this).attr('id');
        
        $(this).closest( 'div.imageCard' ).remove();
        
        var input = document.getElementById('image_posts');
        var files = input.files;
        if (files.length) {
            if (typeof files[id] !== 'undefined') {
                window.newFileList.push(files[id].name)
            }
        }
        document.getElementById('removed_files').value = JSON.stringify(window.newFileList);
        if($(".imageCard").length == 0) document.getElementById('image_posts').value="";
    });
    
    $(document).ready(function () {
        create_custom_dropdowns();
    });

</script>
@endsection