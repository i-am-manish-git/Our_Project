<?php
session_start();
if(!isset($_SESSION["Email"])){
    header("location: login.php");
    exit();
}
define("PENDING", 0);
define("WAITING", 1);
define("COMPLETED", 2);
?>

<?php
require_once "confi.php";
$tableArray=[];
$sql="select * from problem_list";
$result=mysqli_query($link,$sql);
if(mysqli_num_rows($result)>0)
{
    while($rows=mysqli_fetch_assoc($result))
    {
        array_push($tableArray, $rows);
    }
}else{
    echo "no record found";
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradeshi KO Khabar</title>
    <script src="jquery.js"></script>
    <link rel="stylesheet" href="css/admin_dahboard.css">
</head>
<body>
<h1>Pradeshi Ko Khabar</h1>
<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
    <h2>Inquiry List </h2>
    <table>
        <tr>
            <th>S.No</th>
            <th>Problem</th>
            <th>Company Name</th>
            <th>Manpower Name</th>
            <th>Date</th>

            <th>Check List</th>
            <th>View Details</th>
        </tr>

        <?php
        $index = 1;
        foreach($tableArray as $key => $value){ ?>
            <tr>
                <td hidden id="problem_id" class="problem_id"><?php  echo $value['problem_id']; ?></td>

                <td><?php  echo $index++; ?></td>


                <td><?php  echo $value['Problem']; ?></td>
                <td><?php  echo $value['Company_Name']; ?></td>
                <td><?php  echo $value['Manpower_Name']; ?></td>
                <td><?php  echo $value['date']; ?></td>

                <td>
                    <?php
                    $status = $value['status'];
                    $problem_id = $value['problem_id'];
                    $user_id = $value['user_id'];
                    ?>
                    <select id="status" class="status">
                        <option value="Pending" <?php echo $status == PENDING ?  "selected" :  ""; ?>>Pending</option>
                        <option value="Waiting" <?php echo $status == WAITING ? "selected" : ""; ?>>Waiting</option>
                        <option value="Completed" <?php echo $status == COMPLETED ? "selected" : ""; ?>>Completed</option>
                    </select>
                </td>
                <td>
                    <button>
                        <a href="View_Details.php?id=<?php echo $problem_id;?>">View Details</a>
                        <a href="Delete.php?id=<?php echo $value['problem_id'] ?>" onclick="return confirm('Are you sure to delete?')" >Delete</a>

                    </button>
                </td>
                <td hidden id="userId" class="userId"><?php  echo $value['user_id']; ?></td>
            </tr>
        <?php } ?>
    </table>
</form>
<div class="logout">
    <a href="logout.php">Logout</a>
</div>
</body>
<script>
    const boxes = Array.from(document.getElementsByClassName('status'));

    boxes.forEach(box => {
        box.addEventListener('change', function handleClick(event) {

            let id = "<?php echo $value['user_id']; ?>";
            var problemId = box.closest('tr').firstElementChild.innerHTML;
            var userId= box.closest('tr').lastElementChild.innerHTML;
            console.log(problemId);
            var updateTo = 0;
            if(box.value === "Pending")
                updateTo = 0;
            else if(box.value === "Waiting")
                updateTo = 1;
            else if(box.value === "Completed")
                updateTo = 2;

            $.ajax({
                url: `update-problem-status.php?updateto=${updateTo}&id=${problemId}`
            });

            $.ajax({
                url: `generate-notif.php?id=${userId}&type=${updateTo}`
            });

        });
    });

</script>
</html>