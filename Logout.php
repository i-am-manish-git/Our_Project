<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
unset($_SESSION);
 
// Destroy the session.
session_destroy();
 
// Redirect to LoginPage 
header("location: login.php");
exit;
?>