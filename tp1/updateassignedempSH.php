<?php
include 'busconnect.php'; 

echo '


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Update Assigned Employee</title>
  </head>
  <body>

  <form method ="post" mt-4>

  <div class="alert alert-primary" role="alert">

  ';
  
  if(isset($_GET['rid'], $_GET['eid'], $_GET['ejob'], $_GET['busNo'], $_GET['shiftNo'])){
    $rid = $_GET['rid'];
    $eid = $_GET['eid'];
    $ejob = $_GET['ejob'];
    $busNo = $_GET['busNo'];
    $shiftNo = $_GET['shiftNo'];
  echo '  <input type="hidden" name="busNo" value="<?php echo $busNo ?>">
<input type="hidden" name="shiftNo" value="<?php echo $shiftNo ?>">';

  
  echo "You are replacing employee ".$eid." assigned to bus no ".$busNo. " for shift no ".$shiftNo; 
  }
  
echo '</div>';



// <!-- busNo -->
echo '<div class="form-group">
<label for="busNo">Employee</label>
    <select name="eid">
      <option value="" >Employee </option>';
      
      $sql = "SELECT eid ,ename  FROM conductor_view WHERE eid NOT IN (SELECT eid FROM assignedemp WHERE date=CURDATE() and busNo='$busNo' and shiftno='$shiftNo')";
      $table = mysqli_query($conn,$sql);
      $total_rows=mysqli_num_rows($table);
      for($i=0;$i<$total_rows;$i++){
        $row=mysqli_fetch_assoc($table);
        $eid=$row['eid'];
        $ename=$row['ename'];
        


         
echo '<option value="' . $eid . '">' . $eid . " - " . $ename . '</option>';
      }

 echo '</select>
</div>

<!-- busNo -->

  <button type="submit" name = "submit" class="btn btn-primary">Assign Employee</button>
    <div class="container mt-5">
    <h1>Update Assigned Employee</h1>
   
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">EID</th>
      <th scope="col">Employee Name</th>
      <th scope="col">Employee Job</th>
      <th scope="col">Employee Type</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody>';

  
  if($ejob==3){
    $sql = "SELECT * from conductor_view where eid not in (select eid from assignedemp where date = CURDATE())";
    $result=mysqli_query($conn,$sql);
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $eid=$row['eid'];
            $ename=$row['ename'];
            $etype=$row['etype'];
            $jobtype='conductor';
            echo '<tr>
        <th scope="row">'.$eid.'</th>
        <td>'.$ename.'</td>
        <td>'.$etype.'</td>
        <td>'.$jobtype.'</td>
        <td>
            <button class="btn btn-primary assign-employee-btn" type="button" data-task-id="' . $eid . '"> ASSIGN EMPLOYEE</button>
            <input type="hidden" name="neweid" value="' . $eid . '">
        </td>
      </tr>';

        }
    }
  }
  
  
  echo '</tbody>
</table>';


mysqli_close($conn);
echo '
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</form>
  </body>
</html>';



?>