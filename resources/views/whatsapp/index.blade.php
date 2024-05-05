@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Whatsapp Message</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('whatsappmessage.create')}}" class="btn btn-success "><i class="fas fa-plus"></i>  New Message</a>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($messages as $notification)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $notification->id }}</p>
                            </td>
                            
                            <td>
                               <div class="d-flex px-2 py-1">
                                  <div>
                                    <img src="@if($notification->media) {{url($notification->media)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  <div class="d-flex flex-column justify-content-center">
                                    <p class="res-txt">{{ $notification->msg }}</p>
                                  </div>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $notification->type }}</span>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($notification->created_at))}}</span>
                            </td>
                            
                            
                            <td class="align-middle">
                            <div class="ms-auto text-end align-middle text-center text-sm">
                                <a href="#" data-id="{{$notification->id}}" data-toggle="modal" data-target="#sendModal" class="btn btn-success"><i class="fa fa-rocket"></i>  Send</a>
                                <a href="#" data-id="{{$notification->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                            </div>
                            </td>
                       </tr>
                       
                        <form action="{{ url('whatsappmessage/'.$notification->id) }}" method="POST" id="form-{{ $notification->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $notification->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $messages->links() }}</div>

            </div>
          </div>
        </div>
    </div>
    
<div id="sendModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p>Do you really want to send message on whatsapp ?</p>
            
        </div>
        <div class="m-3">
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group" id="type_lay">
                    <label for="example-text-input" class="form-control-label">Total User</label>
                    
                        <select class="form-control" id="quantity" name="quantity" required>
                            <option value="100" >100</option>
                            <option value="200" >200</option>
                            <option value="300" >300</option>
                        </select>
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="type_lay">
                    <label for="example-text-input" class="form-control-label">Select Type</label>
                    
                        <select class="form-control" id="user_type" name="user_type" required>
                            <option value="newest" >Newest</option>
                            <option value="older" >20 Day Older</option>
                            <option value="random" >Random</option>
                        </select>
                    
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group d-flex" id="type_lay">
                    @if(Session::get('admin_type') == "Demo")
                    <button class="btn btn-danger demo_action" data-dismiss="modal">Send</button>
                    @else
                    <button id="send_btn" class="btn btn-danger" data-dismiss="modal">Send</button>
                    @endif
                    <button class="btn btn-default ms-2" data-dismiss="modal">Close</button>
                  </div>
                </div>
                
               
            </div>
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
          <button id="delete_btn" class="btn btn-danger" >Delete</button>
          @endif
          
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script>

    $("#sendModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#send_btn").attr("data-submit",id);
    });
    
    $("#send_btn").on("click",function(){
        var id = $(this).data("submit");
        var quantity = document.getElementById("quantity").value;
        var user_type = document.getElementById("user_type").value;
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/send-whatsapp-msg') }}",
          data: { id : id,quantity : quantity,user_type : user_type },
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              toastr.success("Message Send Successfully");
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    
    $("#deleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#delete_btn").attr("data-submit",id);
    });
    
    $("#delete_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-"+id).submit();
    });
    
    $(document).ready(function () {
       create_custom_dropdowns();
    });
</script>
@endsection