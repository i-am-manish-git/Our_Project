<?php
session_start();
if(!isset($_SESSION["Email"])){
    header("location: login.php");
    exit();
}
?>
<?php

require_once "confi.php";
$userId=$_GET['id'];
//$prblemId= $_GET['id'];
$sql="SELECT * FROM user INNER JOIN problem_list ON problem_list.user_id = user.user_id where problem_list.problem_id=$userId;";
//$sql="select * from problem_list where problem_id = $prblemID";

$results=mysqli_query($link,$sql);
$row=mysqli_fetch_assoc($results);
// print_r($row)
$profile_id=$row['user_id'];
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradeshi Ko Khabar</title>
    <link rel="stylesheet" href="css/problem.css">
    <!-- <style>
       a{
    font-size:20px;
    color:black;
    padding:20px 20px 20px 20px;
}
a:hover{
    background-position:right;
    background-color: blue;
}
        </style> -->
</head>
<body>
 <?php  
        $part= $_GET['id'];
    ?>
    <!-- <?php echo $part; ?> -->
   <div class="menu">
    <a href="Admin_Dashboard.php ">Dashboard</a> 
    <!-- <a href="View_Details.php?id= <?php echo $part; ?>  ">Problem Details</a>  -->
    <a href="1_Profile.php?id=<?php echo $profile_id; ?> ">Profile</a>
</div>
<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >

<br><br>
<h2>Problem Details:</h2>
  <br><br>
  <?php foreach($results as $result):{  ?>
   
    <!-- <td><?php  echo $key+1; ?></td> -->
    <span>Problem:</span> 
    <p> <?php  echo $result['Problem']; ?></p>
    <span>Problem Description:</span> 
    <p> <?php  echo $result['Problem_Description']; ?></p>
    <span>Company Name:</span>
    <p><?php  echo $result['Company_Name']; ?></p>
    <span>Company Address:</span>
    <p><?php  echo $result['Company_Address']; ?></p>
    <span>Aggrement Photo of Company:</span>
    <p> 
    <a href="<?php  echo $result['Aggrement_Photo_of_Company']; ?>">    
    <img src="<?php  echo $result['Aggrement_Photo_of_Company']; ?>" height="300px" width="400px"/>
   </a>
    </p>
    <span>Manpower Name:</span>
    <p> <?php  echo $result['Manpower_Name']; ?></p>
    <span>Manpower Address:</span>
    <p><?php  echo $result['Manpower_Address']; ?></p>
    <span>Contact Number of Manpower:</span>
    <p><?php  echo $result['Contact_Number_of_Manpower']; ?></p>
    <span>Province:</span>
    <p> <?php  echo $result['Province']; ?></p>
    <span>District:</span>
    <p><?php  echo $result['District']; ?></p>
    <span>Municipality:</span>
    <p><?php  echo $result['Municipality']; ?></p>
    <span>Wardno:</span>
    <p> <?php  echo $result['Wardno']; ?></p>
  <?php } endforeach ?>
</form>
</body>
</html>