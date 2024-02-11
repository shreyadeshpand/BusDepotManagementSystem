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

    <title>search emp</title>
  </head>
  <body>
    <div class="container my-5" >
        <form action="" method ="POST" >
        <input type="text" name = "search" placeholder="Enter employee information" >
        <button type="submit" name = "submit" class="btn btn-primary btn-sm">Search</button>
        </form>
        
        <button type="button" class="btn btn-primary my-5">
    <a href= "emp_data_display.php  "  class ="text-light">View All Employee</a >    
</button>
                
                            
           
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

<?php
                if(isset($_POST['submit'])){
                    $search = $_POST['search'];
                    $sql = "SELECT * from emp WHERE eid like  '%$search%' or efname like  '%$search%' or emname like '%$search%' or elname like  '%$search%'   ";
                    $result=mysqli_query($conn,$sql);
                    if($result){
                        if(mysqli_num_rows($result)>0) {
                     echo '<div class="container my-5">
                     <table class="table">  
                     <thead>
                            <tr>
                            <th scope="col">Employee Id</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Empolyee Type</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Operations</th>
                            </tr>
                          </thead>';
                          $row=mysqli_fetch_assoc($result);
                          $eid=$row['eid'];
                          $efname=$row['efname'];
                          $emname=$row['emname'];
                          $elname=$row['elname'];
                          $edob=$row['edob'];
                          $eage=$row['eage'];
                          $egender=$row['egender'];
                          $etype=$row['etype'];
                          $esalary=$row['esalary'];
                          echo '<tbody>
                          <tr>
                          <th scope="row">'.$eid.'</th>
          
                          <td>'.$efname.'</td>
                          <td>'.$emname.'</td>
                          <td>'.$elname.'</td>
                          <td>'.$edob.'</td>
                          <td>'.$eage.'</td>
                          <td>'.$egender.'</td>
                          <td>'.$etype.'</td>
                          <td>'.$esalary.'</td>
                          
              
                          <td>
                          <button class="btn btn-primary btn-sm">   <a href="update_emp_data.php?updateeid='.$eid.'" class ="text-light">UPDATE</a></button>
                          <button class="btn btn-danger btn-sm"><a href="delete_emp_data.php?deleteeid='.$eid.'" class ="text-light">DELETE</a></button>
                          <button class="btn btn-info btn-sm"><a href="employeelog.php?eid='.$eid.'" class ="text-light">VIEW LOG</a></button>
                        </td>
                          </tr>
                        
                        </tbody>
                        
                        </table>

                        </div>';
                        }
                        else{
                            echo '<h1>data not found</h1>';
                        }
                    
                    }
                    else{
                        echo 'eror ';
                    }
                }
                ?>