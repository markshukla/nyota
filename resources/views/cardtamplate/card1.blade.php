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
                text-align: center;
                background-image: url('https://res.cloudinary.com/dse9nnmqr/image/upload/v1676468745/vCart2_chdxch.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: 100% 100%;
            }
            
            .logo{
                height:150px;
                width:150px;
                border-radius:15px;
                margin-top: 35px;
            }
            .company{
                color: white;
                font-size: 27px;
                font-weight: bold;
            }
            p{
                margin-left: 20px;
                color: white;
                font-size: 20px;
            }
            .btn {
                margin-top: 10px;
                margin-left: 6px;
                border: 1px solid white;
                background: #1066A2;
                color: white;
                text-align: center;
                padding: 2px 6px;
                font-size: 19px;
                cursor: pointer;
            }
            
            .sim-btn {
                margin-top: 10px;
                margin-left: 6px;
                color: white;
                text-align: center;
                font-size: 29px;
                cursor: pointer;
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
                margin: 5px;
                bottom: 0px;
                position: fixed;
                padding: 10px;
                color: black;
                text-align: center;
            }
            .line{
                margin-top: -5px;
                border-radius: 20%;
                width: 30%;
                height: 5px;
                background: gold;
            }
        </style>
    </head>
    <body class="body">
        <div>
          <img src="{{$image}}" class="logo" alt="{{$name}}">
        </div>
        <div>
          <h6 class="company">{{ $company }}</h6>
          <label class="line"></label>
          <p>{{ $name }}</p>
          <p style="margin-top:-10px;">{{ $designation }}</p>
        </div>
        
        <a href="https://api.whatsapp.com/send?phone={{$whatsapp}}" class="btn" style="margin-left: 35px;"><i class="fa fa-whatsapp"></i> whatsapp</a>
        <a href="tel:{{$number}}" class="btn"><i class="fa fa-phone"></i> Call</a>
        <a href="mailto:{{$email}}" class="btn"><i class="fa fa-google"></i> Mail</a>
        <a href="{{$website}}" class="btn"><i class="fa fa-internet-explorer"></i> Website</a>
        <a href="" class="btn"><i class="fa fa-location-arrow"></i> Location</a>
        
        <div style="margin-top:40px;width:100%;text-align:left;padding-left:45px;">
            <div style="vertical-center">
                <a href="mailto:{{$email}}" class="sim-btn"><i class="fa fa-phone"></i></a>
                <label>{{$number}}</label>
            </div>
            <div style="margin-top:15px;">
                <a href="mailto:{{$email}}" class="sim-btn"><i class="fa fa-google"></i></a>
                <label>{{ $email }}</label>
            </div>
            <div style="margin-top:15px;">
                <a href="{{$website}}" class="sim-btn"><i class="fa fa-internet-explorer"></i></a>
                <label>{{ $website }}</label>
            </div>
            <div style="margin-top:15px;">
                <a href="https://www.google.com/maps/place/{{$address}}" class="sim-btn"><i class="fa fa-location-arrow"></i></a>
                <label>{{ $address }}</label>
            </div>
        </div>
        
        <p style="margin-top:30px;color:cyan">
            {{ $about }}
        </p>
        
        <div class="about" style="display:block;text-align:center;margin-top:50px;">
            <a style="margin-left:20px;" href="https://www.facebook.com/{{$facebook}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/145/145802.png" alt="facebook"></a>
            <a style="margin-left:20px;" href="https://www.instagram.com/{{$instagram}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/3955/3955024.png" alt="instagram"></a>
            <a style="margin-left:20px;" href="https://www.youtube.com/c/{{$youtube}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/3670/3670147.png" alt="Youtube"></a>
            <a style="margin-left:20px;" href="https://www.twitter.com/{{$twitter}}"><img class="icon" src="https://cdn-icons-png.flaticon.com/512/145/145812.png" alt="Twitter"></a>
        </div>
        
        
    </body>
</html>