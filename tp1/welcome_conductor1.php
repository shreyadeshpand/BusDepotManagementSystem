<?php
include 'busconnect.php';
session_start();
$eid = "";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetching the employee ID (eid) based on the logged-in username
    $sql = "SELECT eid FROM conductor_login WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $eid = $row['eid'];
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            background-image: url('mainbg.jpg');
            background-size: 100%;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #007bff;
        }

        nav {
            background-color: #f8f9fa;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #007bff;
        }

        marquee {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            font-size: 18px;
            margin-top: 20px;
            height: 5%;
        }

        img.bus-image {
            display: block;
            margin: 20px auto;
            max-width: 50%;
            border-radius: 10px;
        }

        .btn-container {
            width: 300px;
            text-align: center;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            transition: background-color 0.3s;
        }

        .btn-links {
            margin-bottom: 10px;
        }

        .btn-container:hover .btn-primary {
            background-color: rgba(0, 123, 255, 0.8);
        }

        footer {
            margin-top: 30px;
            padding: 5px;
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            border-radius: 5px;
        }
    </style>

    <title>Welcome Conductor to the Portal</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Welcome</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <h1>Welcome to the Conductor Portal</h1>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
    <!-- Button Container -->
    <div class="btn-container">
        <?php
        // Check if the conductor has a schedule
        $scheduleCheckQuery = "SELECT * FROM completeschedule WHERE date = CURDATE() AND eid = '$eid'";
        $scheduleCheckResult = mysqli_query($conn, $scheduleCheckQuery);

        // Disable buttons for conductors without a schedule
        

        // Check if conductor has a schedule
        if (mysqli_num_rows($scheduleCheckResult) == 0) {
            // No schedule, so do not display the buttons
            echo '<p>No schedule available today.</p>';
            echo'
            <button id="ticketDataBtn" class="btn btn-primary btn-block btn-links" disabled> 
            
                VIEW SCHEDULE
              
           
            </button>
            <button id="ticketDataBtn" class="btn btn-primary btn-block btn-links" disabled>
            
                TICKET DATA
           
            </button>
            <button id="reportFailureBtn" class="btn btn-primary btn-block btn-links" disabled> 
           
                REPORT FAILURE
            
            </button>';

            
        } else {
            // Schedule exists, display the buttons
            echo'
            <a id="ticketDataBtn" class="btn btn-primary btn-block btn-links" href="/tp1/view_schedule.php">
                VIEW SCHEDULE
              
            </a>
            
            <a id="ticketDataBtn" class="btn btn-primary btn-block btn-links" href="/tp1/welcome_conductor.php">
                TICKET DATA
            </a>
           
            <a id="reportFailureBtn" class="btn btn-primary btn-block btn-links" href="/tp1/failure.php">
                REPORT FAILURE
            </a>
            ';
        
        }
        ?>
    
    </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<br>
<br>
    <!-- Footer -->
    <footer>
        <p>@ Managing Depots, Enhancing Services.</p>
    </footer>

    <!-- Bootstrap JS and other scripts -->
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
