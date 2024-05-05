@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white mt-2" >Withdraws</h6>
                   
                   <form action="{{ url('user/search') }}" method="POST"  class="ms-auto mt-2 mb-2">
                       @csrf
                       <input class="form-control" placeholder="Search" value="@if(!empty($search)) {{ $search }} @endif" type="text" name="search">
                   </form>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">UPI</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($withdraws as $user)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $user->id }}</p>
                            </td>
                            
                            <td>
                               <div class="d-flex py-1">
                                  <div>
                                    <img src="@if($user->user->profile_pic) {{url($user->user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  <div class="d-flex flex-column justify-content-center" >
                                    <h6 class="mb-0" >{{ $user->user->name }}</h6>
                                    <p class="mb-0 text-sm">@if($user->user->email) {{$user->user->email}} @else {{$user->user->number}} @endif</p>
                                  </div>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $user->upi_id }}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ App\Models\Setting::getValue('currency') }} {{ $user->amount }}</p>
                            </td>
                            
                            <td class="align-middle">
                                
                                <div onclick="cheakStatus({{ $user->id }})" class="align-items-center justify-content-center">
    <button class="btn btn-sm btn_cust @if($user->status == 'pending') btn-danger @else btn-success @endif" style="width:60px;padding:2px;margin:2px" id="status-{{ $user->id }}">
                                         {{ $user->status }}
                                    </button>
                                </div>
                                
                            </td>
                            
                            <td class="align-middle">
                                <div class="ms-auto text-end align-middle text-center text-sm">
                                    <a href="#" data-id="{{$user->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </td>
                            
                       </tr>
                       
                        <form action="{{ url('deletewithdraw') }}" method="POST" id="form-{{ $user->id }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                
                @if(empty($search))
                <div class="d-flex justify-content-center">{{ $withdraws->links() }}</div>
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

    function cheakStatus(id){
        var cheak = document.getElementById("status-"+id).innerHTML;
        if(cheak != "success"){
            document.getElementById("status-"+id).innerHTML = "success";
            cheak = "success";
            $.ajax({
              type: "POST",
              url: "{{ secure_url('/withdraw-status') }}",
              data: { id : id, type : cheak},
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              success: function(data) {
                  
              },
              error (data) {
                  toastr.error(JSON.stringify(data));
              }
              
            });
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
          url: "{{ secure_url('/withdraw-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("User Activated");
              }else{
                  toastr.success("User Deactivated");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    });
    
</script>
@endsection