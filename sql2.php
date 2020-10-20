<?php
include "session.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php");
    exit;
}


$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
or die("Could not connect: " . mysqli_error($conn));
print "Successful Connection<br/>";

mysqli_select_db($conn, 'B00712667') or die ('db will not open');
print "Database Connected";


$result = mysqli_query($conn, "select avg(age) from actors");
$num = mysqli_num_rows($result);
$col = mysqli_num_fields($result);

echo "<table border='1' align='center' <tr><th>Average</th>";
for($i=1;$i<=$num; $i++)
{
    $row = mysqli_fetch_row($result);
    echo "<tr>";
    for($j=0;$j<$col; $j++){
    echo "<td>" . $row[$j] . "</td>";
}
}
echo "</table>";

$result = mysqli_query($conn, "select count(*) from actors");
$num = mysqli_num_rows($result);
$col = mysqli_num_fields($result);

echo "<br/><table border='1'align='center'<tr><th>Count</th>";
for($i=1;$i<=$num; $i++)
{
    $row = mysqli_fetch_row($result);
    echo "<tr>";
    for($j=0;$j<$col; $j++){
    echo "<td>" . $row[$j] . "</td>";
}
}
echo "</table>";

include "start.php";

?>