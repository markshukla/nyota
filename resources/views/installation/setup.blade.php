<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Poster Banao</title>
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url('/installation/style.css') }}">

</head>
<body>
<!-- partial:index.partial.html -->
<!-- MultiStep Form -->
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form id="msform">
            <!-- progressbar -->
            @if(session('message') != "")
                <div class="alert alert-danger">
                    <ul>
                        <li>{{session('message')}} </li>
                    </ul>
                </div>
            @endif
            
            <ul id="progressbar">
                <li class="active">Server Requirment</li>
                <li>Purchase Verify</li>
                <li>Final Setup</li>
            </ul>
            <!-- fieldsets -->
            <fieldset>
                <h2 class="fs-title">Server Requirment</h2>
                
                <?php
                   $value1 = 7.4;
                   $value2 = phpversion();
                   
                   
                ?>
                 
                
                <h3 class="labelinfo">PHP Version (>= <?= $value1; ?>) <label><?= ($value1 <= $value2) ? '✅' : '❌'?><label></h3>
                
                <?php $pdo_extension = class_exists('PDO'); ?>
                
                
                <?php $openssl_extension = extension_loaded('openssl'); ?>
                
                <h3 class="labelinfo">OpenSSL PHP Extension <label><?= ($openssl_extension) ? '✅' : '❌'?><label></h3>
                
                <?php $zip_extension = extension_loaded('zip'); ?>
                
                <h3 class="labelinfo">ZipArchive Extension <label><?= ($zip_extension) ? '✅' : '❌'?><label></h3>

                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                
                <h2 class="fs-title">Purchase Verify</h2>

                <input type="text" id="username" name="username" placeholder="Envanto Username"/>
                <input type="text" id="code" name="code" placeholder="Purchase Code"/>
                <h3 id="errorTv" style="color:red;font-weight:bold;" class="fs-subtitle"></h3>

                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="button" name="next" class="verify action-button" value="Verify"/>
                
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Database Setup</h2>
                
                <input type="text" name="db_host" id="db_host" placeholder="Database host" value="localhost"/>
                <input type="text" name="db_name" id="db_name" placeholder="Database Name"/>
                <input type="text" name="db_username" id="db_username" placeholder="Database Username"/>
                <input type="text" name="db_password" id="db_password" placeholder="Database Password"/>
                <h3 id="errorTv2" style="color:red;font-weight:bold;" class="fs-subtitle"></h3>
                
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="button" name="submit" class="submit action-button" value="Submit"/>
                
            </fieldset>
        </form>
        
    </div>
</div>
<!-- /.MultiStep Form -->
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
<script src="{{ url('/installation/script.js?='.time()) }}"></script>
</body>
</html>
