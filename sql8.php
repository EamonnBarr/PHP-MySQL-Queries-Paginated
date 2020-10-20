<?php

// Start of PHP 

// A connection to the database via PHPMYADMIN
$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
  or die("Could not connect: " . mysqli_error($conn));
  print "Successful Connection<br/>";

// Locating the exact database
mysqli_select_db($conn, 'B00712667') or die ('db will not open');
  print "Database Connected";

  
    // Locating the MAX from the selected table
$sql = "SELECT * FROM movie WHERE Year = (SELECT max(Year) FROM movie) GROUP BY Title" ;
    
    // If the connection has been successful or else cant connect 
if($conn->query($sql) == TRUE){
   echo "success in entry"; 
}
else {
    echo " error " . $sql . "<br>" . $conn->error;
}

// Looking for a vaild Query to show the outcome from the selected table
$result = mysqli_query($conn, $sql) or die(" Invalid Query ");
$num = mysqli_num_rows($result);
$col = mysqli_num_fields($result);
  echo "<table border='1'><th>Movie ID</th><th>Title</th><th>Duration</th><th>Year</th>";

// A loop to show the outcome

  for($i=1;$i<=$num; $i++){
    $row = mysqli_fetch_row($result);
    echo "<tr>";
    for($j=0;$j<$col; $j++){
    echo "<td>" . $row[$j] . "</td>";
    }
  }
// End table
  echo "</table>";

// End of PHP
?>

