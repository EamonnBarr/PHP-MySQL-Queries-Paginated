<?php
// Start of PHP

// A connection to the database
$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
  or die("Could not connect: " . mysqli_error($conn));
  print "Successful Connection<br/>";

// Locating the exact database
mysqli_select_db($conn, 'B00712667') or die ('db will not open');
print "Database Connected";


// Initialize Variables

$column = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $column = $_POST["column"];
// Altering the table to add a column
    $sql = "ALTER TABLE movie ADD $column varchar(30);";

    $insertNew = mysqli_query($conn, $sql);
    
// Showing if connected to the database and if not 
    if($conn->query($sql) == TRUE){
   echo "success in entry"; 
}
else {
    echo " error " . $sql . "<br>" . $conn->error;
}   
}
// End Of PHP
?>

<!--Start of HTML -->
<html>
<head>
</head>
<!--A form action to allow a user to add a column with the name they choose -->
<body>
<h3>Add a new record!</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
Add Column: <input type="text" name="column" placeholder="Column" value="<?php echo $column; ?>"><br><br>
<input type="submit" name="insert" value="Add">
</form>
</body>
</html>
<!--End of HTML-->