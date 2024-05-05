@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Backgrounds</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('backgrounds.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    @foreach ($backgrounds as $background)
                    
                    <div class="col-xl-3 col-l-3 col-sm-4 p-2  bg-transparent">
                        
                      <div style="background-image: url(@if($background->item_url) {{url($background->item_url)}} @else {{url('/images/placeholder.jpg')}} @endif);height:240px;background-size: cover;" class="border-radius-xl">
                          
                        <div style="background-image: linear-gradient(transparent, transparent, transparent, transparent, transparent, #302d2d, black);   border-radius: 17px;" class="card-body position-relative z-index-1 p-3">
                            
                            <div class="mt-10">
                               
                                <div class="d-flex mt-2" >
                                    
                                  <div>
                                    <button class="btn btn-icon-only btn-rounded btn-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"  data-id="{{$background->id}}" data-toggle="modal" data-target="#singleDeleteModal">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                  </div>
                                  
                                 
                                </div>
                            
                                <form action="{{ url('backgrounds/'.$background->id) }}" method="POST" id="form-{{ $background->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $background->id }}">
                                </form>
                            </div>
                          </div>
                      </div>
                        
                     </div>
                      
                     @endforeach
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $backgrounds->links() }}</div>

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

<script>

    
    //Signle Delete
    $("#singleDeleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });
    
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-"+id).submit();
    });
    
   
</script>
@endsection