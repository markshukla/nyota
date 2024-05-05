@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Promocodes</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('promocode.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    
            <!--start-->
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Discount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Limit</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($promocodes as $promocode)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $promocode->id }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $promocode->code }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $promocode->discount }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $promocode->total_use }}</p>
                            </td>
                            
                            
                            <td class="align-middle">
                                <div class="form-switch align-items-center justify-content-center" >
                                    <input class="form-check-input status-switch" type="checkbox" data-id="{{$promocode->id}}" @if($promocode->status==0) checked @endif>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($promocode->created_at))}}</span>
                            </td>
                            
                            <td class="align-middle">
                            <div class="ms-auto text-end align-middle text-center text-sm">
                                <a href="#" data-id="{{$promocode->id}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-only btn-rounded btn-danger"><i class="far fa-trash-alt"></i></a>
                                <a class="btn btn-icon-only btn-rounded btn-success" href="{{secure_url('/promocode/'.$promocode->id.'/edit')}}"><i class="fas fa-pencil-alt"></i></a>
                            </div>
                            </td>
                       </tr>
                       
                        <form action="{{ url('promocode/'.$promocode->id) }}" method="POST" id="form-{{ $promocode->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $promocode->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <!--end-->
                      
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
    
    $(".status-switch").change(function(){
        var checked = $(this).is(':checked');
        var id = $(this).data("id");
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/promocode-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Promocode Activated");
              }else{
                  toastr.success("Promocode Deactivated");
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