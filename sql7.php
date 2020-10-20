<?php
include "session.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4")
or die("Could not connect: " . mysqli_error($conn));
print "Database Connected";

mysqli_select_db($conn, 'B00712667') or die ('db will not open');

$sql = "DELETE FROM ShowTime WHERE MID = 'M01'";
if($conn->query($sql) === TRUE){
   echo "<br>Success in Deletion"; 
}
else {
    echo "error" . $sql . "<br>" . $conn->error;
}

include "start.php";

?>
