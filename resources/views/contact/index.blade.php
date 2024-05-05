@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white mt-2" >Contacts</h6>
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Number</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($contacts as $contact)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $contact->id }}</p>
                            </td>
                            
                            <td>
                               <div class="d-flex py-1">
                                  <div>
                                    <img src="@if($contact->user->profile_pic) {{url($contact->user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 title">{{ $contact->user->name }}</h6>
                                    <p class="mb-0 text-sm">@if($contact->user->email) {{$contact->user->email}} @else {{$contact->user->number}} @endif</p>
                                  </div>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $contact->number }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $contact->message }}</p>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($contact->created_at))}}</span>
                            </td>
                            
                            
                            <td class="align-middle">
                            <div class="ms-auto text-end align-middle text-center text-sm">
                                <a href="#" data-id="{{$contact->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                                <a class="btn btn-icon-only btn-rounded btn btn-success" href="{{secure_url('/subscription/'.$contact->id.'/edit')}}"><i class="fas fa-pencil-alt"></i></a>
                            </div>
                            </td>
                       </tr>
                       
                        <form action="{{ url('contacts/'.$contact->id) }}" method="POST" id="form-{{ $contact->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $contacts->links() }}</div>

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
    
</script>
@endsection