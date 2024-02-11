

<?php
include 'busconnect.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>bus_data_display</title>
  </head>
  <body>
 
    <div class="container mt-5">
    <h1>Bus Data</h1>
    <button type="button" class="btn btn-primary my-5">
    <a href= "busdata1.php  "  class ="text-light">Add Bus</a >    
</button>
<table class="table">
  <thead class="thead-dark">
    <tr>
    <th scope="col">Bus Depot</th>
      <th scope="col">Bus Number</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Chasis Number</th>
      <th scope="col">Bus Type</th>
    </tr>
  </thead>
  <tbody>

  <?php
    $sql = "SELECT * FROM busdata where deleted=0";
    $result=mysqli_query($conn,$sql);
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $bdepot=$row['bdepot'];
            $busNo=$row['busNo'];
            $vehicleNo=$row['vehicleNo'];
            $chasis=$row['chasis'];
            $bType=$row['bType'];
            echo '<tr>
            <th scope="row">'.$bdepot.'</th>
            <th scope="row">'.$busNo.'</th>
          
            <td>'.$vehicleNo.'</td>
            <td>'.$chasis.'</td>
            <td>'.$bType.'</td>
          </tr>';
        }
    }
    
  ?>
  
  </tbody>
</table>


    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>