<?php
session_start();
if(!isset($_SESSION["Email"])){
    header("location: login.php");
    exit();
}
	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradeshi Ko Khabar</title>
</head>
<body>
<?php 
	require 'Confi.php';
	$name = $address = $phone = $dob = $gender = $fname= $mname = $email = $confirm_password = $password ="";
	$errname = $errdob = $errgender = $errfname = $errmname = $errphone = $erraddress = $erremail = $errpassword = $errconfirm_password = "";
	$userId=$_GET['id'];
	try {
		$sql = "select * from user where user_id = '$userId' limit 1;";
		// echo $sql;
		// die();
		$query = mysqli_query($link, $sql);
	} catch (Exception $e) {
		$error['database'] = $e -> getMessage();
	}
	if(isset($_POST['submit'])) {
		if(isset($_POST['name']) && !empty($_POST['name']) && trim($_POST['name'])) {
			$name = $_POST['name'];
			if ( !preg_match ("/^[a-zA-Z]+$/",$name)) {
			 	$errname = "Name must only contain letters!";
			}
		} else {
			$errname =  "Enter name";
		}

	 if(isset($_POST['dob']) && !empty($_POST['dob']) && trim($_POST['dob'])){
	 	$dob = $_POST['dob'];
		} else {
			$errdob = "Enter date of birth";
		 }

		
		if(isset($_POST['gender']) && !empty($_POST['gender'])){
			$gender = $_POST['gender'];
		} else {
			$errgender = "Enter gender";
		}

		if(isset($_POST['fname']) && !empty($_POST['fname']) && trim($_POST['fname'])) {
			$fname = $_POST['fname'];
			if ( !preg_match ("/^[a-zA-Z]+$/",$fname)) {
			 	$errfname = "Name must only contain letters!";
			}
		} else {
			$errfname =  "Enter father name";
		}

		if(isset($_POST['mname']) && !empty($_POST['mname']) && trim($_POST['mname'])) {
			$mname = $_POST['mname'];
			if ( !preg_match ("/^[a-zA-Z]+$/",$mname)) {
			 	$errmname = "Name must only contain letters!";
			}
		} else {
			$errmname =  "Enter mother name";
		}

		if(isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone'])){
			$phone = $_POST['phone'];
		} else{
			$errphone = "Enter phone";
		}


		if(isset($_POST['address']) && !empty($_POST['address']) && trim($_POST['address'])){
			$address = $_POST['address'];
		} else {
			$erraddress = "Enter address";
		}
    }
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User's Profile</title>
	<link rel="stylesheet" href="css/profile.css">
</head>
<body>
<div class="main">
<?php foreach($query as $user_data):{ ?>
	<div id="center">
		<img src="<?php echo $user_data['profile_picture']; ?>" height="140px" width="150px"/>
</div> 
	<h2><?php echo $user_data['Name']; ?></h2>

	<div class="db">
		<span> Date of Birth:</span>					
		<p><?php echo $user_data['Date_of_Birth']; ?></p>
	</div>

	 <div class="gender">
		<span>Gender: </span>
		<p><?php echo $user_data['Gender']; ?></p>
	</div>

	<div class="fn">
		<span>Father Name:</span>
		<p><?php echo $user_data['Father_Name']; ?></p>
	</div>

	<div class="mn">
		<span>Mother Name:</span>
		<p><?php echo $user_data['Mother_Name']; ?></p>
	</div>

	<div class="email">
		<span>Email:</span>
		<p><?php echo $user_data['Email']; ?></p>
	</div>

	<div class="number">
		<span>Contact Number::</span>
		<p><?php echo $user_data['Contact_Number']; ?></p>
	</div>

	<div class="address">
		<span>Permanent Address:</span>
		<p><?php echo $user_data['Permanent_Address']; ?></p>
	</div>
     <?php } endforeach ?>
    </div>
</body>
</html>
