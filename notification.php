<?php
session_start();

	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradeshi Ko Khabar</title>
    <link rel="stylesheet" href="css/notifications.css">
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
    <?php 
    $user_id=$_SESSION["Id"];
    //print_r ($user_id); 
    $connection = mysqli_connect('localhost','root','','bideshikokhabar');
    $query = "select * from notification where user_id  = $user_id;";

    $notifs = [];
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result))
    {
        echo "<div style='background-color: rgb(230, 230, 230); margin-bottom: 10px; border-bottom: 1px solid yellow;'>";
        if($row['read_status'] == "0")
            echo "<b>" . $row['title'] . "</b>";
        else 
            echo $row['title'];
        echo "<br>";
        if($row['read_status'] == "0")
            echo "<b>" . $row['description'] . "</b>";
        else 
            echo $row['description'];
        echo "<br>";

        if($row['read_status'] == "0")
            echo "<b>" . $row['date'] . "</b>";
        else 
            echo $row['date'];
        echo "<br>";
        echo "</div>";
    }
    ?>
    </div>
</body>
</html>