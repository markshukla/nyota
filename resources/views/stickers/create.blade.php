@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Sticker</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('sticker.store') }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" placeholder="Diwali" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Category <b style="color:red">{{ $errors->first('type') }}</b></label>
                            
                                <select class="form-control" id="category" name="category" required>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Image <b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                             <input class="form-control" type="file" id="image_posts" name="image_posts[]" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="imagePreview()" multiple required="required">
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