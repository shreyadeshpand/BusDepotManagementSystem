<?php

include 'busconnect.php';

if(isset($_GET['deleterid'])){
    $rid=$_GET['deleterid'];
    $sql= "DELETE from routedata where rid='$rid'";
    $result=mysqli_query($conn,$sql);
    if(!$result){
        die(mysqli_error($conn));
    }
    else{
        //echo 'data deletd successfully';
        header("location: showroute.php");
       
    }
}
?>