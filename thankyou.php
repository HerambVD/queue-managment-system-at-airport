<?php
error_reporting(1);
session_start();
$w = $_SESSION['id3'];
$t = $_SESSION['id4'];
$total = $w + $t;
$min = intval($total/60);
$sec = intval($total%60);


?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Queue Management System</title>
 
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link href="css/mystyles.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
 <body>
 <header class="jumbotron">
        <div class="container">
            <div class="row row-header">
                <div class="col-sm-8 col-sm-offset-2">
                    <center><h2 style="font-size:40px">Queue Management at Airport Using IOT Beacons </h2></center>
                    <p style="padding:20px;">Problem Statement : Passenger Facilitation regarding estimated wait
times at security check ins and other queues at
the airport .</p>
        
                </div>
            </div>
        </div>
    </header>
     <p style="padding:40px"></p> 
     <div class="container">
          <div class="col-sm-6 col-sm-offset-3" id="messageBox">
    
              <h3>Thank You For Patience. You Took Approx.<br> <?php echo $min." Min. & ".$sec." Sec." ?><br>
                  
                  Enjoy your Further Journey. 
                  
              </h3>
        </div>
                  <p style="padding:180px;"></p>

     </div>
    </body>