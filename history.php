
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>History of User</title>
	<link rel="stylesheet" href="css/history.css">
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
	<div class="main_content">
<h2>History of Problem :</h2>	 
     <div>       
      <table> <!--style="color:white; widht:100%; border:2px solid black; collapse:collase;" -->
            <tr>
               <th>Date and Time</th>  
                <th>Problem</th>
                <th>Description</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <!-- <th>Aggrement Phot of Company</th> -->
                <th>Manpower Name</th>
                <th>Manpower Address</th>            
                <th>Contact no. of Man Power</th>
            </tr>
            <tbody>
                <?php 
              
            if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
	  
		   try 
		   {
			
		     $connection = mysqli_connect('localhost','root','','bideshikokhabar');			  
		   }
		   catch (Exception $e)
		   {
			  die ('Database  error:-' . $e->getMessage());
		  }
          session_start();
          $user_id=$_SESSION["Id"];
          $sql="select * from problem_list where user_id ='$user_id';";	  			 
          $res= mysqli_query($connection,$sql);          
            while($row=mysqli_fetch_assoc($res)){
                // print_r($row);
                $problem=$row['Problem'];
                $desc=$row["Problem_Description"];
                $cname=$row["Company_Name"];
                $caddress=$row["Company_Address"];
                $apc=$row["Aggrement_Photo_of_Company"];
                $manpowerName=$row["Manpower_Name"];
                $manpowerAdrress=$row["Manpower_Address"];
                $contact=$row["Contact_Number_of_Manpower"];
                ?>
                <tr>
                    <td><?php echo $row["date"]; ?></td> 
                    <td><?php echo $problem; ?></td>
                    <td><?php echo $desc; ?></td>

                    <td><?php echo $cname; ?></td>
                    <td><?php echo $caddress; ?></td>
                    <!-- <td>
                    <img src="images/<?php //echo $apc; ?>" height="100px" width="100px"/>
                        </td> -->
                    <td><?php echo $manpowerName; ?></td>
                    <td><?php echo $manpowerAdrress; ?></td>                                   
                    <td><?php echo $contact; ?></td>
                </tr>
              <?php
            }		
               ?>
            </tbody>
        </table>       
     </div>
</div>
</body>
</html>