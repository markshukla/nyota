@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Business Posts</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('business.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add Post</a>
                    </div>
                </div>
            </div>
            
            
            
            <div class="d-flex align-items-center">
                <div class="col-md-4">
                  <div class="form-group p-2">
                    <select class="form-control selectpicker" onchange="searchByCategoryID()" id="category">
                        @if(empty($category)) 
                        <option selected="selected" disabled="disabled">Select Business</option> 
                        @else
                        <option disabled="disabled">Show All</option> 
                        @endif
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @if(!empty($category) && $c->name == $category) selected @endif>{{ $c->name }}</a></option>
                        @endforeach
                    </select>
                    
                  </div>
                </div>
                
                <div class="ms-auto m-3 d-flex">
                   
                    <input type="checkbox" id="check_all" class="mt-1 me-3" style="width: 26px;height: 26px;">
            
                    <div class="dropdown">
                      <button class="btn btn-sm bg-gradient-info mb-0  btn_cust" type="button" data-toggle="dropdown">
                      Action &nbsp;&nbsp; <i class="fas fa-angle-down"></i></button>
                      <ul class="dropdown-menu" style="right:0;left:auto;">
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#sectionModal">Add To Section</a></li>
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#enableModal">Enable</a></li>
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#disableModal">Disable</a></li>
                        <li><a class="dropdown-item" href="#" data-type="enable" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
                      </ul>
                      <form action="{{ url('/posts-action') }}" method="POST" id="form-select-one">
                          @csrf
                          <input type="hidden" name="section_id" value="">
                          <input type="hidden" name="posts_ids" value="">
                          <input type="hidden" name="action_type" value="">
                          <input type="hidden" name="from_name" value="business">
                      </form>
                    </div>
                </div>
                
            </div>
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    @foreach ($posts as $post)
                    
                    <div class="col-xl-3 col-l-3 col-sm-4 p-2  bg-transparent">
                        
                      <div style="background-image: url(@if($post->thumb_url) {{url($post->thumb_url)}} @else {{url('/images/placeholder.jpg')}} @endif);height:240px;background-size: cover;" class="border-radius-xl">
                          
                        <div style="background-image: linear-gradient(transparent, transparent, transparent, transparent, transparent, #302d2d, black);   border-radius: 17px;" class="card-body position-relative z-index-1 p-3" >
                            <div style="width: 100%;height: 56px;position: absolute;left: 0;border-radius: 16px 16px 0 0px;top: 0;background-color: rgb(12 12 12 / 17%);z-index: -1;"></div>

                            <input type="checkbox" name="post_ids[]" value="{{$post->id}}" class="post_ids p-2" style="float: right;width: 18px;height: 18px;">
                          
                             
                             
                            <h5 class="text-white text-sm mt-0 pb-0" >{{$post->title}}</h5>
                            @if($post->section) 
                                <button class="badge badge-sm bg-gradient-dark position-absolute" id="ser-{{ $post->id }}" onclick="removeFromSection({{$post->id}})"> {{ $post->section->name }} &nbsp; <i class="fas fa-window-close"></i>
                                </button>
                            @endif
                                
                            <div @if($post->json != '') class="mt-8" @else class="mt-9" @endif>
                                @if($post->json != '') 
                                <button class="btn btn-sm btn-primary btn_cust" style="width:60px;padding:2px;margin:2px">
                                    Tamplate   
                                </button>
                                @endif
                                <div class="d-flex mt-2" >
                                  <div>
                                    <a class="btn btn-icon-only btn-rounded btn-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center" href="{{secure_url('/business/'.$post->id.'/edit')}}">
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
                            
                                <form action="{{ url('business/'.$post->id) }}" method="POST" id="form-{{ $post->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                </form>
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

<div id="sectionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Select Section</p>
          
        </div>
        <div class="modal-body">
          <select id="section_select" class="form-control" onchange="onSectionSelect()">
              <option> Select Name </option>
              @foreach ($sections as $section)
                  <option value="{{ $section->id }}">{{ $section->name }}</option>
              @endforeach
          </select>
        </div>
        <div class="modal-footer">
          @if(Session::get('admin_type') == "Demo")
          <button class="btn btn-success demo_action" data-dismiss="modal">Submit</button>
          @else
          <button id="section_btn" class="btn btn-success">Submit</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
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

    function searchByCategoryID(){
        var id = document.getElementById("category").value;
        if(id == "Show All"){
            window.location.replace("{{ url('/business') }}");
        }else if(id != "Select Business"){
            window.location.replace("{{ url('/businessCategory') }}" + "/" + id);
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
          url: "{{ secure_url('/posts-premium-action') }}",
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
    function removeFromSection(id){
        document.getElementById("ser-"+id).remove();
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/posts-remove-section') }}",
          data: { id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              toastr.success("Removed from section");
              
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    }
    
    function onSectionSelect(){
        $("input[name='section_id']").val(document.getElementById("section_select").value);
    }

    $("#section_btn").on("click",function(){
        $("#form-select-one").submit();
    });

    $('#sectionModal').on('show.bs.modal', function(e) {
        $("input[name='action_type']").val("section");
    });

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
          url: "{{ secure_url('/posts-status') }}",
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