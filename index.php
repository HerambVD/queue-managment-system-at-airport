<?php
ob_start();
session_start();
require 'db.php';


if(isset($_POST['submit']))
{
    $_SESSION['ticket_no'] =  $_POST['ticket_no'];
$ticket_no = $_POST['ticket_no'];
    
    
    $sql111 = "SELECT * FROM queue_goair_emirates WHERE ticket_no = $ticket_no";
$result111 = mysqli_query($connection, $sql111);
    $rowsss = mysqli_num_rows($result111);
    if($rowsss > 0)
    {
        header("location: second.php");
    }
      
    
$sql1 = "SELECT * FROM boarding_pass WHERE ticket_no = $ticket_no";
$result1 = mysqli_query($connection, $sql1);
$row = mysqli_fetch_array($result1);


    $id = $row['id'];
    $ticket_no = $row['ticket_no'];
    $airline = $row['airline'];
    $full_name = $row['full_name'];
    $departure = $row['departure'];
    $source = $row['source'];
    $destination = $row['destination'];
    $arrival = $row['arrival'];
    $date = $row['date'];    



$sql2 = "SELECT id,departure FROM queue";
$result2 = mysqli_query($connection, $sql2);
$rows = mysqli_num_rows($result2);
if($rows == 0)
{
   
  $sql5 = "INSERT INTO queue (ticket_no,airline,full_name,departure,source,destination,arrival,date) VALUES ('$row[ticket_no]', 
'$row[airline]', 
 '$row[full_name]', 
 '$row[departure]',
'$row[source]',
 '$row[destination]', 
'$row[arrival]', 
'$row[date]' ) ";  
    
      $result5 = mysqli_query($connection, $sql5);
      $id3=1*65;

    
}
  

else
{
    while($row2 = mysqli_fetch_assoc($result2))
    {
         $id2 = $row2['id'];
            $departure2 = $row2['departure'];
        
        if($departure < $departure2)
        {
        
             $sql3 = "UPDATE queue SET id = id-1 WHERE id<=$id2 ORDER BY id ASC ";
$result3 = mysqli_query($connection, $sql3);

    $sql4 = "INSERT INTO queue (id,ticket_no,airline,full_name,departure,source,destination,arrival,date) VALUES ('$id2', '$row[ticket_no]',
'$row[airline]', 
 '$row[full_name]', 
 '$row[departure]',
'$row[source]',
 '$row[destination]', 
'$row[arrival]', 
'$row[date]' ) ";
    
    $result4 = mysqli_query($connection, $sql4);
    

    
            break;
            
        }
    }
    
     $sql3 = "UPDATE queue SET id = id+1 WHERE id>=$id2 ORDER BY id ASC ";
$result3 = mysqli_query($connection, $sql3);

    $sql4 = "INSERT INTO queue (id,ticket_no,airline,full_name,departure,source,destination,arrival,date) VALUES ('$id2', '$row[ticket_no]',
'$row[airline]', 
 '$row[full_name]', 
 '$row[departure]',
'$row[source]',
 '$row[destination]', 
'$row[arrival]', 
'$row[date]' ) ";
    
    $result4 = mysqli_query($connection, $sql4);
    
    $id3 = $id2-1;
    $id3 = $id3*65;
    
$sql6 = "ALTER TABLE `queue` DROP `id`";
$result6 = mysqli_query($connection, $sql6);
$sql7 = "ALTER TABLE `queue` AUTO_INCREMENT = 1";
$result7 = mysqli_query($connection, $sql7);
$sql8 = "ALTER TABLE `queue` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
$result8 = mysqli_query($connection, $sql8);
        
  
    
    mysqli_close($connection);
    
}
 $_SESSION['id4'] = $id3;

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
    <center>
         <div class="col-sm-6 col-sm-offset-3" id="messageBox">
     <form class="form"  action="index.php" method ="post">
         <div class="form-group">
        
         <label style="font-size=40px;">Please Enter Your Ticket Number: <font style="color:#FF0000">*</font></label><br>
        <div class="col-sm-8 col-sm-offset-2">
        <input class="form-control" placeholder="Ticket Number" type="text" name="ticket_no" id="ticket_no"><br>
        </div>
         <div class="col-sm-7 col-sm-offset-2">
             <button type="submit" name="submit" class="btn btn-primary">Enter</button>
             </div>
         </div>
         
         
         
         
         </form>
        </div>
           </center>
          <p style="padding:80px"></p>
         <div class="col-sm-6 col-sm-offset-3" id="timerbox">
             <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
            <label>Your Estimated Time To Wait is :</label></div><br>
        <div class="col-sm-9 col-sm-offset-4" id="timerdiv">
         <span id="timer">00:00</span>
                 </div></div>
         </div>
     </div>
     <p style="padding:80px"></p>
     <script type="text/javascript">
     window.onload = function()
        {
        
        var min = parseInt(<?php echo $id3; ?>);
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
                                    
                                }
                        
                            
                        }
                }
          
                
},1000);
            
    }
     </script>
  
</body>
</html>

<?php
if(isset($_POST['submit']))
{
   
}
?>