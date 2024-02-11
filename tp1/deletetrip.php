<?php

include 'busconnect.php';

if(isset($_GET['deletetripno'])){
    $tripno=$_GET['deletetripno'];
    $sql= "DELETE from trips where tripno='$tripno'";
    $result=mysqli_query($conn,$sql);
    if(!$result){
        die(mysqli_error($conn));
    }
    else{
        //echo 'data deletd successfully';
        header("location: trips.php");
       
    }
}
?>