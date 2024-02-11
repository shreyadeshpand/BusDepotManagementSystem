

<?php
 include 'busconnect.php';
?>

<?php
session_start();
$username = "";
$eid = "";

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
$sql = "SELECT * from conductor_login where username='$username'";
if (mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $eid = $row['eid'];
    //echo $eid;
    $sql1 = "SELECT * from conductor_view where eid='$eid'";
    if (mysqli_query($conn, $sql1)) {
        $row1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
        $ename = $row1['ename'];
        echo '<h1 class="text-center"> Welcome ' . $ename . ' to conductors portal </h1>';
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
  
  <form action="welcome_conductor.php" method="POST" id="myForm">
  

    <h1 class="text-center">
        Welcome <?php echo $ename; ?> to the conductors portal
    </h1>
      
    Date:<input type="text" name="date" id="date"><br><br>
    BusNo:<input type="text" name="busNo" id="busNo"><br><br>
    Route:<input type="text" name="rid" id="rid"><br><br>
    Route:<input type="text" name="shiftno" id="shiftno"><br><br>
    Route:<input type="text" name="shiftstart" id="shiftstart"><br><br>
    Route:<input type="text" name="shiftend" id="shiftend"><br><br>
        

    <table id="table" border="1">
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
        <tbody>
        ';
           
                $sql = "SELECT * FROM completeschedule WHERE eid = '$eid' AND date = curdate()";
                $result = mysqli_query($conn, $sql);
                if ($result) {
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
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
         
        echo '</tbody>
    </table>
    <input type="submit" value="Submit">
    ';
    
    ?>
    </div>
    <script>
    
                var table = document.getElementById('table');
                
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

         </script>
  

<?php
$date = isset($_POST['date']) ? $_POST['date'] : "";
$busNo = isset($_POST['busNo']) ? $_POST['busNo'] : "";
$rid = isset($_POST['rid']) ? $_POST['rid'] : "";
$shiftno = isset($_POST['shiftno']) ? $_POST['shiftno'] : "";
$shiftstart = isset($_POST['shiftstart']) ? $_POST['shiftstart'] : "";
$shiftend = isset($_POST['shiftend']) ? $_POST['shiftend'] : "";

// Use the values as needed
echo "Date: " . $date . "<br>";
echo "BusNo: " . $busNo . "<br>";
echo "rid: " . $rid . "<br>";
echo "shiftno: " . $shiftno . "<br>";
echo "shiftstart: " . $shiftstart . "<br>";
echo "shiftend: " . $shiftend . "<br>";
$i = 0;
$sql = "SELECT * from stops where rid='$rid'";
$result = mysqli_query($conn, $sql);
while ($row3 = mysqli_fetch_assoc($result)) {
    $stopname = $row3['stopname'];
    ?>
    <input type="radio" id="<?php echo $stopname; ?>" name="stops" value="<?php echo $stopname; ?>">
    <?php echo $row3["stopname"]; ?><br>
    <?php
    $i++;
  }
 echo ' Number of People:
<input type="radio" name="people" value="1">1
<input type="radio" name="people" value="2">2
<input type="radio" name="people" value="3">3
<input type="radio" name="people" value="4">4
<input type="radio" name="people" value="5">5

<button type="submit" name="radiosubmit">Submit</button>';
if (isset($_POST['radiosubmit'])) {
  // Retrieve the selected values
  $selectedStop = $_POST['stops'];
  $selectedPeople = $_POST['people'];

  // Use the values as needed
  echo "Selected Stop: " . $selectedStop . "<br>";
  echo "Selected People: " . $selectedPeople . "<br>";
  $sql="SELECT * from katrajfare where stopname= '$selectedStop'";
  $result = mysqli_query($conn, $sql);
  if($result){
    $row = mysqli_fetch_assoc($result);
    $stopno=$row['stopno'];
    $stopname=$row['stopname'];
    $fare=$row['fare'];

    $sql = "SELECT calculateTotalPeople('$date', '$busNo', '$selectedStop', '$fare') AS total_people";
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      if($row){
        $totalpeople = $row['total_people'];
        echo 'Total People: ' . $totalpeople;
      }
      else{
        echo 'Error executing SQL statement: ' . mysqli_error($conn);
      }
      
  } else {
      echo 'Error executing SQL statement: ' . mysqli_error($conn);
  }
  }

}

?>
 </form>
 <!-- form end   -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
