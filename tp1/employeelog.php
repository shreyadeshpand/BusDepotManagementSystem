<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    

<div class="container">
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

              echo "<h2>Schedule Results</h2>";
              echo "<p>Number of Shifts: " . $numShifts . "</p>";
              echo "<p>Total Hours Worked: " . $totalHours . "</p>";
          } else {
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>WARNING!</strong> No data found.
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>