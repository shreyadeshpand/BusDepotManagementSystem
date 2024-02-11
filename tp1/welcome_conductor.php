

<?php
 include 'busconnect.php';
session_start();
$username = "";
$eid = "";
$date = "";
                        $busNo = '';
                        $rid = '';
                        $shiftno = '';
                        $shiftstart = '';
                        $shiftend = '';
                        $shiftone='';
                        $shifttwo='';

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
$sql = "SELECT * from conductor_login where username='$username'";
if (mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $eid = $row['eid'];
    //echo $eid;
   
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
if(isset($_POST['submit'])){
    if(empty(trim($_POST['date'])) || empty(trim($_POST['busNo'])) || empty(trim($_POST['rid'])) || empty(trim($_POST['shiftstart'])) || empty(trim($_POST['shiftend']))  ){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ALERT!</strong> Field cannot be empty.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
}

echo '
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <style>
            table tr:not(:first-child){
                cursor: pointer;transition: all .25s ease-in-out;
            }
            table tr:not(:first-child):hover{background-color: #ddd;}
        </style>


    <title>Todays Schedule</title>
  </head>
  <body>
  
  <form action="welcome_conductor.php" method="POST" id="myForm" onsubmit="submitForm()" >
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">welcome</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome_conductor.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="failure.php">Report Failure <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Logout<span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>
    
';
$sql1 = "SELECT * from conductor_view where eid='$eid'";
if (mysqli_query($conn, $sql1)) {
    $row1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
    $efname = $row1['efname'];
    echo '<h1 class="text-center"> Welcome ' . $efname . ' to conductors portal </h1>';
}
echo '
    <div class="form-group">
';
// marquee



$sql = "SELECT * FROM failure WHERE date = curdate() ";
$result = mysqli_query($conn, $sql);

if ($result) {
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $busNo = $row['busNo'];
    $date = $row['date'];
    $time = $row['time'];
    $location = $row['location'];
    echo $location;
    $round = $row['round'];
    $timestamp = strtotime($row['timestamp']); // Convert string timestamp to Unix timestamp

    $time = date("H:i:s", $timestamp);

    $new_time = date("H:i:s", strtotime($time . "+2 hours"));

    $new_timestamp = strtotime(date("Y-m-d", $timestamp) . " " . $new_time);

    $sql = "SELECT * FROM katrajfare WHERE stopno = $location";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stopname=$row['stopname'];
      }
    }

    $newbusNo='';
    
    $sql = "SELECT * FROM reassignedbus WHERE DATE(timestamp) = CURDATE() and oldBus='$busNo'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
   
        $row = mysqli_fetch_assoc($result);
        $newbusNo=$row['busNo'];
      
    }
    
      echo '<marquee behavior="scroll" direction="left">
      FAILURE OCCURED: Bus No: ' . $busNo . '  Location: ' . $stopname . ' Reassigned Bus No : '.$newbusNo.' 
      </marquee>';
    
  }
}



echo '<marquee behavior="scroll" direction="left">
TODAYS SCHEDULE';
$sql = "SELECT * from completeschedule where date=curdate() and eid='$eid'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Display the information as a marquee
  
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
       $busNo = $row['busNo'];
        $rid = $row['rid'];
        $shiftno = $row['shiftno'];
        $shiftstart = $row['shiftstart'];
        $shiftend = $row['shiftend'];
        

       

        echo "  Bus No: $busNo - Shift No : $shiftno - shiftstart : $shiftstart - shiftend : $shiftend - Route No: $rid  |  ";
    }

  }
    else {
        echo "  - YAYY!! No schedule today!!";
    }
     

   
} else {
    // If the query failed, handle the error
    echo "Error: " . mysqli_error($conn);
}

	 echo'</marquee>';
 

    echo '<label for="exampleInputPassword1">Date</label>
    <input type="date" name="date"  class="form-control" id="date" placeholder=" eg: 18-06-2023" value="'.$date.'">
  </div>
  <div class="form-group">
  <label for="exampleInputPassword1">Bus Number</label>
  <input type="text" name="busNo"  class="form-control" id="busNo" placeholder=" eg: b203" value="'.$busNo.'">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Route ID</label>
<input type="rid" name="rid"  class="form-control" id="rid" placeholder=" eg: r54" value="'.$rid.'">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Shift Number (1/2)</label>
<input type="shiftno" name="shiftno"  class="form-control" id="shiftno" placeholder=" eg: 1/2" value="'.$shiftno.'">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Shift Start</label>
<input type="shiftstart" name="shiftstart"  class="form-control" id="shiftstart" placeholder=" eg:00:00:00" value="'.$shiftstart.'">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Shift End</label>
<input type="shiftend" name="shiftend"  class="form-control" id="shiftend" placeholder=" eg: 00:00:00" value="'.$shiftend.'">
</div>';

$sql = "SELECT * FROM completeschedule WHERE eid = '$eid' AND date = curdate()";
$result = mysqli_query($conn, $sql);
if ($result) {
  $rowcount=mysqli_num_rows($result);
  if($rowcount==0){
    
      echo '<div class="alert alert-primary" role="alert">
      No schedules assigned.
    </div>';
    
  }
  else{

    echo '<table id="table" border="1" class="table my-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">BusNo </th>
                <th scope="col">Route No </th>
                <th scope="col">Shift No </th>
                <th scope="col">Shift Start </th>
                <th scope="col">Shift End</th>
              
            </tr>
        </thead>
        <tbody>';
        
           
                
                
                    $i = 0;

                    while ($row = mysqli_fetch_assoc($result)) {

                        $date = $row['date'];
                        $busNo = $row['busNo'];
                        $rid = $row['rid'];
                        $shiftno = $row['shiftno'];
                        $shiftstart = $row['shiftstart'];
                        $shiftend = $row['shiftend'];
                        $shiftone='';
                        $shifttwo='';
                        if($shiftno==1){
                          $shiftone=1;

                        }
                        if($shiftno==2){
                          $shifttwo=2;
                        }

                        echo '<tr data-row-id="' . $i . '">
                                <td>' . $date . '</td>
                                <td>' . $busNo . '</td>
                                <td>' . $rid . '</td>
                                <td>' . $shiftno . '</td>
                                <td>' . $shiftstart . '</td>
                                <td>' . $shiftend . '</td>
                                
                            </tr>';
                        $i++;
                    }
                  
                  
                
         
        echo '</tbody>
    </table>
    <button type="submit" name = "submit" class="btn btn-primary">Submit</button>
    </div>
    ';
    
  
    
    
    echo '<script>
                var table = document.getElementById("table");
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         //rIndex = this.rowIndex;
                         document.getElementById("date").value = this.cells[0].innerHTML;
                         document.getElementById("busNo").value = this.cells[1].innerHTML;
                         document.getElementById("rid").value = this.cells[2].innerHTML;
                         document.getElementById("shiftno").value = this.cells[3].innerHTML;
                         document.getElementById("shiftstart").value = this.cells[4].innerHTML;
                         document.getElementById("shiftend").value = this.cells[5].innerHTML;
                         
                    }
                }
    
                function submitForm() {
        document.getElementById("myForm").submit();
    }

         </script>';
      
//on submit this will happen


  
$date = isset($_POST['date']) ? $_POST['date'] : "";
$busNo = isset($_POST['busNo']) ? $_POST['busNo'] : "";
$rid = isset($_POST['rid']) ? $_POST['rid'] : "";
$shiftno = isset($_POST['shiftno']) ? $_POST['shiftno'] : "";
$shiftstart = isset($_POST['shiftstart']) ? $_POST['shiftstart'] : "";
$shiftend = isset($_POST['shiftend']) ? $_POST['shiftend'] : "";
$newdate = isset($_POST['date']) ? $_POST['date'] : "";
$newbusNo = isset($_POST['busNo']) ? $_POST['busNo'] : "";

$sql="SELECT * FROM tickets WHERE date='$date' and busNo='$busNo'";
$result = mysqli_query($conn, $sql);
if($result){

// Use the values as needed
// echo "Date: " . $date . "<br>";
// echo "BusNo: " . $busNo . "<br>";
// echo "rid: " . $rid . "<br>";
// echo "shiftno: " . $shiftno . "<br>";
// echo "shiftstart: " . $shiftstart . "<br>";
// echo "shiftend: " . $shiftend . "<br>";
  $row = mysqli_fetch_assoc($result);
  if($row>0){
    $amtcollected = $row['amtcollected'];
    $nooftickets = $row['nooftickets'];
    
    echo "
    <div class='form-group'>
    Amount Collected  : " . $amtcollected . "<br>"
    ;
    echo "Number of Tickets Collected : " . $nooftickets . "<br>
    </div>";
  }
   else{
    $amtcollected=0;
    $nooftickets =0;
   }    
}
$curtime = date('h:i:s');
//echo "current time :".$curtime."<br>";
// if($shiftstart<=$curtime && $curtime<=$shiftend){
//     echo '<button class="btn btn-primary">   <a href="collectticket.php?rid='.$rid.'&busNo='.$busNo.'&date='.$date.'&shiftstart='.$shiftstart.'&shiftend='.$shiftend.'" class ="text-light">Collect Ticket </a></button>';
// }
// else{
//     echo "shift ended!!";
//     echo "Total Amount Collected : " . $amtcollected . "<br>";
//         echo "Total Number of Tickets Collected : " . $nooftickets . "<br>";
// }
echo '<button class="btn btn-primary">   <a href="collectticket.php?rid='.$rid.'&busNo='.$busNo.'&date='.$date.'&shiftstart='.$shiftstart.'&shiftend='.$shiftend.'" class ="text-light">Collect Ticket </a></button>';

}
}
?>




 </form>
</div>
 <!-- form end   -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
