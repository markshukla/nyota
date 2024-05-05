@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white mt-2" >Musics</h6>
                   
                   <div class="ms-auto d-flex">
                        
                    </div>
                    <div class="ms-auto mt-3 d-flex">
                        <form action="{{ url('music/search') }}" method="POST"  class="ms-auto me-4">
                            @csrf
                            <input class="form-control" placeholder="Search" value="@if(!empty($search)) {{ $search }} @endif" type="text" name="search">
                        </form>
                        <a href="{{ route('music.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add New</a>
                    </div>
                   
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="col-md-4">
                  <div class="form-group p-2">
                    <select class="form-control selectpicker" onchange="searchByCategoryID()" id="category">
                        @if(empty($category)) 
                        <option selected="selected" disabled="disabled">Select Category</option> 
                        @else
                        <option disabled="disabled">Show All</option> 
                        @endif
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @if(!empty($category) && $c->name == $category) selected @endif>{{ $c->name }}</a></option>
                        @endforeach
                    </select>
                    
                  </div>
                </div>
            </div>
            
             
            <div class="card-body mt-n4">
                
                <div class="row mb" >
                    
            <!--start-->
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Details</th>
                      
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Play</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Premium</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Register</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($musics as $music)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $music->id }}</p>
                            </td>
                            
                            <td>
                               <div class="d-flex py-1">
                                  <div>
                                    <img src="@if($music->thumbnail) {{url($music->thumbnail)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  <div class="d-flex flex-column justify-content-center" >
                                    <h6 class="mb-0" >{{ $music->title }}</h6>
                                    
                                  </div>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center">
                                <a class="btn btn-icon-only btn-rounded btn btn-warning" href="{{url($music->item_url)}}">
                                    <i class="fas fa-play">
                                    </i>
                                </a>
                            </td>
                            
                            <td class="align-middle text-center">
                                <div onclick="cheakPremium({{ $music->id }})" class="align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-premium btn_cust" style="width:60px;padding:2px;margin:2px" id="pre-{{ $music->id }}">
                                         @if($music->premium==0) Free @else Premium @endif
                                    </button>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center">
                                <div class="form-switch align-items-center justify-content-center" >
                                    <input class="form-check-input status-switch" type="checkbox" data-id="{{$music->id}}" @if($music->status==0) checked @endif>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($music->created_at))}}</span>
                            </td>
                            
                            <td class="align-middle">
                                <div class="ms-auto text-end align-middle text-center text-sm">
                                    <a href="#" data-id="{{$music->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                                    
                                    <a class="btn btn-icon-only btn-rounded btn btn-success" href="{{secure_url('/music/'.$music->id.'/edit')}}"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                            
                       </tr>
                       
                        <form action="{{ url('music/'.$music->id) }}" method="POST" id="form-{{ $music->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $music->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                
                @if(empty($search))
                <div class="d-flex justify-content-center">{{ $musics->links() }}</div>
                @endif
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

<script>
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
          url: "{{ secure_url('/music-premium-action') }}",
          data: { id : id, type : cheak},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              if(cheak == 0){
                  toastr.success("Music set free");
              }else{
                  toastr.success("Music set premium");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    }
    
    function searchByCategoryID(){
        var id = document.getElementById("category").value;
        if(id == "Show All"){
            window.location.replace("{{ url('/music') }}");
        }else if(id != "Select Business"){
            window.location.replace("{{ url('/musicCategory') }}" + "/" + id);
        }
    }
    $("#deleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_btn").attr("data-submit",id);
    });
    
    $("#delete_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-"+id).submit();
    });
    
    $(".status-switch").change(function(){
        var checked = $(this).is(':checked');
        var id = $(this).data("id");
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/music-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Music Activated");
              }else{
                  toastr.success("Music Deactivated");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    $(document).ready(function () {
       create_business_dropdowns();
    });
</script>
@endsection