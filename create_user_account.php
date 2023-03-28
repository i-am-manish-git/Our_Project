<?php 
	
    $uname=$uFname=$uMname=$uLname='';
    $fname=$fFname=$fMname=$fLname='';
    $mname=$mFname=$mMname=$mLname='';
	$address = $phone = $dob = $gender = $email = $confirm_password = $password = $photo ="";
	$errname = $errdob = $errgender = $errfname = $errmname = $errphone = $erraddress = $erremail = $errpassword = $errconfirm_password =  "";
	$err=0;
	if(isset($_POST['submit'])) {
		if(isset($_POST['uFname']) && isset($_POST['uLname']) && !empty($_POST['uFname']) && !empty($_POST['uLname'])
		 && trim($_POST['uFname']) && trim($_POST['uLname']) ) {
			$uFname=$_POST['uFname'];
			$uMname=$_POST['uMname'];
			$uLname=$_POST['uLname'];
			$uname = $uFname. " ".$uMname. " ".$uLname;
			if ( !preg_match ("/^[a-z A-Z]+$/",$uFname)) {
			 	$errname = "Name must only contain letters!";
			}
		} else {
			$err=1;
			$errname =  "Enter name";
		}
		
		if (isset($_POST['submit'])) {
			//create blank array to store error
			$error = [];
			$target_path="images/";
			$target_path=$target_path.basename($_FILES['photo']['name']);
			if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)){
				$photo=$target_path;
				
			}else{
				$error['photo'] = 'File upload error';
			}
		}

	if(isset($_POST['dob']) && !empty($_POST['dob']) && trim($_POST['dob'])){
		// $age=0;
			$dob = $_POST['dob'];
			$year= ($dob[0].$dob[1].$dob[2].$dob[3]);
			// echo var_dump($year);
			$year=(int) ($year);
		
			$today=(int) date("Y");
	
			$age=(int) ($today-$year);
		

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

		function dob($then, $min)
		{
			$then = strtotime('March 23, 1988');
			//The age to be over, over +18
			$min = strtotime('+18 years', $then);
			echo $min;
			if (time() < $min) {
				die('Not 18');
			}
		}

		
		if(isset($_POST['gender']) && !empty($_POST['gender'])){
			$gender = $_POST['gender'];
		} else {
			$err=1;
			$errgender = "Enter gender";
		}

		if(isset($_POST['fFname']) && !empty($_POST['fFname']) && trim($_POST['fFname'])) {
			$fFname=$_POST['fFname'];
			$fMname=$_POST['fMname'];
			$fLname=$_POST['fLname'];
			$fname = $fFname." ".$fMname." ".$fLname;
			if ( !preg_match ("/^[a-zA-Z]+$/",$fFname)) {
			 	$errfname = "Name must only contain letters!";
			}
		} else {
			$err=1;
			$errfname =  "Enter father name";
		}

		if(isset($_POST['mFname']) && !empty($_POST['mFname']) && trim($_POST['mFname']) 
		//&& isset($_POST['mMname']) && !empty($_POST['mMname']) && trim($_POST['mMname']) 
		&& isset($_POST['mLname']) && !empty($_POST['mLname']) && trim($_POST['mLname'])) {
			$mFname=$_POST['mFname'];
			$mMname=$_POST['mMname'];
			$mLname=$_POST['mLname'];
			$mname = $mFname." ".$mMname." ".$mLname;
			if ( !preg_match ("/^[a-z A-Z]+$/",$mFname)) {
			 	$errmname = "Name must only contain letters!";
			}
		} else {
			$err=1;
			$errmname =  "Enter mother name";
		}

		if(isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone']) ){
			$phone = $_POST['phone'];
		} else{
			$err=1;
			$errphone = "Enter phone";
		}


		if(isset($_POST['address']) && !empty($_POST['address']) && trim($_POST['address'])){
			$address = $_POST['address'];
		} else {
			$err=1;
			$erraddress = "Enter address";
		}

		if(isset($_POST['email']) && !empty($_POST['email']) && trim($_POST['email'])){
			$email = $_POST['email'];
			if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$err=1;
				$erremail = "Enter valid email";
			}
		} else {
			$err=1;
			$erremail = "Enter email";
		}

	 // Validate password
	 if(empty(trim($_POST["password"]))){
		 $err=1;
        $errpassword = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
		$err=1;
        $errpassword = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
        $password_enc = md5(trim($_POST["password"]));
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
		$err=1;
        $errconfirm_password = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        $confirm_password_enc = md5(trim($_POST["confirm_password"]));
        if(empty($password_err) && ($password != $confirm_password)){
			$err=1;
            $errconfirm_password = "Password did not match.";
        }
    }
	
	if($err==0)
	{
		try {
			$connection = mysqli_connect('localhost','root','','bideshikokhabar');
			$sql = "insert into User (Name,Date_of_Birth,Gender,Father_Name,Mother_Name,Contact_Number,Permanent_Address,Email,Password,Re_Password,Profile_Picture) 
			values ('$uname','$dob','$gender','$fname','$mname','$phone','$address','$email','$password_enc','$confirm_password_enc','$photo')";
			//query execution
			 // $connection->query($sql)
			if(mysqli_query($connection,$sql))
			{
				$successmsg =  'User Account created successfully';
				?>
				  <script>
					alert("Account has been successfully Submitted");				
					  window.location.href="login.php";
				  </script>
				<?php 
				//header('location:login.php');
			}
		} catch (Exception $e) {
			die ('Database  error:-' . $e->getMessage());
		}
	}
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration</title>
	<link rel="stylesheet" href="css/create_user_account.css">
</head>

<body>
	<h2>Please Fill Up This Form To Create Your Account </h2>
	<hr>
	<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

	<div>
		<label>Name:</label>
		<input type = "text" name = "uFname" placeholder= "Enter First Name"  value = "<?php echo $uFname; ?>">	
		<input type = "text" name = "uMname" placeholder= "Enter Middle Name"  value = "<?php echo $uMname; ?>">
		<input type = "text" name = "uLname" placeholder= "Enter Last Name"  value = "<?php echo $uLname; ?>">
		<small><?php if(isset($errname)){ echo $errname; } ?></small>
    </div>

	<div>
		<label>Date Of Birth:</label>
		<input type = "date" name = "dob" value="<?php echo $dob; ?>" >
		<small><?php if(isset($errdob)){ echo $errdob; } ?></small>
    </div>
       
    <div>
		<label>Gender:</label>
		<input <?php if($gender == "Male") { echo "checked";} ?> type = "radio" name = "gender" value = "Male">Male
		<input <?php if($gender == "Female") { echo "checked";} ?> type = "radio" name = "gender" value = "Female">Female
		<small><?php if(isset($errgender)){ echo $errgender;} ?></small>
    </div>

	<div>
		<label>Father Name:</label>
		<input type = "text" name = "fFname" placeholder= "Enter First Name" value = "<?php echo $fFname; ?>">
		<input type = "text" name = "fMname" placeholder= "Enter Middle Name" value = "<?php echo $fMname; ?>">
		<input type = "text" name = "fLname" placeholder= "Enter Last Name" value = "<?php echo $fLname; ?>">
		<small><?php if(isset($errfname)){ echo $errfname; } ?></small>
    </div>
    <div>
 		<label>Mother Name:</label>
		<input type = "text" name = "mFname" placeholder= "Enter First Name" value = "<?php echo $mFname; ?>">
		<input type = "text" name = "mMname" placeholder= "Enter Middle Name" value = "<?php echo $mMname; ?>">
		<input type = "text" name = "mLname" placeholder= "Enter Last Name" value = "<?php echo $mLname; ?>">
		<small><?php if(isset($errmname)){ echo $errmname; } ?></small>
    </div>

    <div>
		<label>Contact No. :</label>
		<input type = "number" name = "phone" placeholder= "Enter Number"  value = "<?php echo $phone; ?>" >
		<small><?php if(isset($errphone)){ echo $errphone;} ?></small>
    </div>

    <div>
		<label>Permanent Address:</label>
		<input type = "text" name = "address" placeholder= "Enter permanent address"  value = "<?php echo $address; ?>">
		<small><?php if(isset($erraddress)){ echo $erraddress; } ?></small>
    </div>

		<hr>

	<div>
		<label>Email:</label>
		<input type = "email" name = "email"  placeholder= "Enter email" value = "<?php echo $email; ?>" >
		<small><?php if(isset($erremail)){ echo $erremail; } ?></small>
    </div>

	<div>
		<label>Password:</label>
		<input type="password" placeholder="Enter Your Password" name="password" 
		 value="<?php echo (!empty($password)) ? $password : ''; ?>">
		<small><?php echo $errpassword; ?></small>
	</div>

	<div>
		<label>Confirm Password:</label>
		<input type="password" placeholder="Confirm Password" name="confirm_password"  
		value="<?php echo (!empty($confirm_password)) ? $confirm_password : ''; ?>">
		<small><?php echo $errconfirm_password; ?></small>
	</div>
	
	<div>
		    <label>Profile Picture:</label>   
			<input type="file" name="photo">
  			<br>
			<small><?php 
			if (isset($error['photo'])) {
  			echo $error['photo'];
			}
 			?></small>
	
	   <a> <input type = "submit"  name="submit" onclick ="return confirm('Are you sure to submit?')"></a>
         <!-- <a href="login.php"><input type = "submit" name = "submit"></a> -->
	</form>
</body>
</html>