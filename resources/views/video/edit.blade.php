@extends('main')

@section('content')
    
    <style>
.video-control {
	
	left: 1em;
	/*min-width: 7.5em;*/
	padding: 0.2em 0.5em 0.5em 0.5em;
	border-radius: 9in;
	background: #FFF;
}

.video-control:not(.playing) .video-control-pause,
.video-control.playing .video-control-play {
	display: none;
}

.video-control-symbol
{
	font: 0.8em/0 Apple Color Emoji;
	vertical-align: -0.15em;
}
    </style>
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Edit Video Post</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('video.update',$video->id) }} " id="addform" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" value="{{ $video->title }}" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Type</label>
                            
                            <select class="fstdropdown-select form-control" id="type_select" name="type" required>
                                <option value="festival" @if($video->type == "festival") selected @endif>Festival</option>
                                <option value="business" @if($video->type == "business") selected @endif>Business</option>
                                <option value="custom" @if($video->type == "custom") selected @endif>Custom</option>
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Language <b style="color:red">{{ $errors->first('language') }}</b></label>
                            
                            <select class="fstdropdown-select form-control" name="language" required="required">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->language_code }}" @if($video->language == $language->language_code) selected @endif>{{ $language->language_name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Category</label>
                            
                            <select class="fstdropdown-select form-control" id="category_id" name="category" required>
                                
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($video->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach

                                
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Video<b style="color:red">{{ $errors->first('image_posts') }}</b></label>
                            <input class="form-control" type="file" id="video" name="video" accept=".mp4" onchange="videoPreview()">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Sub Category<label class="text-sm"> (optional)</label></label>
                            
                            <select class="fstdropdown-select form-control" id="sub_category_id" name="subcategory">
                               
                                <option>Select Sub Category</option>
                                 @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @if($video->sub_category_id == $subcategory->id) selected @endif>{{ $subcategory->name }}</option>
                                 @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="card-body mt-n3">
                            <div class="mb" id="previewImages">
                                
                            <div class="bg-transparent">
                              <div style="height:240px;background-size: cover;" class="border-radius-xl">
                                  <div class="position-absolute">
                                      <video id="playerElement" class="border-radius-xl position-absolute" width="250" height="auto" style="background:gray;object-fit: cover;">
                                          <source id="videoplayer" src="{{ asset($video->item_url) }}">
                                      </video>
                                  <div class="card-body position-relative z-index-1 p-3">
                                      <a href="javascript:" class="video-control" id="PlayButton">
	                                    	<span class="video-control-play">
	                                    		<span class="video-control-symbol" aria-hidden="true">▶️</span>
	                                    		<span class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Play</span>
	                                    	</span>
	                                    	<span class="video-control-pause">
	                                    		<span class="video-control-symbol" aria-hidden="true">⏸</span>
	                                    		<span class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Pause</span>
	                                    	</span>
	                                  </a>
                                  </div>
                                  </div>
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

    const videoElement = document.getElementById('playerElement');
    const playPauseButton = document.getElementById('PlayButton');
    
    playPauseButton.addEventListener('click', () => {
    	playPauseButton.classList.toggle('playing');
    	if (playPauseButton.classList.contains('playing')) {
    		videoElement.play();
    	}
    	else {
    		videoElement.pause();
    	}
    });
    
    videoElement.addEventListener('ended', () => {
    	playPauseButton.classList.remove('playing');
    });


    $(document).ready(function(){
       $('#playerElement').bind('contextmenu',function() { return false; });
    });
    
    $('#playerElement').click(function () {
       var mediaVideo = $("#videoplayer").get(0);
       if (mediaVideo.paused) {
           mediaVideo.play();
       } else {
           mediaVideo.pause();
      }
    });

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