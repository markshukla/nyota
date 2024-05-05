@extends('main')

@section('content')
<style>
#editor {
  height: 400px;
  width: 100%;
  font-size: 13px;
}
#return {
    background: #DCE0FF;
  height: 400px;
  width: 100%;
}
</style>
    <div class="row">
        <div class="col-12">
            <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bolder">Add Logo</p>
                <label class="btn btn-{{ $errors->first('iserror') == 'false' ? 'success' : 'primary'  }} btn-sm ms-auto">{{ $errors->first('response') }}</label>
                
              </div>
            </div>
            <div class="card-body">
                <!--<img src="{{ asset('storage/images/test.jpg') }}">-->
                <form method="post" action="{{ route('logos.store') }}" id="addform" enctype="multipart/form-data" >
                    
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name <b style="color:red">{{ $errors->first('title') }}</b></label>
                            <input class="form-control" name="title" type="text" placeholder="Medical" required>
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
                            <label for="example-text-input" class="form-control-label">Logo Editor <b style="color:red">{{ $errors->first('code') }}</b></label>
                            <div class="editor-container">
                                <div id="editor">
                                     
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <textarea style="display:none" type="hidden" name="code" id="htmlcode">
                            
                        </textarea>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="example-text-input" class="form-control-label">Live Preview</label>
                              <div id="return"></div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Thumbnail </label>
                             <input class="form-control" type="file" id="image" name="image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" onchange="fileValidation()" required="required">
                          </div>
                        </div>
                        
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-beautify.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-beautify.js"></script>

<script type="text/javascript">

    const editor = ace.edit(document.querySelector("#editor"));
    editor.setTheme("ace/theme/merbivore"); 
    editor.setOptions({
        theme: 'ace/theme/merbivore',
        mode: 'ace/mode/javascript',
        enableBasicAutocompletion: [{
        getCompletions: (editor, session, pos, prefix, callback) => {
          callback(null, [
            {meta: 'html', score: 1, value: '<html></html>'},
            {meta: 'head', score: 1, value: '<head></head>'},
            {meta: 'body', score: 1, value: '<body></body>'},
            {meta: 'label', score: 1, value: '<label></label>'},
            {meta: 'div', score: 1, value: '<div></div>'},
            {meta: 'button', score: 1, value: '<button></button>'},
            {meta: 'p', score: 1, value: '<p></p>'},
            {meta: 'h1', score: 1, value: '<h1></h1>'},
            {meta: 'h2', score: 1, value: '<h2></h2>'},
            {meta: 'h3', score: 1, value: '<h3></h3>'},
            {meta: 'h4', score: 1, value: '<h4></h4>'},
            {meta: 'h5', score: 1, value: '<h5></h5>'},
            {meta: 'h6', score: 1, value: '<h6></h6>'},
            {meta: 'img', score: 1, value: '<img class="" src="" alt="">'},
            {meta: 'email', score: 2, value: 'demo@gmail.com'},
            {meta: 'number', score: 2, value: '1234567890'},
            {meta: 'location', score: 2, value: 'Mandsaur (Madhya Pradesh)'},
            {meta: 'profile', score: 2, value: 'https://wallpapers.com/images/hd/cool-neon-blue-profile-picture-u9y9ydo971k9mdcf.jpg'},
          ]);
        },
      }],
      // to make popup appear automatically, without explicit _ctrl+space_
      enableLiveAutocompletion: true,
    });
    editor.setValue(document.getElementById("htmlcode").value);
    var beautify = ace.require("ace/ext/beautify");
    beautify.beautify(editor.session);
    
    function showHTML() {
        $('#return').html(editor.getValue());
    }
    // or use data: url to handle things like doctype
    function showHTMLInIFrame() {
        document.getElementById("htmlcode").value = editor.getValue();
        $('#return').html("<iframe style='height:500px;width:100%;' src=" +"data:text/html," + encodeURIComponent(editor.getValue()) +
        "></iframe>");
    }
    editor.on("input", showHTMLInIFrame);
    
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