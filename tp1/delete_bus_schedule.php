<?php
include 'busconnect.php';
// Get the date, busNo, and rid values from the URL
if(isset($_GET['busNo']) and isset($_GET['date']) and isset($_GET['rid'])){
$date = $_GET['date'];
$formatted_date = date("Y-m-d", strtotime($date));
$busNo = $_GET['busNo'];
$rid = $_GET['rid'];
echo $date;
echo $busNo;
echo $rid;
echo $formatted_date;

// Create a query to delete the data from the schedule table
$sql = "DELETE FROM schedule WHERE date='$formatted_date' AND busNo='$busNo' AND rid='$rid'";

// Execute the query
if(mysqli_query($conn, $sql)){
    echo "Record deleted successfully";
   header("location: bus_schedule_data.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
   
}

// Close the database connection
mysqli_close($conn);
}
?>