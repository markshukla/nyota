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
                <p class="mb-0 font-weight-bolder">Edit Video Tamplate</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action=" {{ route('videotamplate.update',$video->id) }} " id="addform" enctype="multipart/form-data" >
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
                            
                            <select class="form-control" id="type" name="type" required>
                                <option value="festival" @if($video->type == "festival") selected @endif>Festival</option>
                                <option value="business" @if($video->type == "business") selected @endif>Business</option>
                                <option value="political" @if($video->type == "political") selected @endif>Political</option>
                                <option value="custom" @if($video->type == "custom") selected @endif>Custom</option>
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Language <b style="color:red">{{ $errors->first('language') }}</b></label>
                            
                            <select class="form-control" name="language" required="required">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->language_code }}" @if($video->language == $language->language_code) selected @endif>{{ $language->language_name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group" id="cate_lay">
                            <label for="example-text-input" class="form-control-label">Select Category</label>
                            
                            <select class="form-control" id="category" name="category" required>
                                @foreach ($categories as $festival)
                                <option value="{{ $festival->id }}"  @if($festival->id == $video->category_id) selected @endif>{{ $festival->name }}</option>
                                @endforeach
                            </select>
                            
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Video<b style="color:red">{{ $errors->first('video') }}</b></label>
                            <input class="form-control" type="file" id="video" name="video" accept=".mp4" onchange="videoPreview()">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Zip<b style="color:red">{{ $errors->first('zip') }}</b></label>
                            <input class="form-control" type="file" id="zip" name="zip" accept=".zip" >
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb" id="previewImages">
                                <div class="bg-transparent">
                                  <div style="height:240px;background-size: cover;" class="border-radius-xl">
                                      <div class="position-absolute">
                                          <video id="playerElement" class="border-radius-xl position-absolute" width="250" height="auto" style="background:gray;object-fit: cover;">
                                              <source id="videoplayer" src="{{ asset($video->video_url) }}">
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
                        
                    
                        <div class="col-md-6" >
                          <div class="form-group">
                              
                              @if(Session::get('admin_type') == "Demo")
                              <div class="btn btn-primary col-md-12 demo_action">Submit</div>
                              @else
                              <input class="btn btn-primary col-md-12" type="submit" value="Submit">
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