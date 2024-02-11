<?php
include 'busconnect.php';
?>

<?php


if(isset($_POST['failuresubmit'])){
 
  $date=trim($_POST['date']);
  $time=trim($_POST['time']);
  $busNo=trim($_POST['busNo']);
  $stopno=trim($_POST['stopno']);
  
  
 if(empty(trim($_POST['date'])) || empty(trim($_POST['time'])) || empty(trim($_POST['busNo'])) || empty(trim($_POST['stopno']))  ){
    $err = "Fileds cannot be blank";
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>ALERT!</strong> Field cannot be empty.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}


else{
  $sql= "INSERT into  failure (date,time,busNo,location) values ('$date','$time','$busNo','$stopno')";
  
  $result = mysqli_query($conn,$sql);
  if($result ){
    $sql= "SELECT * from reassignedbus order by timestamp limit 1 ";
    $result1=mysqli_query($conn,$sql);
    if($result1){
      $row1=mysqli_fetch_assoc($result1);
      $busNo=$row1['busNo'];

    
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>SUCCESS!</strong> Failure updated successfully. And New Updated Bus for this schedule is '.$busNo.'
   
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
  }
  else{
      die(mysqli_error($conn));
  }
}

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Failure Details</title>
  </head>
  <body>
   
    <div class="container mt-4">
      <h1>Enter Failure Details</h1>
     
      <form method="POST">
        <div class="form-group">
          <label for="date">Enter date :</label>
          <input type="date" id="date" name="date" value="<?php echo date('Y-m-d')?>" readonly>
        </div>

        <div class="form-group">
          <label for="time">Enter time :</label>
          <input type="time" id="time" name="time" value="<?php echo date("H:i:s"); ?>" readonly>
        </div>
        <!-- busNo -->
<div class="form-group">
<label for="busNo">Bus Number</label>
    <select name="busNo">
      <option value="" >Bus Number </option>
      <?php
    $sql = "SELECT busNo FROM schedule WHERE date = CURDATE() AND busno NOT IN (SELECT busNo FROM failure WHERE date = CURDATE())";
      $table = mysqli_query($conn,$sql);
      $total_rows=mysqli_num_rows($table);
      for($i=0;$i<$total_rows;$i++){
        $row=mysqli_fetch_assoc($table);
      ?>
      <option value = "<?php echo $row['busNo'] ?>" > <?php echo $row['busNo'] ?> </option>
<?php
      }
?>
 </select>
</div>

<!-- busNo -->

<!-- stop -->
<div class="form-group">
<label for="stopno">location</label>
<select name="stopno">
      <option value="" >Nearest stop </option>
      <?php
      $sql = "SELECT * FROM katrajfare";
      $table = mysqli_query($conn,$sql);
      $total_rows=mysqli_num_rows($table);
      for($i=0;$i<$total_rows;$i++){
        $row=mysqli_fetch_assoc($table);
      ?>
      <option value = "<?php echo $row['stopno'] ?>" > <?php echo $row['stopname'] ?> </option>
<?php
      }
?>
 </select>
</div>
        
        <div class="form-group">
        <button type="submit" name = "failuresubmit" class="btn btn-primary">Submit</button>
       
        </div>
      
 
      </form>
    </div>
    
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </body>
</html>