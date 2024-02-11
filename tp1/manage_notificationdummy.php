<?php 
session_start(); 
include ('busconnect.php');  
include ('Push.php');  
$push = new Push();
if(isset($_GET['eid'])){
	$eid = $_GET['eid'];
}
else{
	$eid=;
}
?>

<style>
.borderless tr td {
    border: none !important;
    padding: 2px !important;
}
</style>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Send Failure Notification</title>
  </head>
  <body>
   
    <div class="container mt-4" >
    <h1>Add new notification</h1>
    <form method ="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Title</label>
    <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter notification Title" value="Failure" disabled>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Source</label>
    <select class="custom-select" id="source" name= "source">
    <option selected>Select</option>
    <option value="Katraj">Katraj</option>
    <option value="Upper">Upper </option>
  </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Destination</label>
    <select class="custom-select" id="destination" name= "destination">
    <option selected>Select</option>
    <option value="Kothrud">Kothrud</option>
    
  </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Round</label>
    <select class="custom-select" id="round" name= "round">
    <option selected>Select</option>
    <option value="1">1</option>
    <option value="2">2 </option>
  </select>
</div>
<script>
const s = document.getElementById("source");
  const d = document.getElementById("destination");
</script>
    <?php
    $sql="SELECT * from failure ORDER BY timestamp desc limit 1";
    $res=mysqli_query($conn,$sql);
    if($res){
        $row=mysqli_fetch_assoc($res);
        $busNo=$row['busNo'];
        $location=$row['location'];
        $timestamp=$row['timestamp'];
if("<script>document.writeln(s)</script>" == "Katraj"){
    $sql="Select * from katrajfare where stopno='$location'";
}
else{
    $sql="Select * from upperfare where stopno='$location'";
}
$res=mysqli_query($conn,$sql);
if($res){
    $row=mysqli_fetch_assoc($res);
    $stopname=$row['stopname'];
   
}
    }
    $sql2="SELECT emob from emp where eid=$eid";
    $re=mysqli_query($conn,$sql2);
    if($re){
        $row=mysqli_fetch_assoc($re);
		$emob=$row['emob'];
    }
	else{
		$emob="Unavailable";
	}
    ?>
<div class="form-group">
  <label for="exampleInputPassword1">Message</label>
  <textarea name="msg" cols="50" rows="4" class="form-control" disabled>
  <?php
  echo "Bus No: " . $busNo . "\n" .
       "Location: " . $stopname . "\n" .
       "Time Stamp: " . $timestamp . "\n" .
       "Employee Id: " . $eid . "\n" .
       "Employee Mob: " . $emob . "\n";
	   "Round: <script>document.writeln(s)</script>"
?>
  </textarea>
</div>
  <div class="form-group">
    <label for="exampleInputPassword1">Broadcast Time</label>
    <select name="time"><option value="Now">Now</option></select>
  </div>



  <div class="form-group">
    <label for="exampleInputPassword1">Loop Time</label>
  <select name="loops" class="form-control">
						<?php 
							for ($i=1; $i<=5 ; $i++) { ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select>
                        </div>


	<div class="form-group">
    <label for="exampleInputPassword1">Loop Every Minute</label>
						<select name="loop_every" class="form-control">
						<?php 
						for ($i=1; $i<=60 ; $i++) { ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select> 
						</div>
<div class="form-group">
    <label for="exampleInputPassword1">For: (Controller User)</label>
 <select name="user" class="form-control">
		<?php 		
				$user = $push->listUsers(); 
				foreach ($user as $key) {
		?>
		<option value="<?php echo $key['username'] ?>"><?php echo $key['username'] ?></option>
			<?php } ?>
	</select>
                        

  <button type="submit" name = "submit" class="btn btn-primary">Submit</button>
 


    </div>
                </div>
    </form>
    <div>
	
	<?php 
	if (isset($_POST['submit'])) { 
		if(isset($_POST['msg']) and isset($_POST['time']) and isset($_POST['loops']) and isset($_POST['loop_every']) and isset($_POST['user'])) {
			$title = $_POST['title'];	
			$msg = $_POST['msg']; 
			$time = date('Y-m-d H:i:s'); 
			$loop= $_POST['loops']; 
			$loop_every=$_POST['loop_every']; 
			$user = $_POST['user']; 
			$isSaved = $push->saveNotification($title, $msg,$time,$loop,$loop_every,$user);
			if($isSaved) {
				echo '* save new notification success';
			} else {
				echo 'error save data';
			}
		} else {
			echo '* completed the parameter above';
		}
	} 
	?>
	<h3>Notifications List:</h3>
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Next Schedule</th>
				<th>Title</th>
				<th>Message</th>
				<th>Remains</th>
				<th>User</th>
			</tr>
		</thead>
		<tbody>
			<?php $a =1; 
			$notifList = $push->listNotification(); 
			foreach ($notifList as $key) {
			?>
			<tr>
				<td><?php echo $a ?></td>
				<td><?php echo $key['notif_time'] ?></td>
				<td><?php echo $key['title'] ?></td>
				<td><?php echo $key['notif_msg'] ?></td>
				<td><?php echo $key['notif_loop']; ?></td>
				<td><?php echo $key['username'] ?></td>
			</tr>
			<?php $a++; } ?>
		</tbody>
	</table>
</div>	
