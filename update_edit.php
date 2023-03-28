<?php 
require_once("Confi.php");
$status = $_GET['updateto'];
$id = $_GET['id'];
mysqli_query($link, "update user set status = $status where user_id = $id;");
?>