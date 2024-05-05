@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white" >Business Card Digital</h6>
                    
                    <div class="ms-auto mt-3">
                        <a href="{{ route('businesscarddigital.create')}}" class="btn btn-success "><i class="fas fa-plus"></i> Add Card</a>
                    </div>
                </div>
            </div>
        
            <div class="card-body mt-n3">
                
                <div class="row mb" >
                    @foreach ($cards as $post)
                    
                    <div class="col-xl-3 col-l-3 col-sm-4 p-2  bg-transparent">
                        
                      <div style="background-image: url(@if($post->thumb_url) {{url($post->thumb_url)}} @else {{url('/images/placeholder.jpg')}} @endif);height:240px;background-size: cover;" class="border-radius-xl">
                          
                       <div style="border-radius: 14px;">
                            <div style="background-image: linear-gradient(transparent, transparent, transparent, transparent, transparent, #302d2d, black);border-radius: 17px;" class="card-body position-relative z-index-1 p-3">
                            <div style="width: 100%;height: 56px;position: absolute;left: 0;border-radius: 16px 16px 0 0px;top: 0;background-color: rgb(12 12 12 / 17%);z-index: -1;"></div>
                            <h5 class="text-white text-sm mt-0 pb-0" >{{$post->title}}</h5>
                            
                            <div class="mt-9" >
                                
                                <div class="d-flex mt-2" >
                                  
                                  
                                  <div class="form-switch align-items-center justify-content-center" >
                                     <input class="form-check-input status-switch" type="checkbox" data-id="{{$post->id}}" @if($post->status==0) checked @endif>
                                  </div>
                                  
                                  <div onclick="cheakPremium({{ $post->id }})" class="align-items-center justify-content-center">
                                     <button class="btn btn-sm btn-premium btn_cust" style="width:60px;padding:2px;margin:2px" id="pre-{{ $post->id }}">
                                         @if($post->premium==0) Free @else Premium @endif
                                         </button>
                                  </div>
                                  
                                </div>
                            
                                <form action="{{ url('businesscarddigital/'.$post->id) }}" method="POST" id="form-{{ $post->id }}">
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
                
                <div class="d-flex justify-content-center">{{ $cards->links() }}</div>

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
          url: "{{ secure_url('/bsns-digital-premium-action') }}",
          data: { id : id, type : cheak},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              if(cheak == 0){
                  toastr.success("Tamplate set free");
              }else{
                  toastr.success("Tamplate set premium");
              }
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    }
    
    
    //Signle Delete
    $("#singleDeleteModal").on('show.bs.modal', function(e){
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });
    
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form-"+id).submit();
    });
    
    
    $(".status-switch").change(function(){
        var checked = $(this).is(':checked');
        var id = $(this).data("id");
        
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/bsns-digital-card-status') }}",
          data: { checked : checked , id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              
              if(checked){
                  toastr.success("Tamplate Activated");
              }else{
                  toastr.success("Tamplate Deactivated");
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