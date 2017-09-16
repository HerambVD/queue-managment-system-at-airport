<?php
session_start();

if(isset($_POST['submit']))
{
    $r = intval($_POST['avg']/$_POST['arr']);
    $u = intval($_POST['avg'] * ($r/1-$r)*($_POST['arrm']*$_POST['arrm'] + $_POST['avgm']*$_POST['avgm'])/2);
    $_SESSION['r'] = $u;
}

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
         <form action="formula.php" method="post">
             <div class="form-group">
                <label class="control-label">Average Time for chekking:</label><br>
                 <input class="form-control col-sm-8 col-sm-offset-2" type="text" name="avg">
                 <label class="control-label">Arrival Time :</label><br>
                 <input class="form-control col-sm-8 col-sm-offset-2" type="text" name="arr">
                 <label class="control-label">Average Time Over Months :</label><br>
                 <input class="form-control col-sm-8 col-sm-offset-2" type="text" name="avgm">
                  <label class="control-label">Average Time for arrival over months :</label><br>
                 <input class="form-control col-sm-8 col-sm-offset-2" type="text" name="arrm">
                   <div class="col-sm-7 col-sm-offset-2">
             <button type="submit" name="submit" class="btn btn-primary">Enter</button>
             </div>
             </div>
         </form>
         
         </div>
     </div>