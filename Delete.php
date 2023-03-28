
<?php 

$id = $_GET['id'];
try {
	//database connection
	$connection = mysqli_connect('localhost','root','','bideshikokhabar');
	//sql to select data from table
	$sql = "delete from problem_list where problem_id= $id";
    echo $sql;
	//excute query and get result object
	$connection->query($sql);
	
	//redirect to list page
	header('location:Admin_Dashboard.php');
} catch (Exception $e) {
	die('Database error:' . ' Code: '. $e->getCode() . ':' . $e->getMessage());
}

?>