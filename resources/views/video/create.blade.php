@extends('main')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Video Post</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('video.store') }} " id="addform" enctype="multipart/form-data" >
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
                            
                            <select class="fstdropdown-select form-control" id="type_select" name="type" required>
                                <option value="festival" selected>Festival</option>
                                <option value="business">Business</option>
                                <option value="political">Political</option>
                                <option value="custom">Custom</option>
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
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Category</label>
                            
                            <select class="fstdropdown-select form-control" id="category_id" name="category" required>
                                @foreach ($festivals as $festival)
                                <option value="{{ $festival->id }}" selected>{{ $festival->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Video<b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="video" name="video" accept=".mp4" onchange="videoPreview()" required="required">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Sub Category<label class="text-sm"> (optional)</label></label>
                            
                            <select class="fstdropdown-select form-control" id="sub_category_id" name="subcategory">
                               
                                <option>Select Sub Category</option>
                            </select>
                            
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
    
    $("#type_select").change(function() {
        var type = $(this).val();
        $.ajax({
            type: "GET",
            url: "/get-category-by-type",
            data: {type : type},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                $('#category_id').empty();
                for (const val of data) {
                    try {
                        $('#category_id').append('<option value='+val.id+'>'+val.name+'</option>');
                    } catch (e) {
                        console.log(e.message);
                    }
                   
                    
                }
                document.getElementById("category_id").fstdropdown.rebind();
            },
        });
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