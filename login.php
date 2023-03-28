<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["Email"])){
    header("location: User's Dashboard.php");
    exit;
}
 
// Include config file
require_once "confi.php";
 
// Define variables and initialize with empty values
$Email = $Password = $password = "";
$Email_err = $Password_err = $login_err = "";
 
// Processing form data when form is submitted
if(isset($_POST['Log'])){
 
    // Check if email is empty
    if(empty(trim($_POST["Email"]))){
        $Email_err = "Please enter your Email.";
    } else{
        $Email = trim($_POST["Email"]);
    }
    
    // Check if password is empty
    if(empty($_POST["Password"])){
        $Password_err = "Please enter your Password.";
        
    } else{
        $password = $_POST['Password'];
        $Password =md5(trim($_POST["Password"]));
    }
  
    // Validate credentials
    if(empty($Email_err) && empty($Password_err)){
    
        // die();

        if(isset($_POST['isAdmn'])){
            try {
                $sql = "SELECT * FROM admin WHERE Email ='$Email' and Password='$Password'";  
                $retRes = $link->query($sql);
                
                if (mysqli_num_rows($retRes) == 1 ) // if ($count===1)
                {             
                    $data = mysqli_fetch_assoc($retRes);

                                $_SESSION["Email"] = $data['Email'];      
                                $_SESSION["Id"]=$data['admin_id'];
                                // Redirect user to welcome page
                                header("location: Admin_Dashboard.php");
                }else{
                    // Password is not valid, display a generic error message
                    $login_err = "Invalid Email or Password.";
                    
                }
            } catch(Exception $e)  {
                $login_err = 'Exception Error.';
            }  
           
        } else {
            $sql = "SELECT * FROM user WHERE Email ='$Email' and Password='$Password'";     

            $retRes = $link->query($sql);
            if (mysqli_num_rows($retRes) == 1 ) // if ($count===1)
            {             
                $data = mysqli_fetch_assoc($retRes);

                            $_SESSION["Email"] = $data['Email'];   
                            $_SESSION["Id"]=$data['user_id'];   
                            // Redirect user to welcome page
                            header("location: User's Dashboard.php");
            }else{
                // Password is not valid, display a generic error message
                $login_err = "Invalid Email or Password.";
                
            }
           
        }
        // }  
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradeshi KO Khabar</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<h1>Pradeshi KO Khabar</h1>
   
    <div class="login">  
    <h2>Login Form</h2> 
   <div style=color:red;> <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"> 

    <div>
        <p>Email</p>
        <input type="text" name="Email" placeholder="Enter your email" <?php echo (!empty($Email_err)) ? 'is-invalid' : ''; ?>" 
        value="<?php echo $Email; ?>"> <small> <?php echo $Email_err; ?> </small>
    </div>
          
    <div>
        <p>Password </p>
        <input type="Password" name="Password" placeholder="Enter your password" value="<?php echo $password; ?>"> <small><?php echo $Password_err; ?></small>
    </div>
    <br>

    <input  type="checkbox" class="admin" style="width:20px;"   name="isAdmn" value="isAdmn">AdminPannel
     <br><br> 
    <!-- <button type="submit" name="Log">Login</button> -->
    <input type="submit" name="Log"  value="Login"> 
    <br> <br>
    <div class="bottom-text">
    Don't have an account? <a style="color:grey" href="create_user_account.php">Create New Account</a>
    </div>
    <br><br>
    </form> 
    </div>   
</body>
<script>
    </script>
</html>