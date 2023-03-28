<?php 
    $uname=$uFname=$uMname=$uLname='';
    $fname=$fFname=$fMname=$fLname='';
    $mname=$mFname=$mMname=$mLname='';
	$address = $phone = $dob = $gender = $email = $confirm_password = $password ="";
	$errname = $errdob = $errgender = $errfname = $errmname = $errphone = $erraddress = $erremail = $errpassword = $errconfirm_password = "";
	$err=0;
	if(isset($_POST['submit'])) {
		if(isset($_POST['uFname']) && isset($_POST['uLname']) && !empty($_POST['uFname']) && !empty($_POST['uLname'])
		 && trim($_POST['uFname']) && trim($_POST['uLname']) ) {
			$uFname=$_POST['uFname'];
			$uMname=$_POST['uMname'];
			$uLname=$_POST['uLname'];
			$uname = $uFname. " ".$uMname. " ".$uLname;
			if ( !preg_match ("/^[a-zA-Z]+$/",$uFname)) {
			 	$errname = "Name must only contain letters!";
			}
		} else {
			$err=1;
			$errname =  "Enter name";
		}

		if(isset($_POST['dob']) && !empty($_POST['dob']) && trim($_POST['dob'])){
			$dob = $_POST['dob'];
		} else {
			$err=1;
			$errdob = "Enter date of birth";
		}

		
		if(isset($_POST['gender']) && !empty($_POST['gender'])){
			$gender = $_POST['gender'];
		} else {
			$err=1;
			$errgender = "Enter gender";
		}

		
		if(isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone'])){
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
        $password = md5(trim($_POST["password"]));
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
		$err=1;
        $errconfirm_password = "Please confirm password.";     
    } else{
        $confirm_password = md5(trim($_POST["confirm_password"]));
        if(empty($password_err) && ($password != $confirm_password)){
			$err=1;
            $errconfirm_password = "Password did not match.";
        }
    }
	
	if($err==0)
	{
		try {
			$connection = mysqli_connect('localhost','root','','bideshikokhabar');
			$sql = "insert into User (Name,Date_of_Birth,Gender,Contact_Number,Permanent_Address,Email,Password,Re_Password) 
			values ('$uname','$dob','$gender','$fname','$mname','$phone','$address','$email','$password','$confirm_password')";
			//query execution
			 // $connection->query($sql)
			if(mysqli_query($connection,$sql)){
				$successmsg =  'User created successfully';
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
	<title></title>
</head>

<body>
	<h2>Please Fill Up This Form To Create Your Account </h2>
	<hr>
	<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >

		<label>Name:</label>
		<input type = "text" name = "uFname" placeholder= "Enter First Name"  value = "<?php echo $uFname; ?>">	
		<input type = "text" name = "uMname" placeholder= "Enter Middle Name"  value = "<?php echo $uMname; ?>">
		<input type = "text" name = "uLname" placeholder= "Enter Last Name"  value = "<?php echo $uLname; ?>">
		<?php if(isset($errname)){ echo $errname; } ?>
		<br> 

		<label>Date Of Birth:</label>
		<input type = "date" name = "dob" value="<?php echo $dob; ?>" >
		<?php if(isset($errdob)){ echo $errdob; } ?><br>

		<label>Gender:</label>
		<input <?php if($gender == "Male") { echo "checked";} ?> type = "radio" name = "gender" value = "Male">Male
		<input <?php if($gender == "Female") { echo "checked";} ?> type = "radio" name = "gender" value = "Female">Female
		<?php if(isset($errgender)){ echo $errgender;} ?>
		<br>


		<label>Contact No. :</label>
		<input type = "number" name = "phone" placeholder= "Enter Number"  value = "<?php echo $phone; ?>" >
		<?php if(isset($errphone)){ echo $errphone;} ?><br>

		<label>Permanent Address:</label>
		<input type = "text" name = "address" placeholder= "Enter permanent address"  value = "<?php echo $address; ?>" > 
		<?php if(isset($erraddress)){ echo $erraddress; } ?><br>
		<hr>

		<label>Email:</label>
		<input type = "email" name = "email"  placeholder= "Enter email" value = "<?php echo $email; ?>" >
		<?php if(isset($erremail)){ echo $erremail; } ?><br>

		<label>Password:</label>
    <input type="password" placeholder="Enter Your Password" name="password" 
    class="form-control" value="<?php echo (!empty($password)) ? $password : ''; ?>">
    <span class="invalid-feedback"><?php echo $errpassword; ?></span>
    <br>

		<label>Confirm Password:</label>
    <input type="password" placeholder="Confirm Password" name="confirm_password" 
    class="form-control" 
    value="<?php echo (!empty($confirm_password)) ? $confirm_password : ''; ?>">
    <span class="invalid-feedback"><?php echo $errconfirm_password; ?></span>
    <br>
	
   <input type = "submit" name = "submit">
	</form>
</body>
</html>