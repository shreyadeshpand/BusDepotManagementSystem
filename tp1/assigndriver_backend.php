<?php
include 'busconnect.php';
$ejob='';
if(isset($_GET['date'], $_GET['busNo'], $_GET['rid'], $_GET['eid'], $_GET['ename'], $_GET['etype'], $_GET['shiftno'], $_GET['tripstart'], $_GET['tripend'])) {
    
    // Sanitize and validate input
    $date = mysqli_real_escape_string($conn, $_GET['date']);
    $formatted_date = date("Y-m-d", strtotime($date));
    $busNo = mysqli_real_escape_string($conn, $_GET['busNo']);
    $rid = mysqli_real_escape_string($conn, $_GET['rid']);
    $eid = mysqli_real_escape_string($conn, $_GET['eid']);
    $ename = mysqli_real_escape_string($conn, $_GET['ename']);
    $etype = mysqli_real_escape_string($conn, $_GET['etype']);
    $shiftno = mysqli_real_escape_string($conn, $_GET['shiftno']);
    $tripstart = mysqli_real_escape_string($conn, $_GET['tripstart']);
    $tripend = mysqli_real_escape_string($conn, $_GET['tripend']);
    // Get employee job
    echo $eid;
    $query = "SELECT ejob FROM emp WHERE eid='$eid'";
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die(mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
        $ejob = $row['ejob'];
        echo $ejob;
    }
    
    // Insert data into assignedemp table
    $sql = "INSERT INTO assignedemp(date, eid, ejob, busNo, shiftNo) VALUES ('$formatted_date', '$eid', $ejob, '$busNo', $shiftno)";
    $res = mysqli_query($conn, $sql);
    if($res) {
        echo 'Data added to assignedemp table successfully';
       header("location: assign_employee.php?" . http_build_query(array(
            'eid' => $eid,
            'ename' => $ename,
            'busNo' => $busNo,
            'date' => $formatted_date,
            'rid' => $rid,
            'etype' => $etype,
            'ename' => $ename,
            'shiftno' => $shiftno,
            'tripstart' => $tripstart,
            'tripend' => $tripend,
            'success' => 'Employee assigned to Shift 1 successfully'
        )));

     
    } else {
        if(mysqli_errno($conn) == 1062) {
            // Unique or primary key constraint violated
            $error_row = mysqli_error($conn);
            //getting eid from error row
            preg_match('/\'eid\'=\'.*?\'/', $error_row, $matches);
            $eid = str_replace('\'', '', explode('=', $matches[0])[1]);
    
        


           
            header("location: assign_employee.php?" . http_build_query(array(
                'eid' => $eid,
            'ename' => $ename,
            'busNo' => $busNo,
            'date' => $formatted_date,
            'rid' => $rid,
            'etype' => $etype,
            'ename' => $ename,
            'shiftno' => $shiftno,
            'tripstart' => $tripstart,
            'tripend' => $tripend,
                'error_row' => $error_row,
                'alreadyexists' => 'Employee already assigned'
            )));
        } else {
            die(mysqli_error($conn));
        } 
    }
}
?> 