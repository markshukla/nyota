@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white mt-2" >Service Inquiries </h6>
                    <div class="ms-auto d-flex">
                        
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Detail</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Service</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($inquiries as $inquiry)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $inquiry->id }}</p>
                            </td>
                            
                            <td>
                                <a href="{{secure_url('/users/'.$inquiry->user_id)}}">
                               <div class="d-flex " >
                                  <div >
                                    <img src="{{ asset($inquiry->user->profile_pic) }}" class="avatar avatar-xl me-2" alt="user1">
                                  </div>
                                  <div class="d-flex flex-column justify-content-center" >
                                    <h6 class="text-sm ">{{ $inquiry->user->name }}</h6>
                                    <p class="text-sm mt-n2">{{ $inquiry->number }}</p>
                                    
                                  </div>
                                </div>
                                </a>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $inquiry->service->title }}</span>
                            </td>
                            
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $inquiry->service->new_price }}</span>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $inquiry->message }}</span>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $inquiry->created_at }}</span>
                            </td>
                            
                            
                            <td class="align-middle">
                            <div class="ms-auto text-end align-middle text-center text-sm">
                                <a href="#" data-id="{{$inquiry->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                            </div>
                            </td>
                       </tr>
                       
                        <form action="{{ url('inquiry/'.$inquiry->id) }}" method="POST" id="form-{{ $inquiry->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $inquiry->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                @if(empty($search))
                  <div class="d-flex justify-content-center">{{ $inquiries->links() }}</div>
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