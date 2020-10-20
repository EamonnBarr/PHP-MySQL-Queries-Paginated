<?php
// Start of PHP

// A connection to a database 
$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
  or die("Could not connect: " . mysqli_error($conn));
  print "Successful Connection<br/>";

// Searching for the exact database
mysqli_select_db($conn, 'B00712667') or die ('db will not open');
  print "Database Connected";

  
 // Groups the selected information   
$sql = "SELECT MID, MAX( q ) FROM (SELECT MID, sum(Seats) AS q FROM showtime GROUP BY MID) sum_view" ;
    
// Shows whether the database is connected or not
if($conn->query($sql) == TRUE){
   echo "success in entry"; 
}
else {
    echo " error " . $sql . "<br>" . $conn->error;
}

// shows the result of a vaild Query or if the Query is Invaild
    $result = mysqli_query($conn, $sql) or die(" Invalid Query ");
    $num = mysqli_num_rows($result);
    $col = mysqli_num_fields($result);

// Displays a table of information
  echo "<table border='1'><th>MID</th><th>Q</th>";
// Information looped from the database
  for($i=1;$i<=$num; $i++){
  $row = mysqli_fetch_row($result);
    echo "<tr>";
      for($j=0;$j<$col; $j++){
        echo "<td>" . $row[$j] . "</td>";
      }
  }
// End Table
  echo "</table>";

// End Of PHP
?>

