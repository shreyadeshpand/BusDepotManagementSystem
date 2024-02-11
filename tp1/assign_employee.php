
<?php

include 'busconnect.php';

if(isset($_GET['success']) ) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Employee assigned successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
  if(isset($_GET['error_row'],$_GET['alreadyexists']) ) {
    $error_row=$_GET['error_row'];
    $eid=$_GET['eid'];

    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Alert !</strong> Employee already assigned for the shift Employee ID:
      '.$eid ;
      echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
if(isset($_GET['busNo']) and isset($_GET['date']) and isset($_GET['rid'])){

    $date = $_GET['date'];
    $formatted_date = date("Y-m-d", strtotime($date));
    $displaydate=$formatted_date;

    $displaybusNo = $_GET['busNo'];
    echo $displaybusNo;
    $displayrid = $_GET['rid'];
    $displaytripstart = $_GET['tripstart'];
    $displaytripend = $_GET['tripend'];
    $busNo = $_GET['busNo'];
    echo $busNo;
    $rid = $_GET['rid'];
    $tripstart = $_GET['tripstart'];
    $tripend = $_GET['tripend'];


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

    <title>Assign Employee</title>
  </head>
  <body>
    <div class="container mt-4">
        <h1>Assign employee</h1>
        <!-- form -->
        <form method ="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Bus Number </label>
                <input type="text" class="form-control" id="busNo" name="busNo" value="<?php echo $displaybusNo ?>" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Route Number </label>
                <input type="text" class="form-control" id="rid" name="rid" value="<?php echo $displayrid ?>" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Trip Start </label>
                <input type="text" class="form-control" id="tripstart" name="tripstart" value="<?php echo $displaytripstart ?>" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Trip End </label>
                <input type="text" class="form-control" id="tripend" name="tripend" value="<?php echo $displaytripend ?>" disabled>
            </div>

            <!-- checking if driver conductor assigned -->
            <?php
//for conductor 3 shift 1
$shift_no = 1;
$ejob = 3;
$query_conductor_shift1 = "SELECT * FROM assignedemp WHERE date='$formatted_date' and shiftno='$shift_no' and ejob=$ejob and busNo='$busNo'";
$result_conductor_shift1 = mysqli_query($conn, $query_conductor_shift1);
if ($result_conductor_shift1) {
    $assigned_conductor_shift1 = mysqli_num_rows($result_conductor_shift1) > 0;
} else {
    die(mysqli_error($conn));
}

//for conductor 3 shift 2
$shift_no = 2;
$ejob = 3;
$query_conductor_shift2 = "SELECT * FROM assignedemp WHERE  date='$formatted_date' and shiftno='$shift_no' and ejob=$ejob and busNo='$busNo'";
echo $busNo;
$result_conductor_shift2 = mysqli_query($conn, $query_conductor_shift2);
if ($result_conductor_shift2) {
    $assigned_conductor_shift2 = mysqli_num_rows($result_conductor_shift2) > 0;
} else {
    die(mysqli_error($conn));
}

//for driver 2 shift 1
$shift_no = 1;
$ejob = 2;
$query_driver_shift1 = "SELECT * FROM assignedemp WHERE  date='$formatted_date' and shiftno='$shift_no' and ejob=$ejob and busNo='$busNo'";
echo $busNo;
$result_driver_shift1 = mysqli_query($conn, $query_driver_shift1);
if ($result_driver_shift1) {
    $assigned_driver_shift1 = mysqli_num_rows($result_driver_shift1) > 0;
} else {
    die(mysqli_error($conn));
}
//for driver2 shift 2

$shift_no = 2;
$ejob = 2;
$query_driver_shift2 = "SELECT * FROM assignedemp WHERE date='$formatted_date' and shiftno='$shift_no' and ejob=$ejob and busNo='$busNo'";
$result_driver_shift2 = mysqli_query($conn, $query_driver_shift2);
if ($result_driver_shift2) {
    $assigned_driver_shift2 = mysqli_num_rows($result_driver_shift2) > 0;
} else {
    die(mysqli_error($conn));
}
?>

<?php if (!$assigned_conductor_shift1 && !$assigned_conductor_shift2): ?>
    <button type="submit" name="conductor" class="btn btn-primary">Assign Conductor</button>
    <small>no conductors assigned</small>
<?php elseif (!$assigned_conductor_shift1 && $assigned_conductor_shift2): ?>
    <button type="submit" name="conductor" class="btn btn-primary">Assign Conductor</button>
    <small>shift 2 conductor assigned</small>
<?php elseif ($assigned_conductor_shift1 && !$assigned_conductor_shift2): ?>
    <button type="submit" name="conductor" class="btn btn-primary">Assign Conductor</button>
    <small>shift 1 conductor assigned</small>
<?php elseif ($assigned_conductor_shift1 && $assigned_conductor_shift2): ?>
    <button type="submit" name="conductor" class="btn btn-primary" disabled>Assign Conductor</button>
    <small>both shifts conductor assigned</small>
<?php endif; ?>

<?php if (!$assigned_driver_shift1 && !$assigned_driver_shift2): ?>
    <button type="submit" name="driver" class="btn btn-primary">Assign Driver</button>
    <small>no drivers assigned</small>
<?php elseif (!$assigned_driver_shift1 && $assigned_driver_shift2): ?>
    <button type="submit" name="driver" class="btn btn-primary">Assign Driver</button>
    <small>shift 2 driver assigned</small>
<?php elseif ($assigned_driver_shift1 && !$assigned_driver_shift2): ?>
    <button type="submit" name="driver" class="btn btn-primary">Assign Driver</button>
    <small>shift 1 driver assigned</small>
<?php elseif ($assigned_driver_shift1 && $assigned_driver_shift2): ?>
    <button type="submit" name="driver" class="btn btn-primary" disabled>Assign Driver</button>
    <small>both shifts driver assigned</small>
<?php endif; ?>


            <button type="submit" name="gotobusschedule" class="btn btn-danger">
            <a href= "bus_schedule_data.php  "  class ="text-light">Go to Bus Schedule</a >    
            </button>
            <button type="submit" name="viewassignment" class="btn btn-danger">
            View Assignment
            </button>
        </form>
        <!-- form end -->

        <!-- on view assignment -->
<!-- on view assignment -->
<?php

if (isset($_POST['viewassignment'])) {
    if (isset($_GET['busNo']) and isset($_GET['date']) and isset($_GET['rid'])) {
        $date = $_GET['date'];
        $formatted_date = date("Y-m-d", strtotime($date));
        $displaybusNo = $_GET['busNo'];
        $displayrid = $_GET['rid'];
        $displaytripstart = $_GET['tripstart'];
        $displaytripend = $_GET['tripend'];
        $busNo = $_GET['busNo'];
        $rid = $_GET['rid'];
        $tripstart = $_GET['tripstart'];
        $tripend = $_GET['tripend'];
    } else {
        die(mysqli_error($conn));
    }
    echo '<table class="table my-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">DATE</th>
                    <th scope="col">ROUTE ID</th>
                    <th scope="col">BUS NO</th>
                    <th scope="col">SHIFT INFO</th>
                    <th scope="col">ASSIGNED EMPLOYEE</th>
                    <th scope="col">JOB</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>';

            $sql = "SELECT * FROM assignedemp WHERE date='$formatted_date' AND busNo='$busNo' ORDER BY date,eid";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $date = $row['date'];
                    $eid = $row['eid'];
                    $ejob = $row['ejob'];
                    $busNo = $row['busNo'];
                    $shiftno = $row['shiftno'];
            if($ejob==2){
                $jobtype='driver';
            }
            else if($ejob==3){
                $jobtype='conductor';
            }
                    $sql1 = "SELECT * FROM emp WHERE eid='$eid'";
                    $res1 = mysqli_query($conn, $sql1);
                    if ($res1) {
                        $name = ''; // initialize name to an empty string
                        while ($row1 = mysqli_fetch_assoc($res1)) {
                            $efname = $row1['efname'];
                            $emname = $row1['emname'];
                            $elname = $row1['elname'];
                            $name .= $eid . " - " .$efname . " " . $emname . " " . $elname . ", "; // concatenate employee names
                        }
                        $name = rtrim($name, ", "); // remove the trailing comma and space
            
                        echo '<tr>
                                <th scope="row">' . $date . '</th>
                                <td>' . $rid . '</td>
                                <td>' . $busNo . '</td>
                                <td>' . $shiftno . '</td>
                                <td>' . $name . '</td>
                                <td>' . $jobtype . '</td>
                                <td>';

                                if($jobtype=="conductor"){
                                   echo '<button class="btn btn-primary"><a href="test2.php?rid='.$rid.'&eid='.$eid.'&ejob='.$ejob.'&busNo='.$busNo.'&shiftNo='.$shiftno.'&date='.$date
                                    .'" class="text-light">UPDATE</a></button>';
                                }
                                if($jobtype=="driver"){
                                    echo '<button class="btn btn-primary"><a href="updateassigneddriver.php?rid='.$rid.'&eid='.$eid.'&ejob='.$ejob.'&busNo='.$busNo.'&shiftNo='.$shiftno.'&date='.$date
                                    .'" class="text-light">UPDATE</a></button>';

                                }
                            echo '    </td>
                            </tr>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger">No assigned employee found for the selected date, bus number and route ID.</div>';
            }
    echo '</tbody>
    </table>
    </div>';
}
?>

 
 <!-- on conductor click -->

 <?php
if(isset($_POST['conductor'])){
    echo '
    <form method="post">
        <input type="hidden" name="date" value="'.$formatted_date.'">
        <input type="hidden" name="busNo" value="'.$busNo.'">
        <input type="hidden" name="rid" value="'.$rid.'">
        <input type="hidden" name="tripstart" value="'.$tripstart.'">
        <input type="hidden" name="tripend" value="'.$tripend.'">
        <table class="table my-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">eid</th>
                    <th scope="col">Conductor Name</th>
                    <th scope="col">Conductor Type</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>';
//changed
$sql = "SELECT * FROM conductor_view ";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $eid = $row['eid'];
        $employee_name = $row['ename'];
        $employee_type = $row['etype'];
        $shift_no = 1;

        // Check if employee is present in assigned shift 1
        $query_shift1 = "SELECT * FROM assignedemp WHERE eid='$eid' and date='$formatted_date' and shiftno='$shift_no'";
        $result_shift1 = mysqli_query($conn, $query_shift1);
        if ($result_shift1) {
            $assigned_shift1 = mysqli_num_rows($result_shift1) > 0;
        } else {
            die(mysqli_error($conn));
        }

        // Check if employee is present in assigned shift 2
        $shift_no = 2;
        $query_shift2 = "SELECT * FROM assignedemp WHERE eid='$eid' and date='$formatted_date' and shiftno='$shift_no'";
        $result_shift2 = mysqli_query($conn, $query_shift2);
        if ($result_shift2) {
            $assigned_shift2 = mysqli_num_rows($result_shift2) > 0;
        } else {
            die(mysqli_error($conn));
        }

        echo '
        <tr>
        <th scope="row">'.$eid.'</th>
      
        <td>'.$employee_name.'</td>
        <td>'.$employee_type.'</td>
        <td>';

        if ($assigned_shift1 and $assigned_shift2) {
            echo '
                <button class="btn btn-danger" disabled>Shift 1</button>
                <small id="emailHelp" class="form-text text-muted">Conductor assigned</small>

                <button class="btn btn-danger" disabled>Shift 2</button>
                <small id="emailHelp" class="form-text text-muted">Conductor assigned</small>
            ';
        } else if (!$assigned_shift1 and !$assigned_shift2) {
            echo '
                <button type="submit" name="shift1" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 1 ?\');">
                    <a href="assignconductor_backend.php?date='.$formatted_date.'&busNo='.$displaybusNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=1&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 1</a>
                </button>
                <button type="submit" name="shift2"
                class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 2 ?\');">
                    <a href="assignconductor_backend.php?date='.$formatted_date.'&busNo='.$displaybusNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=2&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 2</a>
                </button>';

        }else if ($assigned_shift1 and !$assigned_shift2){
            echo '
                <button class="btn btn-danger" disabled>Shift 1</button>
                <small id="emailHelp" class="form-text text-muted">Conductor assigned</small>

                <button type="submit" name="shift2"
                class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 2 ?\');">
                    <a href="assignconductor_backend.php?date='.$formatted_date.'&busNo='.$displaybusNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=2&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 2</a>
                </button>
                ';
        }else if(!$assigned_shift1 and $assigned_shift2){
            echo '
            <button type="submit" name="shift1" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 1 ?\');">
                <a href="assignconductor_backend.php?date='.$formatted_date.'&busNo='.$displaybusNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=1&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 1</a>
            </button>
            <button class="btn btn-danger" disabled>Shift 2</button>
                <small id="emailHelp" class="form-text text-muted">Conductor assigned</small>
            ';

        }



        echo'</td>
        </tr>';
    }
}
}
      



    
?>
    <!--                ON CKICK ASIGN DRIVER              -->




 <?php
if(isset($_POST['driver'])){
    echo '
    <form method="post">
        <input type="hidden" name="date" value="'.$formatted_date.'">
        <input type="hidden" name="busNo" value="'.$busNo.'">
        <input type="hidden" name="rid" value="'.$rid.'">
        <input type="hidden" name="tripstart" value="'.$tripstart.'">
        <input type="hidden" name="tripend" value="'.$tripend.'">
        <table class="table my-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">eid</th>
                    <th scope="col">Driver Name</th>
                    <th scope="col">Driver Type</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>';
//changed
$sql = "SELECT * FROM driver_view ";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $eid = $row['eid'];
        $employee_name = $row['ename'];
        $employee_type = $row['etype'];
        $shift_no = 1;

        // Check if employee is present in assigned shift 1
        $query_shift1 = "SELECT * FROM assignedemp WHERE eid='$eid' and date='$formatted_date' and shiftno='$shift_no'";
        $result_shift1 = mysqli_query($conn, $query_shift1);
        if ($result_shift1) {
            $assigned_shift1 = mysqli_num_rows($result_shift1) > 0;
        } else {
            die(mysqli_error($conn));
        }

        // Check if employee is present in assigned shift 2
        $shift_no = 2;
        $query_shift2 = "SELECT * FROM assignedemp WHERE eid='$eid' and date='$formatted_date' and shiftno='$shift_no'";
        $result_shift2 = mysqli_query($conn, $query_shift2);
        if ($result_shift2) {
            $assigned_shift2 = mysqli_num_rows($result_shift2) > 0;
        } else {
            die(mysqli_error($conn));
        }

        echo '
        <tr>
        <th scope="row">'.$eid.'</th>
      
        <td>'.$employee_name.'</td>
        <td>'.$employee_type.'</td>
        <td>';

        if ($assigned_shift1 and $assigned_shift2) {
            echo '
                <button class="btn btn-danger" disabled>Shift 1</button>
                <small id="emailHelp" class="form-text text-muted">Driver assigned</small>

                <button class="btn btn-danger" disabled>Shift 2</button>
                <small id="emailHelp" class="form-text text-muted">Driver assigned</small>
            ';
        } else if (!$assigned_shift1 and !$assigned_shift2) {
            echo '
                <button type="submit" name="shift1" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 1 ?\');">
                    <a href="assigndriver_backend.php?date='.$formatted_date.'&busNo='.$busNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=1&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 1</a>
                </button>
                <button type="submit" name="shift2"
                class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 2 ?\');">
                    <a href="assigndriver_backend.php?date='.$formatted_date.'&busNo='.$busNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=2&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 2</a>
                </button>';

        }else if ($assigned_shift1 and !$assigned_shift2){
            echo '
                <button class="btn btn-danger" disabled>Shift 1</button>
                <small id="emailHelp" class="form-text text-muted">Driver assigned</small>

                <button type="submit" name="shift2"
                class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 2 ?\');">
                    <a href="assigndriver_backend.php?date='.$formatted_date.'&busNo='.$busNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=2&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 2</a>
                </button>
                ';
        }else if(!$assigned_shift1 and $assigned_shift2){
            echo '
            <button type="submit" name="shift1" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to assign shift 1 ?\');">
                <a href="assigndriver_backend.php?date='.$formatted_date.'&busNo='.$busNo.'&rid='.$rid.'&eid='.$eid.'&ename='.$employee_name.'&etype='.$employee_type.'&shiftno=1&tripstart='.$tripstart.'&tripend='.$tripend.'">Shift 1</a>
            </button>
            <button class="btn btn-danger" disabled>Shift 2</button>
                <small id="emailHelp" class="form-text text-muted">Driver assigned</small>
            ';

        }



        echo'</td>
        </tr>';
    }
}
}
      



    
?>

    


    </tbody>      
    </table>
    </div>
    </form>
  <!-- form end   -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>