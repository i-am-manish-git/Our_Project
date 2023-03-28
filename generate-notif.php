<?php
require_once("Confi.php");
 $id = $_GET['id'];
//$id=$_SESSION["issuedUser"];
$type = $_GET['type'];

$desc = "";
if($type == 0)
{
    $desc = "Your request is in pending list.";
}
else if($type == 1)
{
    $desc = "Your request is in waiting list.";
}
else if($type == 2)
{
    $desc = "Your request has been fulfilled.";
}

mysqli_query($link, "insert into notification (user_id, title, description, date, read_status) values($id, 'Your problem Status', '$desc', current_timestamp, 0);");

?>