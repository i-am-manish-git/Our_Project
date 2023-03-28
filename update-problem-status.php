<?php 
require_once("Confi.php");
$status = $_GET['updateto'];
$id = $_GET['id'];
mysqli_query($link, "update problem_list set status = $status where problem_id = $id;");
?>