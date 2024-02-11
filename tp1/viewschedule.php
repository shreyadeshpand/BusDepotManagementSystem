
<?php
    include 'busconnect.php';
    $startDate="";
    $endDate="";
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
      background-image: url('subtle-pattern.png');
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

    .navbar-brand, .navbar-nav .nav-link {
      color: #007bff;
    }

    form {
      background-color: #ffffff;
      padding: 20px;
      margin: 20px auto;
      max-width: 1000px;
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

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      color: #ffffff;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: rgba(0, 123, 255, 0.8);
    }

    .results-container {
      margin-top: 20px;
    }

    /* Table styles */
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: #ffffff;
    }
  </style>
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
                <a class="nav-link" href="welcome.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<h1>View Schedule Datewise</h1>

<form method="POST" onsubmit="return validateForm();">
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
                              ";

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

</body>
</html>
