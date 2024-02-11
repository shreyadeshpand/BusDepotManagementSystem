<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <style>
        h1 {
            text-align: center;
        }

        /* Custom styles for the entire page */

        /* Global styles for the entire page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        h1 {
            text-align: center;
        }

        /* Marquee styles */
        marquee {
            background-color: #fff;
            color: #007bff;
            padding: 10px;
            font-size: 18px;
        }

       img.bus-image {
            display: block;
            margin: 20px auto; /* Center the image */
            max-width: 50%; /* Reduce image size */
        }

        .btn-container {
             width: 300px; /* Adjust button width */
            text-align: center;
            margin-bottom: 20px; /* Add space below buttons */
            margin-left: auto;
            margin-right: auto;
        }
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('mainbg.jpg'); /* Replace 'background.jpg' with the actual path to your image */
    background-size: cover; /* This ensures the background image covers the entire viewport */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    background-attachment: fixed; /* Keeps the background fixed while scrolling */
    background-position: center; /* Center the background image */
}

       
    </style>

    <title>Hello, world!</title>
</head>
<body>

<h1>WELCOME TO CONTROLLERS PORTAL</h1>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">welcome</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>

        </ul>
    </div>
</nav>

<?php
session_start();

// Include the database connection file
include 'busconnect.php';
$sql = "SELECT * FROM failure WHERE date = curdate() ";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $busNo = $row['busNo'];
        $date = $row['date'];
        $time = $row['time'];
        $location = $row['location'];

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
                $stopname = $row['stopname'];
            }
        }

        $newbusNo = '';

        $sql = "SELECT * FROM reassignedbus WHERE DATE(timestamp) = CURDATE() and oldBus='$busNo'";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $row = mysqli_fetch_assoc($result);
            $newbusNo = $row['busNo'];

        }

        echo '<marquee behavior="scroll" direction="left">
      FAILURE OCCURRED: Bus No: ' . $busNo . '  Location: ' . $stopname . ' Reassigned Bus No : ' . $newbusNo . '
      </marquee>';

    }
}
?>

<?php
echo '<marquee behavior="scroll" direction="left">
TODAY\'S SCHEDULE';
$sql = "SELECT busNo, rid, COUNT(*) AS scheduleCount FROM schedule WHERE date = CURDATE() group BY busNo, rid";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Display the information as a marquee

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $busNo = $row['busNo'];
            $rid = $row['rid'];
            $scheduleCount = $row['scheduleCount'];

            echo " Bus No: $busNo - Route No: $rid | ";
        }

    } else {
        echo " No Schedule Allotted For Today!! ";
    }
} else {
    // If the query failed, handle the error
    echo "Error: " . mysqli_error($conn);
}

echo '</marquee>';
?>
 <div class="text-left">
        <img src="bus.png" alt="Bus Image" class="bus-image">
    </div>

    <div class="btn-container">
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/busdata1.php">ADD BUS</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/empdata.php">ADD EMPLOYEE</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/bus_schedule_data.php">CREATE SCHEDULE</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/newroute.php">CREATE ROUTE</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/bus_schedule_data.php">CREATE BUS SCHEDULE</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/failure.php">CREATE FAILURE</a>
    <a class="btn btn-secondary btn-block btn-links" href="/tp1/emp_log.php">EMPLOYEE LOG</a>
</div>
<div class="text-center">
    <marquee behavior="scroll" direction="left">
        <p style="color: #ff5733;">Managing Depots, Enhancing Services.</p>
    </marquee>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
