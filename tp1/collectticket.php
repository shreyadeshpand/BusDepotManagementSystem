
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
   
    <div class="container my-4">
        <!-- nav -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">welcome</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome_conductor.php?eid='.$eid.'">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="logoutconductor.php">Logout<span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>
  <!-- navend -->
    <h1>Tickets And Amount</h1>
    <form method ="post">
  <div class="form-group">

<?php
include 'busconnect.php';
$date=$_GET['date'];
$busNo=$_GET['busNo'];
$rid=$_GET['rid'];
$shiftstart=$_GET['shiftstart'];
$shiftend=$_GET['shiftend'];
$i = 0;

echo '
<div class="container mt-4">
<h4>Select Trip</h4>
<input type="radio" name="trip" value="1">1
<input type="radio" name="trip" value="2">2
</div>

<div class="container mt-4">
<h4>Select Stop</h4>
</div>';
$sql = "SELECT stopname FROM stops WHERE rid = '$rid'";
$result = mysqli_query($conn, $sql);
// gives stopname
while ($row3 = mysqli_fetch_assoc($result)) {
    $stopname = $row3['stopname'];
    $sql2 = "SELECT stopno FROM katrajfare WHERE stopname like '%$stopname%'";
    $result2 = mysqli_query($conn, $sql2);
    
    if ($result2 && mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);
        $stopno = $row2['stopno'];
        echo $stopno;
    } else {
        // Handle the case when no row is found
        $stopno = "";
    }
    ?>
    <input type="radio" id="<?php echo $stopno; ?>" name="stops" value="<?php echo $stopno; ?>">
    <?php echo $row3["stopname"]; ?><br>
    <?php
    $i++;
}
 echo ' <div class="container mt-4">
 <h4>Select Number Of People</h4>
 </div>

<input type="radio" name="people" value="1">1
<input type="radio" name="people" value="2">2
<input type="radio" name="people" value="3">3
<input type="radio" name="people" value="4">4
<input type="radio" name="people" value="5">5

<div class="container mt-4">
<button type="submit" name = "radiosubmit" id="radiosubmit" class="btn btn-primary">Submit</button>
</div>
';
if (isset($_POST['radiosubmit'])) {
    // Retrieve the selected values
    $stopno = $_POST['stops'];
    $newstopno = $_POST['stops'];
    $selectedPeople = $_POST['people'];
    $newselectedPeople = $_POST['people'];
    $trip=$_POST['trip'];

    // Use the values as needed
    echo "Selected Stop: " . $stopno . "<br>";
    echo "Selected People: " . $selectedPeople . "<br>";
    echo "Selected Trip: ".$trip. "<br>";


// Print the parameter values
echo " Date: " . $date . "<br>";
echo " BusNo: " . $busNo . "<br>";
    // Prepare the SQL statement
    $sql = "CALL calculate (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    // Bind parameters and execute the stored procedure
    $stmt->bind_param("ssiii", $date, $busNo, $stopno, $selectedPeople,$trip);
    if (!$stmt->execute()) {
        die("Error in executing statement: " . $stmt->error);
    }
else{
 // Stored procedure execution completed successfully
 echo "Stored procedure execution completed successfully.";
}
}  
?>
</form>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>