<?php
session_start();
if(!isset($_SESSION["Email"])){
    header("location: login.php");
    exit();
}
?>	
<?php if(isset($_GET['id'])){
	
	$id = $_GET['id'];
	// echo $id;
 

	require 'Confi.php';
	
	try {

		$sql = "select * from  user where user_id = '$id' ";
		// echo $sql;
		$query = mysqli_query($link, $sql);
		$row=mysqli_fetch_assoc($query);
		// print_r($row);

	} catch (Exception $e) {
		$error['database'] = $e -> getMessage();
	}
}
	//session_start();
	$err=[];
	$name = $address = $phone = $dob = $gender = $fname= $mname = "";
	$errname = $errdob = $errgender = $errfname = $errmname = $errphone = $erraddress = "";

	// $user_id = $_SESSION["Email"];



	if (isset($_POST['btn_update'])) {
		// echo "testing";
		// print_r($_POST);
		// die;
		if(isset($_POST['name']) ) {
			$name = $_POST['name'];
			// echo $name;
			// echo "xa name" ;

		} else {
			$errname =  "Enter name";
			echo $errname;
		}
		

		if(isset($_POST['dob']) && !empty($_POST['dob']) && trim($_POST['dob'])){
			// $age=0;
				$dob = $_POST['dob'];
				$year= ($dob[0].$dob[1].$dob[2].$dob[3]);
				// echo var_dump($year);
				$year=(int) ($year);
			
				$today=(int) date("Y");
			
			
				$age=(int) ($today-$dob);
				echo $age;
			
	
				if ($age >80 ) {
					$err=1;
					$errdob = 'Are you from future?';
				} else if ($age<18) {
					$err=1;
					$errdob = 'You must be 18 years old to register';
				}
			} else {
				 $err=1;
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

		if(count($err) == 0){
            try{
                $connection = mysqli_connect('localhost', 'root', '','bideshikokhabar');
               echo $id;
			   echo $name;
	$sql = "update  user set Name='$name', Date_Of_Birth='$dob', Gender='$gender', Father_Name='$fname', Mother_Name='$mname', Contact_Number='$phone', Permanent_Address='$address' where user_id=$id";
	
          echo $sql;   
		// die;
		//   die;   
                 if($connection->query($sql)){
                    $successmsg = 'Update successfully!!!';
					header('location:user_profile.php?id='.$id);

                 }else{
                    $errormsg = 'Update failed!!!';
					echo $errormsg;
                 }
            }catch (Exception $e){
                die('Database error:' . ' Code: '. $e->getCode() . ':' . $e->getMessage());
            }
        }
    }
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Profile</title>
	<link rel="stylesheet" href="css/edits.css">
</head>
<body>
	
<form action= "" method="POST" enctype="multipart/form-data">
<div class="main">
	<h2>Edit Your Profile</h2>
		<label>Full Name:</label>
		<input type="text" name="name" value="<?php echo $row['Name']; ?>" placeholder="Enter Your Name">
        <span><?php if (isset($errname)){
        echo $errname;} ?></span>
		<br><br>

		<label>Date Of Birth:</label>
		<input type="date" name="dob" value="<?php echo $row['Date_of_Birth']; ?>">
        <span><?php if (isset($errdob)){
        echo $errdob;} ?></span> 
		<br><br>

		<label>Gender:</label>
		 <!-- <?php print_r($row); ?> -->
		<input type="radio" name="gender" value="Male" id="" <?php if($row['Gender']=='Male'){ echo "checked"; } ?> >Male
        <input type="radio" name="gender" value="Female" id="" <?php if($row['Gender']=='Female'){ echo "checked"; } ?> >Female
        <input type="radio" name="gender" value="Other" id="" <?php if($row['Gender']=='Other'){ echo "checked"; } ?>  >Other
        <span><?php if (isset($errgender)){
        echo $errgender;} ?></span>
		<br><br>

		<label>Father Name:</label>
		<input type="text" name="fname" value="<?php echo $row['Father_Name']; ?>" placeholder="Enter Your Name">
        <span><?php if (isset($errfname)){
        echo $errfname;} ?></span>
		<br><br>

		<label>Mother Name:</label>
		<input type="text" name="mname"  value="<?php echo $row['Mother_Name']; ?>" placeholder="Enter Your Name">
        <span><?php if (isset($errmname)){
        echo $errmname;} ?></span>
		<br><br>

		<label>Contact No. :</label>
		<input type="text" name="phone" value="<?php echo $row['Contact_Number']; ?>" placeholder="Enter Your Mobile no">
        <span><?php if (isset($errphone)){
        echo $errphone;} ?></span>
		<br><br>

		<label>Permanent Address:</label>
		<input type="text" name="address" value="<?php echo $row['Permanent_Address']; ?>" placeholder="Enter Your Address">
        <span><?php if (isset($erraddress)){
    	echo $erraddress;} ?></span>
<br>
<br>
<div class="update">
<input type="submit" value="Update" name="btn_update">
		</div>
		</div>
</body>
</html>

