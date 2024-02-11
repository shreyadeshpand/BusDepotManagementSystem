<?php
include 'busconnect.php';

$oldeid = '';
$busNo = '';
$shiftNo = '';
$neweid='';
$ejob='';
$etype='';
$ename='';



?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Assigned employee</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        table tr:not(:first-child) {
            cursor: pointer;
            transition: all .25s ease-in-out;
        }
        table tr:not(:first-child):hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<form method ="post" mt-4>

<div class="alert alert-primary" role="alert">


<?php
if(isset($_GET['rid'], $_GET['eid'], $_GET['ejob'], $_GET['busNo'], $_GET['shiftNo'], $_GET['date'])){
    $rid = $_GET['rid'];
    $oldeid = $_GET['eid'];
    $ejob = $_GET['ejob'];
    $busNo = $_GET['busNo'];
    $shiftNo = $_GET['shiftNo'];
    $date = $_GET['date'];

    echo '  <input type="hidden" name="busNo" value="<?php echo $busNo ?>">
<input type="hidden" name="shiftNo" value="<?php echo $shiftNo ?>">';
echo "You are replacing employee ".$oldeid." assigned to bus no ".$busNo. " for shift no ".$shiftNo; 
  

}
 echo ' </div>';


  if(isset($_POST['assignemp'])){

    $neweid = $_POST['eid'] ?? '';
    $ename = $_POST['ename'] ?? '';
    $ejob = $_POST['ejob'] ?? '';
    $etype = $_POST['etype'] ?? '';

    $sql = "UPDATE assignedemp SET eid='$neweid' WHERE eid='$oldeid' AND date=CURDATE() and shiftno=$shiftNo";
    $result=mysqli_query($conn,$sql);

    if($result){
        echo "You have replaced employee ".$neweid." assigned to bus no ".$busNo. " for shift no ".$shiftNo; 
    }
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
else{
    echo  mysqli_error($conn);
}

?>



<div class ="form-group">

    <div class="searchBox">    
        <input type="text" class="searchTextBox" id="searchTextBoxid" onkeyup="search()" placeholder="Search..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search...'"/>    
        <label id="NotExist" style="display:none"></label> <!-- This label is hidden and used to show a message "Does not exist!" below the search box if searched keyword is not available -->    
    </div>  

    <div>
        eid: <input type="text" name="eid" id="eid"><br><br>
        ename: <input type="text" name="ename" id="ename"><br><br>
        ejob: <input type="text" name="ejob" id="ejob"><br><br>
        etype: <input type="text" name="etype" id="etype"><br><br>

        <button class="btn btn-primary assign-employee-btn" type="submit" name="assignemp" id="assignemp" data-task-id="'.$eid.'"> UPDATE EMPLOYEE</button>
        <button type="submit" name="shift2"
                class="btn btn-danger" >
               
                    <a href="bus_schedule_data.php">Bus Schedule</a>
                </button>
             

    </div>

    
    <?php
    echo '<table id="table" border="1">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">EID</th>
                  <th scope="col">Employee Name</th>
                  <th scope="col">Employee Job</th>
                  <th scope="col">Employee Type</th>
                </tr>
              </thead>
              <tbody>';

    $sql = "SELECT * FROM driver_view WHERE eid NOT IN (SELECT eid FROM assignedemp WHERE date = CURDATE())";
    $result = mysqli_query($conn, $sql);

    if ($result) {

 

        while ($row = mysqli_fetch_assoc($result)) {
            $eid = $row['eid'];
            $ename = $row['ename'];
            $etype = $row['etype'];
            $jobtype = 'conductor';
            echo '<tr>
                    <th scope="row">' . $eid . '</th>
                    <td>' . $ename . '</td>
                    <td>' . $etype . '</td>
                    <td>' . $jobtype . '</td>
                  </tr>';
        }
    }

    echo '<script>
             
    var table = document.getElementById("table");
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         //rIndex = this.rowIndex;
                         document.getElementById("eid").value = this.cells[0].innerHTML;
                         document.getElementById("ename").value = this.cells[1].innerHTML;
                         document.getElementById("ejob").value = this.cells[2].innerHTML;
                         document.getElementById("etype").value = this.cells[3].innerHTML;
                    };
                }
    
         </script>';


  echo '</tbody>
</table>';

?>
</body>
</html>

<script>
function search()    
{    
    var input, filter, table, tr, td, i;    
    input = document.getElementById("searchTextBoxid"); //to get typed in keyword    
    filter = input.value.toUpperCase(); //to avoid case sensitive search, if case sensitive search is required then comment this line    
    table =document.getElementById("table"); //to get the html table    
    tr = table.getElementsByTagName("tr"); //to access rows in the table    
    var countvisble=0; //to hide and show the alert label    
    // Search all table rows, hide those who don't match the search key word    
    for(i=0;i<tr.length;i++)    
    {    
        td=tr[i].getElementsByTagName("td")[0]; //search keyword searched only in 1st column of the table, if you want to search other columns then change [0] to [1] or any required column number    
        if(td)    
        {    
            if(td.innerHTML.toUpperCase().indexOf(filter)>-1)    
            {    
                countvisble++;    
                tr[i].style.display="";    
                document.getElementById("NotExist").style.display = "none";    
            }    
            else    
            {    
                tr[i].style.display = "none";    
                document.getElementById("NotExist").style.display = "none";    
            }    
        }    
    }    
    if(countvisble==0) //displays the alert message label    
    {    
        document.getElementById("NotExist").style.display = "Block";    
        document.getElementById("NotExist").innerHTML = "Does not exist!";    
    }    
} 

</script>
