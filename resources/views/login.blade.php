<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="{{App\Models\Setting::getValue('app_logo')}}">
        <title>
            {{App\Models\Setting::getValue('app_name')}}
        </title>
        
        <link href="{{ url('/css/nucleo-icons.css?p=825') }}" rel="stylesheet">
        <link href="{{ url('/css/nucleo-svg.css') }}" rel="stylesheet">
        <link href="{{ url('/css/app.css?p=857778877') }}" rel="stylesheet">
        <link href="{{ url('/css/argon-dashboard.css?p=74555') }}" rel="stylesheet">
        
        
        
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" 
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" 
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        
        
    </head>

<body class="g-sidenav-show bg-gray-100">
  
  <main class="main-content" style="background:#5e72e4;">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto" >
              <div class="card card-plain" style="background:#B7BCFF">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder white">Wellcome to {{App\Models\Setting::getValue('app_name')}}</h4>
                  <p class="">Enter your email and password to sign in</p>
                  <p class="error text-center">{{ $errors->first('loginerror') }}</p>
                </div>
                <div class="card-body">
                  <form action="login" role="form" method="post">
                      @csrf
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" required="required" placeholder="Username" name="username">
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" required="required" placeholder="Password" name="password">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Login</button>
                    </div>
                  </form>
                </div>
                
              </div>
              
              
            </div>
            
          </div>
        </div>
        <div style="background-image: url({{ url('/images/posters.jpg') }});background-size: cover;" class="col-6 d-lg-flex h-100 position-absolute top-0 end-0 text-center justify-content-center flex-column" ></div>
       </div>
    </section>
  </main>
  
</body>

</html>