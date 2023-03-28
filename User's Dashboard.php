<?php
session_start();
if(!isset($_SESSION["Email"])){
    header("location: login.php");
    exit();
}
require_once("Confi.php");
	?>
<?php 
 ?>
<?php 
$err=[];
	 $problem = $cname = $caddress = $mname = $maddress =  $phone = $dob =  $province =  $district = $municipality = $wardno = $priority = $gender =  $photo = $problems="";

	if(isset($_POST['submit'])) {
	
	
        if(isset($_POST['problem']) && !empty($_POST['problem']) && trim($_POST['problem'])){
			$problem = $_POST['problem'];
			echo $problem;
			
		} else {
			$errproblem = "Enter Problem";
			$err['problem']="Enter Problem";
			// echo $err['problem'];
			// echo $errproblem;
		
			
		}

		if(isset($_POST['problems']) && !empty($_POST['problems']) && trim($_POST['problems'])){
			$problems = $_POST['problems'];
		} else {
			$errproblems = "Enter Problems";
			$err['problems']="Enter Problem describe";

		}

		if(isset($_POST['cname']) && !empty($_POST['cname']) && trim($_POST['cname'])) {
			$cname = $_POST['cname'];
			if ( !preg_match ("/^[a-z A-Z]+$/",$cname)) {
			 	$errcname = "Name must only contain letters!";
				$err['cname']="Name must only contain letters!";
			}
		} else {
			$errcname =  "Enter Company Name";
			$err['errcname']="Enter company Name";
		}

            if(isset($_POST['mname']) && !empty($_POST['mname']) && trim($_POST['mname'])) {
                $mname = $_POST['mname'];
                if ( !preg_match ("/^[a-z A-Z]+$/",$mname)) {
                     $errmname = "Name must only contain letters!";
					 $err['mname']="name must only contain letters!";
                }
            } else {
                $errmname =  "Enter Manpower Name";
			$err['mname']="Enter Manpower Name";

            }

		if(isset($_POST['caddress']) && !empty($_POST['caddress']) && trim($_POST['caddress'])){
			$caddress = $_POST['caddress'];
		} else {
			$errcaddress = "Enter Company Address";
			$err['caddress']="Enter Company Address";
		}

        if(isset($_POST['maddress']) && !empty($_POST['maddress']) && trim($_POST['maddress'])){
			$maddress = $_POST['maddress'];
		} else {
			$errmaddress = "Enter Manpower Address";
			$err['maddress']="Enter Manpower Address";

		}
		
		if(isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone'])){
			$phone = $_POST['phone'];
			if ( !preg_match ("/^[0-9]{10}$/",$phone)) {
			// if(!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $phone)) {
				$errphone = "Number must be 10 digit!";
				$err['phone']="Number must be 10 digit";
		   }
		} else{
			$errphone = "Enter Phone Number";
			$err['phone']="Enter Phone Number";
		}


		if(isset($_POST['province']) && !empty($_POST['province'])){
			$province = $_POST['province'];
		} else {
			$errprovince = "Select Province";
			$err['province']="Select Province";
		}

		if(isset($_POST['district']) && !empty($_POST['district'])){
			$district = $_POST['district'];
		} else {
			$errdistrict = "Select District";
			$err['district']="Select District";
		}

		if(isset($_POST['municipality']) && !empty($_POST['municipality'])){
			$municipality = $_POST['municipality'];
		} else {
			$errmunicipality = "Select Municipality";
			$err["municipality"]="Select Municipality";
		}
      
		if(isset($_POST['wardno']) && !empty($_POST['wardno'])){
			$wardno = $_POST['wardno'];
		} else {
			$errwardno = "Select Ward No";
			$err['wardno']="select Ward No";
		}
		

        // if(isset($_POST['priority']) && !empty($_POST['priority'])){
		// 	$priority = $_POST['priority'];
		// } else {
		// 	$errpriority = "Select Priority";
		// }


	
		if (isset($_POST['submit'])) {
			//create blank array to store error
			// $error = [];
			$target_path="images/";
			$target_path=$target_path.basename($_FILES['photo']['name']);
			if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)){
				$photo=$target_path;
				
			}else{
				$error['photo'] = 'File upload error';
			}
		}
		if(count($err)==0){
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
	  
		   try 
		   {
			  $user_id=$_SESSION["Id"];
		   $connection = mysqli_connect('localhost','root','','bideshikokhabar');
			
		   $sql="INSERT INTO `problem_list` (`problem_id`, `Problem`, `Company_Name`, `Company_Address`, `Aggrement_Photo_of_Company`, `Manpower_Name`, `Manpower_Address`, `Contact_Number_of_Manpower`,
		    `Province`, `District`, `Municipality`, `Wardno`, `user_id`,  `Problem_Description`) VALUES (NULL, '$problem', '$cname', '$caddress',
			 '$photo', '$mname', '$maddress', '$phone', '$province', '$district','$municipality', '$wardno', '$user_id', '$problems');";
	  
			 
			  if(mysqli_query($connection,$sql))
			  {
				$successmsg =  'User created successfully';
				?>
				  <script>
					alert("Problem has been successfully listed");
					  window.location.href=window.location.href;
				  </script>
				<?php 
			   
			  }
		   }
		   catch (Exception $e)
		   {
			  die ('Database  error:-' . $e->getMessage());
		  }
			
		}else{
			// print_r($err);
		}

	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User's Dashboard</title>
	<link rel="stylesheet" href="css/users_dashboard.css">
</head>
<body>
	<div class="wrapper">
	<div class="sidebar">
		<h2>PradeshiKoKhabar</h2>
		<ul>
			<li><a href="User's Dashboard.php">Dashboard</a></li>
			<li><a href="user_profile.php">My Details</a></li>
			<li><a href="notification.php">Notification</a></li>
			<li><a href="history.php">History</a></li>
			<li><a href="Logout.php">Logout</a></li>
        </ul>
    </div>
	<?php 
	$user_id = $_SESSION['Id'];
	$SQL = "select count(*) as ncount from notification where user_id = $user_id and read_status = 0";
	$query = mysqli_query($link, $SQL);
	$count = mysqli_fetch_assoc($query)['ncount'];
	?>
	<!-- <div style="display: flex; flex-direction: row; justify-content: space-between;">
		<h1>PradeshiKoKhabar</h1>
		<div>
			<a href="notification.php">Notifications <span style="background-color: red; color: #FFFFFF"><?php echo $count; ?></span></a>
			<a href="user_profile.php">Profile</a>
		</div>
	</div> -->
	<div class="main_content">
<h3>Address Problems with Full details:</h3>
	<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data" >

	<div >
	    <label>Problem:</label>
		<input type = "text" name = "problem" value = "<?php echo $problem; ?>" >
		<!-- <?php echo $problem; ?> -->
		<span style='color:red;'> <?php if(isset($err['problem'])){ echo $err['problem']; } ?></span>
    </div>

	<div>
		<label>Problem Description:</label>
		<input type = "text" name = "problems" value = "<?php echo $problems; ?>">
        <span style='color:red;'><?php if(isset($err['problems'])){ echo $err['problems']; } ?></span>
		<!-- <textarea name = "problems"  rows="4" cols="50"><?php echo $problems ?>
		</textarea> -->
    </div>
		

    <div> 
        <label>Company Name:</label>
		<input type = "text" name = "cname" value = "<?php echo $cname; ?>">
		<span style='color:red;'> <?php if(isset($errcname)){ echo $errcname; } ?></span>
    </div>
 
    <div>
		<label>Company Address:</label>
		<input type = "text" name = "caddress" value = "<?php echo $caddress; ?>" > 
		<span style='color:red;'> <?php if(isset($errcaddress)){ echo $errcaddress; } ?></span>
    </div>

        <div>
        <label>Aggrement photo of Company:</label>
  		<input type="file" name="photo">
	    <span style='color:red;'><?php if (isset($error['photo'])) {echo $error['photo'];}?></span>
	</div>

	<div>
        <label>Manpower Name:</label>
		<input type = "text" name = "mname" value = "<?php echo $mname; ?>">
		<span style='color:red;'> <?php if(isset($errmname)){ echo $errmname; } ?></span>
	</div>

	<div>
        <label>Manpower Address:</label>
		<input type = "text" name = "maddress" value = "<?php echo $maddress; ?>" > 
		<span style='color:red;'> <?php if(isset($errmaddress)){ echo $errmaddress; } ?></span>
	</div>

	<div>
		<label>Contact no. of Manpower:</label>
		<input type = "number" name = "phone" value = "<?php echo $phone; ?>" >
		<span style='color:red;'> <?php if(isset($errphone)){ echo $errphone;} ?></span>
	</div>

	<div>
		<label>Address:</label>

		<span style='color:white;'> Provinces:</span>
		<select name = "province">
		<option><?php echo $province; ?></option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
        <option>4</option>
		<option>5</option>
		<option>6</option>
        <option>7</option>
		</select>
		<span style='color:red;'> <?php if(isset($errprovince)){ echo $errprovince; } ?></span>
		
		<span style='color:white;'> District:</span>
		<select name = "district">
		<option><?php echo $district; ?></option>
		<option>Kanchanpur</option>
		<option>Kailali</option>
		<option>Baitadi</option>
		<option>Dharchula</option>
		<option>Dadeldhura</option>
		<option>Doti</option>
		<option>Achham</option>
		<option>Bajura</option>
		<option>Bajhang</option>

		</select>
		<span style='color:red;'><?php if(isset($errdistrict)){ echo $errdistrict; } ?></span>

		<span style='color:white;'> Municipality:</span>
		<select name = "municipality">
		<option><?php echo $municipality; ?></option>
        <option value="none">Municipality</option>
		<option value="Belauri">Belauri</option>
		<option value="Punarbash">Punarbash</option>
   	    <option value="Bheemdatta">Bheemdatta</option>
    	<option value="Bedkot">Bedkot</option>
    	<option value="Mahakali">Mahakali</option>
		<option value="Shuklaphanta">Shuklaphanta</option>
		</select>
		<span style='color:red;'><?php if(isset($errmunicipality)){ echo $errmunicipality; } ?> </span>

		<span style='color:white;'> Ward no.:</span>
		<select name = "wardno" >
		<option><?php echo $wardno; ?></option>
		<option value="none">Wards</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		</select>
		<span style='color:red;'><?php if(isset($errwardno)){ echo $errwardno; } ?></span>
		<br><br>
	 </div>
		
		<!-- <a href="User's Dashboard.php" onclick="return confirm('Are you sure to Submit?')" >Submit</a> -->
		<input type = "submit"  name="submit" onclick ="return confirm('Are you sure to submit?')">
	</form>

</div>
</body>
</html>