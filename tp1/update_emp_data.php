<?php
include 'busconnect.php';
?>

<?php
$updateeid=$_GET['updateeid'];
$eid="";
$eid=$_GET['updateeid'];
    $sql = "SELECT * FROM emp where eid='$eid'";
    $result=mysqli_query($conn,$sql);

    $row=mysqli_fetch_assoc($result);
         
            $eid=$row['eid'];
            $efname=$row['efname'];
            $emname=$row['emname'];
            $elname=$row['elname'];
            $eage=$row['eage'];
            $egender=$row['egender'];
            $esalary=$row['esalary'];
            $etype=$row['etype'];
            $edob=$row['edob'];
           
        
    
 
if(isset($_POST['submit'])){
    $eid=trim($_POST['eid']);
    $efname=trim($_POST['efname']);
    $emname=trim($_POST['emname']);
    $elname=trim($_POST['elname']);
    $eage=trim($_POST['eage']);
    $egender=trim($_POST['egender']);
    $esalary=trim($_POST['esalary']);
    $etype=trim($_POST['etype']);
    $edob=trim($_POST['edob']);


    $sql= "UPDATE emp set eid='$eid',efname='$efname',emname='$emname',elname='$elname',eage=$eage,egender='$egender' ,etype='$etype',esalary=$esalary where eid='$eid' ";
    $result = mysqli_query($conn,$sql);
    if($result){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>SUCCESS!</strong> Data updated successfully.
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>

    

   </div>';
    }
    else{
        die(mysqli_error($conn));
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

    <title>Employee Data</title>
  </head>
  <body>
   
    <div class="container mt-4" >
    <h1>Update Employee Data</h1>
    <form method ="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Employee Id</label>
    <input type="text" name="eid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Employee Number" value="<?php echo $updateeid; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">First Name</label>
    <input type="text" name="efname" class="form-control" id="exampleInputPassword1" placeholder="first name"value=<?php
    echo $efname;
    ?>>
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Middle Name</label>
    <input type="text" name="emname" class="form-control" id="exampleInputPassword1" placeholder="middle name"value=<?php
    echo $emname;
    ?>>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Last Name</label>
    <input type="text" name = "elname" class="form-control" id="exampleInputPassword1" placeholder="last name"value=<?php
    echo $elname;
    ?>>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date of Birth</label>
    <input type="date" name="edob" class="form-control" id="exampleInputPassword1" placeholder="dob"
    value=<?php
    echo $edob;
    ?>>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Age</label>
    <input type="text" name="eage" class="form-control" id="exampleInputPassword1" placeholder="age"value=<?php
    echo $eage;
    ?>>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Gender</label>
    <input type="radio" name="egender" value="male"value =<?php
    echo $egender;
    ?>>Male
    <input type="radio" name="egender" value="female" value =<?php
    echo $egender;
    ?>>Female
    
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Employee Type</label>
    <input type="radio" name="etype" value="Permanent" value =<?php
    echo $etype;
    ?>>Permanent
    <input type="radio" name="etype" value="Temporary"value =<?php
    echo $etype;
    ?>>Temporary
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Salary</label>
    <input type="text" name="esalary" class="form-control" id="exampleInputPassword1" placeholder="salary"value=<?php
    echo $esalary;
    ?>>
  </div>
  <button type="submit" name = "submit" class="btn btn-primary">Update</button>
  <button type="button" class="btn btn-primary ">
    <a href= "emp_data_display.php  "  class ="text-light">View Employee Data</a >    
</button>
</form>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>