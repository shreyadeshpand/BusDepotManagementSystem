<?php
include 'busconnect.php';
session_start();
$username = "";
$eid = "";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$sql = "SELECT * FROM conductor_login WHERE username='$username'";
if ($result = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_assoc($result);
    $eid = $row['eid'];
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todays Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
        <style>
        table tr:not(:first-child){
            cursor: pointer;transition: all .25s ease-in-out;
        }
        table tr:not(:first-child):hover{background-color: #ddd;}
        
body {
font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
margin: 0;
padding: 0;
background-color: #f2f2f2;
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

form {
background-color: #ffffff;
padding: 20px;
margin: 20px auto;
max-width: 800px;
border-radius: 10px;
box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

label {
display: block;
margin-bottom: 8px;
font-weight: bold;
}

.form-group {
margin-bottom: 15px;
}

table {
width: 100%;
margin-top: 20px;
border-collapse: collapse;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
overflow: hidden;
border-radius: 5px;
margin-bottom: 20px;
}

th, td {
border: 1px solid #ddd;
padding: 12px;
text-align: left;
background-color: #fff;
}

th {
background-color: #007bff;
color: #fff;
}

tr:hover {
background-color: #e9ecef;
}

.searchBox {
position: relative;
margin-bottom: 20px;
}

.searchTextBox {
width: 100%;
padding: 10px;
border: 1px solid #ddd;
border-radius: 5px;
}

.alert {
margin-top: 20px;
}

.btn-primary {
background-color: #007bff;
border-color: #007bff;
color: #ffffff;
transition: background-color 0.3s;
}

.btn-danger {
background-color: #dc3545;
border-color: #dc3545;
color: #ffffff;
transition: background-color 0.3s;
}


    </style>


<title>Todays Schedule</title>
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
            <li class="nav-item">
                <a class="nav-link" href="welcome_conductor1.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<body>
<h1 class="mt-4">Schedule</h1>

    <div class="container mt-5">
       
<form method="post">
       
<h2 class="mt-4">Today's Schedule</h2>
        <table id="table" class="table my-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">BusNo</th>
                    <th scope="col">Route No</th>
                    <th scope="col">Shift No</th>
                    <th scope="col">Shift Start</th>
                    <th scope="col">Shift End</th>
                </tr>
            </thead>
            <tbody>
                <?php

$sql = "SELECT * FROM completeschedule WHERE eid = '$eid' AND date = curdate()";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $busNo = $row['busNo'];
        $rid = $row['rid'];
        $shiftno = $row['shiftno'];
        $shiftstart = $row['shiftstart'];
        $shiftend = $row['shiftend'];

        echo '<tr>
                <td>' . $busNo . '</td>
                <td>' . $rid . '</td>
                <td>' . $shiftno . '</td>
                <td>' . $shiftstart . '</td>
                <td>' . $shiftend . '</td>
            </tr>';
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
</tbody>
        </table>
       
    </div>
    </form>
    
    <form method="POST" onsubmit="return validateForm();">
    <h3 class="mt-2">View Datewise Schedule</h3>
    <div class="form-group">
        <label for="startDate">Start Date:</label>
        <input type="date" class="form-control" id="startDate" name="startDate" required>
    </div>
    <div class="form-group">
        <label for="endDate">End Date:</label>
        <input type="date" class="form-control" id="endDate" name="endDate" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">View Schedule</button>
    
    <div class="form-group">
        <label >Search</label>
        <div class="searchBox ">
            <input type="text" class="searchTextBox" id="searchTextBoxid" placeholder="Search rid,eid,busNo..." onkeyup="search()" placeholder="Search..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search...'"/>
            <label id="NotExist" style="display:none"></label>
        <div class="results-container">
            
       <?php
       
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $startDate = $_POST['startDate'];
                    $endDate = $_POST['endDate'];

                    if (empty(trim($startDate)) || empty(trim($endDate))) {
                        // Display an alert message if start or end date is empty
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>ALERT!</strong> Fields cannot be empty.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>';
                    } else {
            $scheduleQuery = "SELECT *
                              FROM completeschedule
                              WHERE date BETWEEN '$startDate' AND '$endDate'
                              and eid='$eid'";

            $scheduleResult = $conn->query($scheduleQuery);
            echo "<h2>Schedule Results for " . $startDate . " to " . $endDate . "</h2>";
            echo "<table id='scheduleTable' class='table'>
            <thead>
              <tr>
                <th>Route ID</th>
                <th>Associated Bus Numbers</th>
                <th>Employee IDs</th>
                <th>Shift Numbers</th>
                <th>Shift Starts</th>
                <th>Shift Ends</th>
              </tr>
            </thead>";
            if ($scheduleResult->num_rows > 0) {
               
                
               

                while ($row = $scheduleResult->fetch_assoc()) {

                    echo "<tbody>
                    <tr>
                              <td>".$row['rid']."</td>
                              <td>".$row['busNo']."</td>
                              <td>".$row['eid']."</td>
                              <td>".$row['shiftno']."</td>
                              <td>".$row['shiftstart']."</td>
                              <td>".$row['shiftend']."</td>
                            </tr>";
                }
                
            
                echo "</tbody></table>";
            } else {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>SORRY!</strong> No schedule details found for the selected date range.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
            }
        }
    }

   
    ?>
        </div>

    </form>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    function validateForm() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return false;
        }

        return true;
    }
    document.addEventListener("DOMContentLoaded", function () {
        var table = document.getElementById("scheduleTable");

        for (var i = 1; i < table.rows.length; i++) {
            table.rows[i].onclick = function () {
                // Ensure these input elements exist in your HTML form
                document.getElementById("rid").value = this.cells[0].innerHTML;
                document.getElementById("busNo").value = this.cells[1].innerHTML;
                document.getElementById("eid").value = this.cells[2].innerHTML;
                document.getElementById("shiftno").value = this.cells[3].innerHTML;
                document.getElementById("shiftstart").value = this.cells[4].innerHTML;
                document.getElementById("shiftend").value = this.cells[5].innerHTML;
            };
        }
    });
    function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("searchTextBoxid");
    filter = input.value.toUpperCase();
    table = document.getElementById("scheduleTable");
    tr = table.getElementsByTagName("tr");
    var countvisible = 0;

    for (i = 1; i < tr.length; i++) {
        var visible = false;

        for (var j = 0; j <= 2; j++) {  // Check columns with indices 0, 1, and 2
            td = tr[i].getElementsByTagName("td")[j];

            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                    break;  // Break if a match is found in any of the specified columns
                }
            }
        }

        if (visible) {
            countvisible++;
            tr[i].style.display = "";
            document.getElementById("NotExist").style.display = "none";
        } else {
            tr[i].style.display = "none";
            document.getElementById("NotExist").style.display = "none";
        }
    }

    if (countvisible === 0) {
        document.getElementById("NotExist").style.display = "block";
        document.getElementById("NotExist").innerHTML = "Does not exist!";
    }
}

</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>
