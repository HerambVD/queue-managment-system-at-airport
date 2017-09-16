<?php 
session_start();
include 'db.php';
 $session = $_SESSION['ticket_no'];

$sql1 = "SELECT * FROM queue_goair_emirates WHERE ticket_no = $session";
$result1 = mysqli_query($connection, $sql1);
$row = mysqli_fetch_array($result1);


    $id = $row['id'];

  $id3 = $id-1;
    $id3 = $id3*65;
    $_SESSION['id3'] = $id3;
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
   
    
         <div class="col-sm-6 col-sm-offset-3" id="timerbox">
             <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
            <label>Your Estimated Time To Wait is :</label></div><br>
        <div class="col-sm-9 col-sm-offset-4">
         <span id="timer">00:00</span>
                 </div></div>
         </div>
     </div>
     <p style="padding:80px"></p>
    
    
    <script type="text/javascript">
     window.onload = function()
        {
        
        var min = parseInt(<?php echo $id3;?>);
        var minn =parseInt(min/60);
        var sec = parseInt(min%60)+1;
        
        var uu = setInterval(function(){
            document.getElementById("timer").innerHTML = minn +":"+ sec;
            
       
            sec--;
            if(sec==00)
                {
                    minn--;
                    sec=60;
                    if(minn==0)
                                        {
                                            alert("Plaese Proceed Towards Queue");
                                        }
                    if(minn==-1)
                        {
                            if(confirm("Do You Want To Be In The Queue ?"))
                            {
                                minn = parseInt(min/60);
                            }
                            else
                                {
                                    
                                    clearInterval(uu);
                                    document.getElementById("timer").innerHTML = 00 +":"+ 00;
                                    window.location.href = "thankyou.php";
                                    
                                }
                        
                            
                        }
                }
          
                
},1000);
            
    }
     </script>
</body>
</html>