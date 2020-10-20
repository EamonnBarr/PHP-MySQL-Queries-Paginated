<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();

include('startconfig.php');

$resettable = mysqli_query($conn,"UPDATE as3table SET available = 'yes'");
$deleteprevioustable = mysqli_query($conn,"DELETE FROM prevtable");

// Redirect to login page
header("location: login.php");
exit;
?>