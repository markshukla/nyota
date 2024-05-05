@extends('main')

@section('content')
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
              
            <div class="card-header py-0 bg-primary">
                <div class="d-flex align-items-center">
                   <h6 class="text-white mt-2" >Transaction</h6>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Promocode</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Recipt</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Id</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($transactions as $transaction)
                       <tr>
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->id }}</p>
                            </td>
                            
                            <td>
                               <div class="d-flex py-1">
                                  <div>
                                    <img src="@if($transaction->user->profile_pic) {{url($transaction->user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif" class="avatar avatar-xl me-3" alt="user1">
                                  </div>
                                  <a href="{{secure_url('/users/'.$transaction->user_id)}}">
                                  <div class="d-flex flex-column justify-content-center" >
                                    <h6 class="mb-0" >{{ $transaction->user->name }}</h6>
                                    <p class="mb-0 text-sm">@if($transaction->user->email) {{$transaction->user->email}} @else {{$transaction->user->number}} @endif</p>
                                  </div>
                                  </a>
                                </div>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->plan }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->promocode }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="badge badge-sm bg-gradient-success">{{ $transaction->amount }}</p>
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                @if($transaction->receipt != "")
                                <a style="color:blue;" href="{{url($transaction->receipt)}}">View</p>
                                @endif
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                @if($transaction->status == "pending")
                                 <button onclick="completePayment({{ $transaction->id }})" class="btn btn-sm btn-dark" style="width:60px;padding:2px;margin:2px">
                                    Complete
                                 </button>
                                @else
                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->status }}</p>
                                @endif
                            </td>
                            
                            <td class="align-middle text-center text-sm">
                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->transaction_id }}</p>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{date('d M, y',strtotime($transaction->created_at))}}</span>
                            </td>
                            
                       </tr>
                       
                        <form action="{{ url('contacts/'.$transaction->id) }}" method="POST" id="form-{{ $transaction->id }}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $transaction->id }}">
                        </form>
                    @endforeach
                  </tbody>
                </table>
            </div>
              
              <!--end-->
                      
                </div>
                    
            </div>
                
                <div class="d-flex justify-content-center">{{ $transactions->links() }}</div>

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
    function completePayment(id){
        $.ajax({
          type: "POST",
          url: "{{ secure_url('/complete-offline-payment') }}",
          data: { id : id},
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function(data) {
              location.reload();
          },
          error (data) {
              toastr.error(JSON.stringify(data));
          }
          
        });
    }
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