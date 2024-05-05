@extends('main')

@section('content')
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card bg-gradient-primary shadow-primary">
            <a href="{{ url('/users') }}">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase text-white font-weight-bold">Users</p>
                    <h5 class="font-weight-bolder text-xlg count-up text-white" data-value="{{ $user_count }}">
                      0
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-faded-white-vertical  shadow-primary text-center rounded-circle">
                    <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card bg-gradient-danger">
            <a href="{{ url('/category') }}">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase text-white font-weight-bold">Category</p>
                    <h5 class="font-weight-bolder text-xlg count-up text-white" data-value="{{ $category_count }}">
                      0
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-faded-white-vertical  shadow-primary text-center rounded-circle">
                    <i class="fa fa-sitemap text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card bg-gradient-success">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase text-white font-weight-bold">Posts</p>
                    <h5 class="font-weight-bolder text-xlg count-up text-white" data-value="{{ $posts_count }}">
                      0
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-faded-white-vertical  shadow-primary text-center rounded-circle">
                    <i class="fa fa-photo text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card bg-gradient-warning">
            <a href="{{ url('/video') }}">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase text-white font-weight-bold">Videos</p>
                    <h5 class="font-weight-bolder text-xlg count-up text-white" data-value="{{ $videos_count }}">
                      0
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-faded-white-vertical  shadow-primary text-center rounded-circle">
                    <i class="fa fa-video text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
      </div>
      
      <!--new tracker-->
      @if(App\Models\Admin::isPermission('transaction')  == 'true')
      <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
         <div class="card">
          <div class="card-body p-1">
            <div class="row gx-2">
              <div class="col-auto">
                <div class="avatar avatar-xl position-relative" style="background-color: #31acd1;">
                    <img src="https://res.cloudinary.com/ddq12bxae/image/upload/v1674566369/dailyposte/wallet_1_iph0bi.png" alt="profile_image" class="w-50 shadow-sm">
                </div>
              </div>
              <div class="col-auto my-auto">
                <div class="h-100">
                  <h5 class="mb-1 text-sm"> Today Payment</h5>
                  <p class="mb-0 font-weight-bold text-lg"> {{ App\Models\Setting::getValue('currency') }} {{ $today_payment }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
         <div class="card">
          <div class="card-body p-1">
            <div class="row gx-2">
              <div class="col-auto">
                 <div style="background-color: #cf3e27;" class="avatar avatar-xl position-relative">
                    <img src="https://res.cloudinary.com/ddq12bxae/image/upload/v1674566473/dailyposte/7-days_1_m6nwp6.png" alt="profile_image" class="w-50 shadow-sm">
                </div>
              </div>
              <div class="col-auto my-auto">
                <div class="h-100">
                  <h5 class="mb-1 text-sm"> Weekly Payment</h5>
                  <p class="mb-0 font-weight-bold text-lg"> {{ App\Models\Setting::getValue('currency') }} {{ $weekly_payment }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
         <div class="card">
          <div class="card-body p-1">
            <div class="row gx-2">
              <div class="col-auto">
                <div class="avatar avatar-xl position-relative" style="background-color: #482aa5;">
                    <img src="https://res.cloudinary.com/ddq12bxae/image/upload/v1674566753/dailyposte/thirty-one_knu5ol.png" alt="profile_image" class="w-50 shadow-sm">
                </div>
              </div>
              <div class="col-auto my-auto">
                <div class="h-100">
                  <h5 class="mb-1 text-sm"> Monthly Payment</h5>
                  <p class="mb-0 font-weight-bold text-lg"> {{ App\Models\Setting::getValue('currency') }} {{ $monthly_payment }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6">
         <div class="card">
          <div class="card-body p-1">
            <div class="row gx-2">
              <div class="col-auto">
                <div class="avatar avatar-xl position-relative" style="background-color: #db0098;">
                    
                  <img src="https://res.cloudinary.com/ddq12bxae/image/upload/v1674566910/dailyposte/365_1_jd3dmo.png" alt="profile_image" class="w-50 shadow-sm">
                </div>
              </div>
              <div class="col-auto my-auto">
                <div class="h-100">
                  <h5 class="mb-1 text-sm"> Total Payment</h5>
                  <p class="mb-0 font-weight-bold text-lg"> {{ App\Models\Setting::getValue('currency') }} {{ $total_payment }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      @endif
      <div class="row mt-4">
          @if(App\Models\Admin::isPermission('transaction')  == 'true')
          <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Monthly Subscription Overview</h6>
            </div>
            <div class="card-body p-1">
              <div class="chart">
                <canvas id="subscription-chart" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
          @endif
        <div class="col-lg-5">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Montly Users Overview</h6>
            </div>
            <div class="card-body p-1">
              <div class="chart">
                <canvas id="users-chart" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Today Events</h6>
            </div>
            <div class="card-body mt-n3" >
                
                <div class="row mb" >
                    
                    @foreach($today_event as $event)
                    
                    <div class="col-xl-6 col-sm-12 mb-4">
                      <div class="card bg-gradient-light shadow-primary">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-4">
                                <div class="avatar avatar-xl position-relative">
                                  <div class="icon-shape avatar-xl bg-gradient-dark" 
                                  style="background-image: url(@if($event->image) {{asset($event->image)}} @else {{url('/images/placeholder.jpg')}} @endif);background-size: cover;">
                                  </div>
                                </div>
                            </div>
                            <div class="col-8">
                              <div>
                                <p class="text-xs mb-0 text-uppercase ps-1 text-dark font-weight-bolder">{{ $event->name }}</p>
                                <div class="row mt-2" >
                                  <div class="col">
                                    <div class="d-flex ">
                                      <div class="d-grid text-center mx-3">
                                        <span class="text-lg font-weight-bolder text-dark">{{ $event->posts }}</span>
                                        <span class="text-sm opacity-8 text-dark">Posts</span>
                                      </div>
                                      <div class="d-grid text-center">
                                        <span class="text-lg font-weight-bolder text-dark">{{ $event->video }}</span>
                                        <span class="text-sm opacity-8 text-dark">Videos</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    @endforeach
                    
                </div>
                
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">User Subscription Plan Expire</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                  
                @foreach($subs_end_usr as $user)
                  
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center" 
                    style="background-image: url(@if($user->profile_pic) {{asset($user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif);background-size: cover;">
                      
                    </div>
                    <div class="d-flex flex-column">
                      <a href="{{ url('users/'.$user->id) }}"><h6 class="mb-1 text-dark text-sm">{{ $user->name }}</h6></a>
                      <span class="text-xs">End on <span class="font-weight-bold">{{date('d M, y',strtotime($user->subscription_end_date))}}</span></span>
                    </div>
                  </div>
                  <div class="d-flex " >
                    <a href="{{ url('users/'.$user->id) }}" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></a>
                  </div>
                </li>
                  
                @endforeach
                
                
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
          
        <div class="col-lg-6 mb-lg-0 mb-6">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Recent Register User</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Information</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($recent_user as $user)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="icon-shape avatar-sm me-3" 
                          style="background-image: url(@if($user->profile_pic) {{asset($user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif);background-size: cover;">
                              
                          </div>
                              
                          <div class="d-flex flex-column justify-content-center">
                            <a href="{{ url('users/'.$user->id) }}"><h6 class="mb-0 text-sm">{{ $user->name }}</h6></a>
                            <p class="text-xs text-secondary mb-0">
                                @if($user->email) {{$user->email}} @else {{$user->number}} @endif
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{date('d M, y',strtotime($user->created_at))}}</p>
                      </td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6 mb-lg-0 mb-6">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Recent subscription</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Information</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($recent_transaction as $trasaction)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="icon-shape avatar-sm me-3" 
                          style="background-image: url(@if($trasaction->user->profile_pic) {{asset($trasaction->user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif);background-size: cover;">
                              
                          </div>
                              
                          <div class="d-flex flex-column justify-content-center">
                            <a href="{{ url('users/'.$trasaction->user->id) }}"><h6 class="mb-0 text-sm">{{ $trasaction->user->name }}</h6></a>
                            <p class="text-xs text-secondary mb-0">
                                 @if($trasaction->user->email) {{$trasaction->user->email}} @else {{$trasaction->user->number}} @endif
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-sm bg-gradient-success"> {{ $trasaction->amount }}</span>
                      </td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Recent Contacts</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="mb-1">
                  @foreach($recent_contact as $contacts)
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <!--<img alt="Image placeholder" class="avatar rounded-circle" src="../../assets/img/bruce-mars.jpg">-->
                      <div class="icon-shape avatar rounded-circle" 
                      style="background-image: url(@if($contacts->user->profile_pic) {{asset($contacts->user->profile_pic)}} @else {{url('/images/placeholder.jpg')}} @endif);background-size: cover;"></div>
                    </div>
                    
                    <div class="flex-grow-1 ms-3">
                      <a href="{{ url('users/'.$contacts->user->id) }}"><h6 class="h6 mt-0">{{$contacts->user->name}}</h6></a>
                      <p class="text-sm">{{$contacts->message}}</p>
                       <hr class="horizontal dark my-3">
                    </div>
                  </div>
                  @endforeach
                </div>
                
                
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
<script>
    var ctx1 = document.getElementById("users-chart").getContext("2d");
    
    new Chart(ctx1, {
      type: "bar",
      data: {
        labels: [@foreach($user_chart as $data) "{{$data['month']}}", @endforeach],
        datasets: [{
          label: "Users",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#0064DC",
          borderWidth: 3,
          fill: true,
          data: [@foreach($user_chart as $data) {{$data['count']}}, @endforeach],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#00000',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#00000',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
    
    var subscription = document.getElementById("subscription-chart").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(subscription, {
      type: "line",
      data: {
        labels: [@foreach($tran_chart as $data) "{{$data['month']}}", @endforeach],
        datasets: [{
          label: "Amount",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#0064DC",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [@foreach($tran_chart as $data) {{$data['count']}}, @endforeach],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#00000',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#00000',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
</script>
@endsection