

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Forgot Password</title>
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            width: 400px;
        }

        h3 {
            color: #343a40;
            text-align: center;
        }

        .form-group label {
            color: #343a40;
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h3>Forgot Password</h3>
    <hr>

    <form method="post">
    <div class="alert" id="alert">
    <!-- Alert content will be dynamically inserted here using JavaScript -->
</div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" oninput="validate_user()">
        </div>
        <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Enter New Password"  oninput="validate_pass()">
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password" oninput="validate_new_pass()">
        </div>
        <p class="validate" id="validate"></p>
        <button type="submit" name="submit" id="submit" class="btn btn-primary mt-5">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    
function setError(err) {
    var alertDiv = document.getElementById('alert');
    if (alertDiv) {
        alertDiv.className = "alert alert-danger mt-3 alert-dismissible fade show";
        alertDiv.innerHTML =
            '<strong>' + err + '</strong>' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>';
    }
}

   
function setSuccess(err) {
    var alertDiv = document.getElementById('alert');
    if (alertDiv) {
        alertDiv.className = "alert alert-success mt-3 alert-dismissible fade show";
        alertDiv.innerHTML =
            '<strong>' + err + '</strong>' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>';
    }
}

    function validate_user() {
        var user = document.getElementById('username').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 3 || user.length > 6) {
            validateMessage.innerHTML = "Length of username must be between 3 and 6";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }

    function validate_pass() {
        var user = document.getElementById('newPassword').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 8 || user.length > 40) {
            validateMessage.innerHTML = "Length of password must be between 8 and 40";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }

    function validate_new_pass() {
        var user = document.getElementById('confirmPassword').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 8 || user.length > 40) {
            validateMessage.innerHTML = "Length of password must be between 8 and 40";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }


    </script>
</body>
</html>
<?php
// Assuming $conn is your database connection

require_once "config.php";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['confirmPassword']; // Change to confirmPassword
    
    // Query to check if the given username exists in the conductor_login table
    $searchSql = "SELECT * FROM logins WHERE username=?";
    $stmt = $conn->prepare($searchSql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $searchResult = $stmt->get_result();

    if (mysqli_num_rows($searchResult) === 0) {
        $err = "Invalid Username. No record with the associated username found";
        echo '<script>setError("' . $err . '");</script>';
    } else if (mysqli_num_rows($searchResult) === 1) {
        // Check if the submitted password matches the confirmation password
        if ($_POST['newPassword'] === $_POST['confirmPassword']) {
            // Update query with prepared statement
            $updateSql = "UPDATE logins SET password=? WHERE username=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $password, $username);
            $updateStmt->execute();

            if ($updateStmt) {
                $err = "Password updated successfully";
                echo '<script>setSuccess("' . $err . '");</script>';
            } else {
                $err = "Error while updating the password";
                echo '<script>setError("' . $err . '");</script>';
            }
        }    else {
            $err = "Password and Confirm Password do not match";
            echo '<script>setError("' . $err . '");</script>';
        }
    } else {
        $err = "Error in records";
        echo '<script>setError("' . $err . '");</script>';
    }

    
}
?>