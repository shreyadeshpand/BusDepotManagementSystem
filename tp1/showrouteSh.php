<?php
include 'busconnect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get route data
$sql = "SELECT * FROM routes";
$result = mysqli_query($conn, $sql );

// loop through routes and create form for each
if($result){
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>Route " . $row["rid"] . "</h2>";
        echo "<table>";
        echo "<tr><th>Shift No.</th><th>Shift Start</th><th>Shift End</th><th></th></tr>";
        // create form for shift 1
        echo "<form method='post'>";
        echo "<input type='hidden' name='rid' value='" . $row["rid"] . "'>";
        echo "<input type='hidden' name='shiftn' value='1'>";
        echo "<tr><td>1</td><td><input type='time' name='shiftstart1' required></td><td><input type='time' name='shiftend1' required></td><td><button type='submit' name='submit1'>Submit</button></td></tr>";
        echo "</form>";
        // create form for shift 2
        echo "<form method='post'>";
        echo "<input type='hidden' name='rid' value='" . $row["rid"] . "'>";
        echo "<input type='hidden' name='shiftn' value='2'>";
        echo "<tr><td>2</td><td><input type='time' name='shiftstart2' required></td><td><input type='time' name='shiftend2' required></td><td><button type='submit' name='submit2'>Submit</button></td></tr>";
        echo "</form>";
        echo "</table>";
        // handle form submissions
        if (isset($_POST['submit1']) || isset($_POST['submit2'])) {
            $rid = $_POST['rid'];
            $shiftn = $_POST['shiftn'];
            $shiftstart = $_POST['shiftstart' . $shiftn];
            $shiftend = $_POST['shiftend' . $shiftn];
            // insert data into database
            $sql = "INSERT INTO shifts (rid, shiftn, shiftstart, shiftend) VALUES ('$rid', '$shiftn', '$shiftstart', '$shiftend')";
            if ($conn->query($sql) === TRUE) {
                echo "Shift data inserted successfully";
            } else {
                echo "Error inserting shift data: " . $conn->error;
            }
        }
    }
} else {
    echo "No routes found";
}
// close database connection
$conn->close();
}
?>