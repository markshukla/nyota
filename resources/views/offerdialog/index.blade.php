@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Offer Dialog</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('offerdialog.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    @foreach ($offerdialogs as $offerdialog)
                    
                    <div class="col-xl-3 col-l-6 col-sm-4 p-2  bg-transparent">
                        
                      <div style="background-image: url(@if($offerdialog->item_url) {{url($offerdialog->item_url)}} @else {{url('/images/placeholder.jpg')}} @endif);height:240px;background-size: cover;" class="border-radius-xl">
                          
                        <div style="background-image: linear-gradient(transparent, transparent, transparent, transparent, transparent, #302d2d, black);border-radius: 17px;"   class="card-body position-relative z-index-1 p-3">
                            <div style="width: 100%;height: 56px;position: absolute;left: 0;border-radius: 16px 16px 0 0px;top: 0;background-color: rgb(12 12 12 / 17%);z-index: -1;"></div>
                            <div class="mt-10" >
                                
                                <div class="d-flex mt-3" >
                                  <div>
                                    <a class="btn btn-icon-only btn-rounded btn-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center" href="{{secure_url('/offerdialog/'.$offerdialog->id.'/edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                  </div>
                                  
                                  <div>
                                    <button class="btn btn-icon-only btn-rounded btn-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"  data-id="{{$offerdialog->id}}" data-toggle="modal" data-target="#deleteModal">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                  </div>
                                  
                                  
                                  <div class="form-switch align-items-center justify-content-center" >
                                     <input class="form-check-input status-switch" type="checkbox" data-id="{{$offerdialog->id}}" @if($offerdialog->status==0) checked @endif>
                                  </div>
                                  
                                </div>
                            
                                <form action="{{ url('offerdialog/'.$offerdialog->id) }}" method="POST" id="form-{{ $offerdialog->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $offerdialog->id }}">
                                </form>
                                
                            </div>
                          </div>
                        </div>
                        
                     </div>
                      
                     @endforeach
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $offerdialogs->links() }}</div>

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
          url: "{{ secure_url('/offerdialog-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Image Activated");
              }else{
                  toastr.success("Image Deactivated");
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