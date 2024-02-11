<?php
include 'busconnect.php';
?>
<?php
$row1="";
$rid=$_GET['updaterid'];

   
    //stooring stops in a array
    $stops = array();
    $query = "SELECT stopname FROM stops WHERE rid = '$rid'"; 
     //selects all the previous stops
$result1 = mysqli_query($conn, $query);

while ($row1 = mysqli_fetch_array($result1)) {
  $stops[] = $row1['stopname'];
 //array of previous stops
}
$stops_string = implode(', ', $stops);





//for route data
$sql = "SELECT * FROM routedata where rid='$rid'";
$result=mysqli_query($conn,$sql);
if($result ){
    $row=mysqli_fetch_assoc($result);
   
         
           
            $source=$row['source'];
            $destination=$row['destination'];
           $tripstart=$row['destination'];
           $starttime=$row['destination'];
           
}
else{
    die(mysqli_error($conn));
}
        
    
 //on submit
if(isset($_POST['submit'])){
   
    $source=trim($_POST['source']);
    $destination=trim($_POST['destination']);
    $tripstart=trim($_POST['tripstart']);
    $tripend=trim($_POST['tripend']);

    //to update source destination
    $sql= "UPDATE routedata set rid='$rid',source='$source',destination='$destination',tripstart='$tripstart',tripend='$tripend'  where rid='$rid' ";
    $result = mysqli_query($conn,$sql);
    $stops_string = $_POST['stops'];


    //to update stops
    $new_stops = $_POST['stops'];

// Retrieve the current list of stops for the given rid
$query = "SELECT stopname FROM stops WHERE rid = '$rid'";
$result = mysqli_query($conn, $query);
$current_stops = array();
while ($row = mysqli_fetch_array($result)) {
  $current_stops[] = $row['stopname'];
}

// Split the new stops into an array
//$new_stops_arr = explode(',', $new_stops);
$new_stops_arr = $new_stops;
// Find the stops that are unchanged, new or deleted
$deleted_stops = array_diff($current_stops, $new_stops_arr);
$new_added_stops = array_diff($new_stops_arr, $current_stops);
$final_stops = array_merge($current_stops, $new_added_stops);

// Use SQL DELETE statements to remove the stops that are not in the new list
foreach ($deleted_stops as $stop) {
  $query = "DELETE FROM stops WHERE rid = '$rid' AND stopname = '$stop'";
  mysqli_query($conn, $query);
}

// Use SQL INSERT statements to add the stops that are not in the current list
foreach ($new_added_stops as $stop) {
  $query = "INSERT INTO stops (rid, stopname) VALUES ('$rid', '$stop')";
  mysqli_query($conn, $query);
}

// Use SQL UPDATE statements to update the stops that have not been deleted or added
foreach ($final_stops as $stop) {
  $query = "UPDATE stops SET stopname = '$stop' WHERE rid = '$rid' AND stopname = '$stop'";
  mysqli_query($conn, $query);
}
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>SUCCESS!</strong> Data updated successfully.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>



</div>';
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

    <title>Create Route</title>
  </head>
  <body>
   
    <div class="container mt-4" >
    <h1>Enter Route Data</h1>
    <form method ="post">
  <div class="form-group">
    <?php
if(isset($_GET['updaterid'])){
    $rid=$_GET['updaterid'];
}
    ?>
    <label for="exampleInputEmail1">Route ID</label>
    <input type="text" name="rid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Route ID" value=<?php  echo $rid ?> disabled>

  </div>
  <div class="form-group">
  <label for="source">Source:</label>
  <select class="form-control" name="source" id="source">
    <option value="katraj">Katraj</option>
    <option value="kothrud">Kothrud</option>
  </select>
</div>
<div class="form-group">
  <label for="destination">Destination:</label>
  <select class="form-control" name="destination" id="destination">
    <option value="kothrud">Kothrud</option>
    <option value="katraj">Katraj</option>
  </select>
</div>


<div class="form-group">
  <label for="stops">Stops:</label>
  <div id="stopList"></div>
</div>

<script>
  const stops = {
  katraj: {
    kothrud: [
      "Bharati Vidyapeeth Gate (Brts)",
      "Padmavati (Brts)",
      "Bhapkar Petrol Pump (Brts)",
      "Swargate",
      "S.P.College",
      "Deccan Corner (To Paud Road)",
      "Garware College",
      "Anandnagar Kothrud",
      "Vanaz Corner",
      "Kothrud Depot"
    ],
    // Add stops for katraj to upper direction if needed
  },
  kothrud: {
    katraj: [
      "Kothrud Depot",
      "Vanaz Corner",
      "Anandnagar Kothrud",
      "Garware College",
      "Deccan Corner (To Paud Road)",
      "S.P.College",
      "Swargate",
      "Bhapkar Petrol Pump (Brts)",
      "Padmavati (Brts)",
      "Bharati Vidyapeeth Gate (Brts)"
    ],
    // Add stops for kothrud to upper direction if needed
  }
};

const source = document.getElementById("source");
const destination = document.getElementById("destination");
const stopList = document.getElementById("stopList");

function updateStops() {
  stopList.innerHTML = "";
  const direction = source.value < destination.value ? "forward" : "reverse";
  stops[source.value][destination.value].forEach(stop => {
    const div = document.createElement("div");
    div.className = "form-check";
    const input = document.createElement("input");
    input.type = "checkbox";
    input.className = "form-check-input";
    input.name = "stops[]";
    input.value = stop;
    const label = document.createElement("label");
    label.className = "form-check-label";
    label.textContent = stop;
    div.appendChild(input);
    div.appendChild(label);
    if ((direction === "forward" && stop !== "Kothrud Depot") || (direction === "reverse" && stop !== "Bharati Vidyapeeth Gate (Brts)")) {
      stopList.appendChild(div);
    }
  });
}

source.addEventListener("change", updateStops);
destination.addEventListener("change", updateStops);
updateStops();
</script>


  <div class="form-group">
  <label for="stops">Trip Start:</label>
				<input type="time" class="form-control" name="tripstart" id="tripstart" placeholder="Enter trip start timing:">
  </div>
  <div class="form-group">
  <label for="tripend">Trip end:</label>
				<input type="time" class="form-control" name="tripend" id="tripend" placeholder="Enter trip end timing:">
  </div>
  <button type="submit" name = "submit" class="btn btn-primary">Submit</button>
  <button type="button" class="btn btn-primary ">
    <a href= "showroute.php  "  class ="text-light">View Route Data</a >    
</button>
</form>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 </body>
</html>