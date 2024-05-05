@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Video Tamplates</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('videotamplate.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="col-md-4">
                  <div class="form-group p-2">
                    <select class="form-control selectpicker" onchange="searchByType()" id="category">
                        <option selected >All</option>
                        <option @if(!empty($type) && $type == 'festival') selected @endif value="festival">Festival</option>
                        <option @if(!empty($type) && $type == 'business') selected @endif value="business">Business</option>
                        <option @if(!empty($type) && $type == 'political') selected @endif value="business">political</option>
                        <option @if(!empty($type) && $type == 'custom') selected @endif value="custom">Custom</option>
                    </select>
                    
                  </div>
                </div>
                
                <div class="ms-auto m-3 d-flex">
                   
                    <input type="checkbox" id="check_all" class="mt-1 me-3" style="width: 26px;height: 26px;">
            
                    <div class="dropdown">
                      <button class="btn btn-sm bg-gradient-info mb-0  btn_cust" type="button" data-toggle="dropdown">
                      Action &nbsp;&nbsp; <i class="fas fa-angle-down"></i></button>
                      <ul class="dropdown-menu" style="right:0;left:auto;">
                        <!--<li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#sectionModal">Add To Section</a></li>-->
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#enableModal">Enable</a></li>
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#disableModal">Disable</a></li>
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
                      </ul>
                      <form action="{{ url('/video-tamplate-action') }}" method="POST" id="form-select-one">
                          @csrf
                          <input type="hidden" name="section_id" value="">
                          <input type="hidden" name="posts_ids" value="">
                          <input type="hidden" name="action_type" value="">
                      </form>
                    </div>
                </div>
                
            </div>
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    @foreach ($posts as $post)
                    
                    <div class="col-lg-3 col-sm-6 col-xs-12 p-2  bg-transparent">
                        
                      <div style="height:350px;background-size: cover;" class="border-radius-xl">
                          
                          <div class="position-absolute">
                              
                              <video class="border-radius-xl position-absolute" width="100%" height="300px" preload="metadata" style="background:gray;object-fit: cover;">
                                  <source src="{{asset($post->video_url)}}#t=6">
                              </video>
                              
                              
                        <div style="background-image: linear-gradient(transparent, transparent, transparent, transparent, transparent, #302d2d, black);border-radius: 17px;" class="card-body position-relative z-index-1 p-3">
                            <div style="width: 100%;height: 56px;position: absolute;left: 0;border-radius: 16px 16px 0 0px;top: 0;background-color: rgb(12 12 12 / 17%);z-index: -1;"></div>
                            <input type="checkbox" name="post_ids[]" value="{{$post->id}}" class="post_ids p-2" style="float: right;width: 18px;height: 18px;">
                          
                             
                             
                            <h5 class="text-white text-sm mt-0 pb-0" >{{$post->title}}</h5>
                            
                            <div class="mt-12" >
                                
                                <div class="d-flex mt-2" >
                                  <div>
                                    <a class="btn btn-icon-only btn-rounded btn-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center" href="{{secure_url('/videotamplate/'.$post->id.'/edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                  </div>
                                  
                                  <div>
                                    <button class="btn btn-icon-only btn-rounded btn-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"  data-id="{{$post->id}}" data-toggle="modal" data-target="#singleDeleteModal">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                  </div>
                                  
                                  
                                  <div class="form-switch align-items-center justify-content-center" >
                                     <input class="form-check-input status-switch" type="checkbox" data-id="{{$post->id}}" @if($post->status==0) checked @endif>
                                  </div>
                                  
                                  <div onclick="cheakPremium({{ $post->id }})" class="align-items-center justify-content-center">
                                     <button class="btn btn-sm btn-premium btn_cust" style="width:60px;padding:2px;margin:2px" id="pre-{{ $post->id }}">
                                         @if($post->premium==0) Free @else Premium @endif
                                         </button>
                                  </div>
                                  
                                </div>
                            
                                <form action="{{ url('videotamplate/'.$post->id) }}" method="POST" id="form-{{ $post->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                </form>
                            </div>
                          </div>
                          </div>
                          
                          
                        
                        </div>
                        
                     </div>
                      
                     @endforeach
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $posts->links() }}</div>

            </div>
          </div>
        </div>
    </div>

<div id="singleDeleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          <!--{{ Session::put('admin_type','Admin') }}-->
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="del_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Delete</button>
          @else
          <button id="delete_btn" class="btn btn-danger">Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div id="disableModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to disable ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Disable</button>
          @else
          <button id="disable_btn" class="btn btn-warning">Disable</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div id="enableModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Are you sure you want to enable ?</p>
        </div>
        <div class="modal-footer">
          
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-danger demo_action" data-dismiss="modal">Enable</button>
          @else
          <button id="enable_btn" class="btn btn-success">Enable</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script>

    function searchByType(){
        var id = document.getElementById("category").value;
        if(id == "All"){
            window.location.replace("{{ url('/videotamplate') }}");
        }else{
            window.location.replace("{{ url('/videotamplatebytype') }}"+"/"+id);
        }
    }

    function cheakPremium(id){
        var cheak = document.getElementById("pre-"+id).innerHTML;
        if(cheak == "Free"){
            document.getElementById("pre-"+id).innerHTML = "Premium";
            cheak = 1;
        }else{
            document.getElementById("pre-"+id).innerHTML = "Free";
            cheak = 0;
        }
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/video-tamplate-premium-action') }}",
          data: { id : id, type : cheak},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              if(cheak == 0){
                  toastr.success("Post set free");
              }else{
                  toastr.success("Post set premium");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    }

    $("#enable_btn").on("click",function(){
        $("#form-select-one").submit();
    });

    $('#enableModal').on('show.bs.modal', function(e) {
        $("input[name='action_type']").val("enable");
    });
    
    $("#disable_btn").on("click",function(){
        $("#form-select-one").submit();
    });

    $('#disableModal').on('show.bs.modal', function(e) {
        $("input[name='action_type']").val("disable");
    });
    
    $("#delete_btn").on("click",function(){
        $("#form-select-one").submit();
    });

    $('#deleteModal').on('show.bs.modal', function(e) {
        $("input[name='action_type']").val("delete");
    });
    
    //Signle Delete
    $("#singleDeleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });
    
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-"+id).submit();
    });
    
    var checkarray = [];
    $("#check_all").click(function() {
    	checkarray = [];
    	$("input[name='post_ids[]']").not(this).prop('checked', this.checked);
    	$.each($("input[name='post_ids[]']:checked"), function() {
    		checkarray.push($(this).val());
    	});
    	$("input[name='posts_ids']").val(checkarray);
    });
    
    $(".post_ids").click(function(e) {
        
    	if ($(this).prop("checked") == true) {
    		checkarray.push($(this).val());
    	} else if ($(this).prop("checked") == false) {
    		checkarray.splice($.inArray($(this).val(), checkarray), 1);
    	}
    	$("input[name='posts_ids']").val(checkarray);
    });
    
    $(".status-switch").change(function(){
        var checked = $(this).is(':checked');
        var id = $(this).data("id");
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/video-tamplate-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Post Activated");
              }else{
                  toastr.success("Post Deactivated");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
      
    $(document).ready(function () {
       create_custom_dropdowns();
    });
</script>
@endsection