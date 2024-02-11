<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

</head>
<body>

<div class="container">

<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">welcome</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="emp_data_display.php">View Employee<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="emp_log.php?eid='.$eid.'">Check Employee Schedule <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="logout.php">Logout<span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>
  <!-- navend -->
  <h2>Schedule Form</h2>
  <form method="POST">

  
    <div class="form-group">
      <label for="startDate">Start Date:</label>
      <input type="date" class="form-control" id="startDate" name="startDate" required>
    </div>
    <div class="form-group">
      <label for="endDate">End Date:</label>
      <input type="date" class="form-control" id="endDate" name="endDate" required>
    </div>
    <div class="form-group">
      <label for="eid">Employee ID:</label>
      <input type="text" class="form-control" id="eid" name="eid" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>

  <?php
include 'busconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $eid = $_POST['eid'];

    if (empty(trim($startDate)) || empty(trim($endDate)) || empty(trim($eid))) {
        $err = "Fields cannot be blank";
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>ALERT!</strong> Field cannot be empty.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        $query = "SELECT COUNT(*) AS numShifts, SUM(TIME_TO_SEC(TIMEDIFF(shiftend, shiftstart))) / 3600 AS totalHours
                    FROM completeschedule
                    WHERE date BETWEEN '$startDate' AND '$endDate' AND eid = '$eid'";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $numShifts = $row['numShifts'];
            $totalHours = $row['totalHours'];

            // Calculate total days worked
            $totalDaysWorkedQuery = "SELECT COUNT(DISTINCT date) AS totalDays
                                    FROM completeschedule
                                    WHERE date BETWEEN '$startDate' AND '$endDate' AND eid = '$eid'";
            $totalDaysWorkedResult = $conn->query($totalDaysWorkedQuery);
            $totalDaysWorkedRow = $totalDaysWorkedResult->fetch_assoc();
            $totalDaysWorked = $totalDaysWorkedRow['totalDays'];

            // Calculate total number of days in the range
            $totalDaysRange = round(abs(strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24)) + 1;

            // Calculate number of days not worked
            $daysNotWorked = $totalDaysRange - $totalDaysWorked;

            echo "<h2>Schedule Results</h2>";
            echo "<p>Number of Shifts: " . $numShifts . "</p>";
            echo "<p>Total Hours Worked: " . $totalHours . "</p>";
            echo "<p>Total Days Worked: " . $totalDaysWorked . "</p>";
            echo "<p>Number of Days Not Worked: " . $daysNotWorked . "</p>";
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>WARNING!</strong> No data found.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
        }

        // Display assignedemp table details
        $assignedEmpQuery = "SELECT *
                            FROM assignedemp
                            WHERE eid = '$eid' and date>='$startDate' and date<='$endDate'";
        $assignedEmpResult = $conn->query($assignedEmpQuery);

        if ($assignedEmpResult->num_rows > 0) {
            echo "<h2>Assigned Employee Details</h2>";
            echo "<table class='table'>
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Employee ID</th>
                          <th>Job</th>
                          <th>Bus Number</th>
                          <th>Shift Number</th>
                        </tr>
                      </thead>
                      <tbody>";

            while ($row = $assignedEmpResult->fetch_assoc()) {
                echo "<tr>
                          <td>".$row['date']."</td>
                          <td>".$row['eid']."</td>
                          <td>".$row['ejob']."</td>
                          <td>".$row['busNo']."</td>
                          <td>".$row['shiftno']."</td>
                        </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>SORRY!</strong> No work details found for given date.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
        }
    }
}
?>


</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>