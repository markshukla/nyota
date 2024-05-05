<html>
    <head>
        <title>Business VCard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            @page { margin: 0px; }
            body { margin: 0px; }
            
            .body{
                background-image: url('https://res.cloudinary.com/dse9nnmqr/image/upload/v1676467183/vCart_hzeot8.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: 100% 100%;
            }
            .logo{
                height:150px;
                width:150px;
                border-radius:15px;
                margin-top: 35px;
                margin-left: 20px;
            }
            .company{
                margin-left: 20px;
                width: 70%;
                color: white;
                font-size: 28px;
                font-weight: bold;
            }
            p{
                margin-left: 20px;
                color: white;
                font-size: 20px;
            }
            .btn {
                margin-top: 20px;
                margin-left: 10px;
                border: 2px solid gold;
                background: transparent;
                color: white;
                padding: 12px 16px;
                font-size: 25px;
                cursor: pointer;
            }
            
            .rounded-btn {
                border-radius: 50%;
                border: 1px solid red;
                color: white;
                font-size: 25px;
                padding: 10px 18px;
                text-align:center;
            }
            label{
                margin-left: 5px;
                color: white;
                font-size: 20px;
            }
            .icon{
                height: 50px;
                width: 50px;
            }
            .about{
                width: 95%;
                border-radius: 10px;
                margin: 5px;
                bottom: 0px;
                position: fixed;
                padding: 10px;
                background: white;
                color: black;
                text-align: center;
            }
        </style>
    </head>
    <body class="body">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <img src="{{$image}}" class="logo" alt="{{$name}}">
            </div>
            <div class="col-lg-6">
              <h6 class="company">{{ $company }}</h6>
              <p>{{ $name }}</p>
              <p style="margin-top:-10px;">{{ $designation }}</p>
            </div>
            
          </div>
        </div>
        
        <a href="https://api.whatsapp.com/send?phone={{$whatsapp}}" class="btn" style="margin-left: 35px;"><i class="fa fa-whatsapp"></i></a>
        <a href="tel:{{$number}}" class="btn"><i class="fa fa-phone"></i></a>
        <a href="mailto:{{$email}}" class="btn"><i class="fa fa-google"></i></a>
        <a href="https://www.facebook.com/{{$facebook}}" class="btn"><i class="fa fa-facebook"></i></a>
        <a href="https://www.instagram.com/{{$instagram}}" class="btn"><i class="fa fa-instagram"></i></a>
        
        <div style="margin-left:40px;margin-top:20px">
            <div style="vertical-center">
                <a href="mailto:{{$email}}" class="btn"><i class="fa fa-info"></i></a>
                <label>{{$number}}</label>
            </div>
            <div style="margin-top:10px;">
                <a href="mailto:{{$email}}" class="btn"><i class="fa fa-info"></i></a>
                <label>{{ $email }}</label>
            </div>
            <div style="margin-top:10px;">
                <a href="{{$website}}" class="btn"><i class="fa fa-info"></i></a>
                <label>{{ $website }}</label>
            </div>
            <div style="margin-top:10px;">
                <a href="mailto:{{$email}}" class="btn"><i class="fa fa-info"></i></a>
                <label>{{ $address }}</label>
            </div>
        </div>
        
        <div style="display:block;text-align:center;margin-top10px;">
            <a href="https://www.youtube.com/c/{{$youtube}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/3670/3670147.png" alt="Youtube"></a>
            <a style="margin-left:15px;" href="https://www.twitter.com/{{$twitter}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/145/145812.png" alt="Twitter"></a>
        </div>
        
        <p class="about">
            {{ $about }}
        </p>
    </body>
</html>