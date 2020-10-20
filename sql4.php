<?php
include "session.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php");
    exit;
}


$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") or die("Could not connect:" . mysqli_error($conn));

mysqli_select_db($conn , 'B00712667') or die ('db will open');
      
$result = mysqli_query($conn, "SELECT BID, TicketCost from booking GROUP BY TicketCost HAVING TicketCost < 5");
      $num = mysqli_num_rows($result);
      $col = mysqli_num_fields($result);
      
echo "<table border='1' align='center' <tr><th>BID</th><th>TicketCost</th></tr>";
      
      for($i=1; $i<=$num; $i++) {
          $row = mysqli_fetch_row($result);
          echo "<tr>";
          for($j=0;$j<$col;$j++) {
          echo "<td>" . $row[$j] . "</td>";
      }
      }
    echo "</table>";


include "start.php";

?>