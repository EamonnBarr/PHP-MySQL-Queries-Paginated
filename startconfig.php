<?php
$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
or die("Could not connect: " . mysqli_error($conn));


mysqli_select_db($conn, 'B00712667') or die ('db will not open');
?>