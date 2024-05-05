@extends('main')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Business Post</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('business.store') }} " id="addform" enctype="multipart/form-data" >
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
                            <label for="example-text-input" class="form-control-label">Select Category <b style="color:red">{{ $errors->first('category') }}</b></label>
                            
                            <select class="fstdropdown-select form-control" id="category_id" name="category" required="required">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input"  class="form-control-label">Select Sub Category</label>
                            
                            <select class="fstdropdown-select form-control" id="sub_category_id" name="subcategory">
                                <option value="">Select Sub Category</option>
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Premium <b style="color:red">{{ $errors->first('premium') }}</b></label>
                            <select class="fstdropdown-select form-control" name="premium" required="required">
                                <option value="0">Free</option>
                                <option value="1">Premium</option>
                            </select>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Language <b style="color:red">{{ $errors->first('language') }}</b></label>
                            
                            <select class="fstdropdown-select form-control" name="language" required="required">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->language_code }}">{{ $language->language_name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6" id="post_type_lay">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Post Type</label>
                            
                            <select class="fstdropdown-select form-control" name="post_type" id="post_type" onchange="typeChange()">
                                <option>Select Type</option>
                                <option value="images">Images</option>
                                <option value="tamplate">Tamplate</option>
                            </select>
                            
                          </div>
                        </div>
                        
                        <div id="include_lay" class="row">
                            
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
    
    function fileValidation(){
        var fileInput = document.getElementById('thumbnail');
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
    
    var tamplate_lay = '<div class="col-md-6" id="pick_zip_lay">'+
                            '<div class="form-group">'+
                            '<label for="example-text-input" class="form-control-label">Zip</label>'+
                            '    <input class="form-control" type="file" name="zip_file" accept=".zip">'+
                            '  </div>'+
                            '</div>'+
                            
                            '<div class="col-md-6" id="thumbnail_lay">'+
                              '<div class="form-group">'+
                                '<label for="example-text-input" class="form-control-label">Thumbnail <b style="color:red">{{ $errors->first("image_posts") }}</b></label>'+
                                '<input class="form-control" type="file" id="thumbnail" name="thumbnail" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()" required>'+
                              '</div>'+
                            '</div>';
    var images_lay = '<div class="col-md-6">'+
                              '<div class="form-group">'+
                                '<label for="example-text-input" class="form-control-label">Posts Images <b style="color:red">{{ $errors->first("image_posts") }}</b></label>'+
                                '<input class="form-control" type="file" id="image_posts" name="image_posts[]" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="imagePreview()" multiple required="required">'+
                              '</div>'+
                            '</div>'+
                            
                            '<div class="col-md-6">'+
                              '<div class="form-group">'+
                                '<label for="example-text-input" class="form-control-label">'+
                                    '<small class="form-text text-muted">'+
                                        'Recommendation Post Size:'+
                                        '<ul>'+
                                            '<li>1024*1024 px (1:1 Square)</li>'+
                                            '<li>1080*1350 px (4:5 Portrait)</li>'+
                                            '<li>1280*720 px (16:9 Landscap)</li>'+
                                            '<li>1080*1920 px (9:16 Story)</li>'+
                                        '</ul>'+
                                    '</small>'+
                                '</label>'+
                              '</div>'+
                            '</div>';
                            
    function typeChange(){
        d = document.getElementById("post_type").value;
        if(d == "tamplate"){
            $('#include_lay').append(tamplate_lay);
        }else{
            $('#include_lay').append(images_lay);
        }
        document.getElementById("post_type_lay").remove();
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
    
    $('#category_id').on('change', function () {
        var id = $(this).val();
        
        $.ajax({
            type: "GET",
            url: "/get-sub-category-by-id",
            data: {id : id},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                $('#sub_category_id').empty();
                $("#sub_category_id").append('<option value="">Select Sub Category</option>');
                for (const val of data) {
                    try {
                        $('#sub_category_id').append('<option value='+val.id+'>'+val.name+'</option>');
                    } catch (e) {
                        console.log(e.message);
                    }
                   
                    
                }
                document.getElementById("sub_category_id").fstdropdown.rebind();
            },
        });
        
    });
    

</script>
@endsection