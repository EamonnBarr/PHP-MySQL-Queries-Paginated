<?php
$conn = mysqli_connect("localhost", "B00712667", "LLtkdjd4") 
or die("Could not connect: " . mysqli_error($conn));
print "Successful Connection<br/>";

mysqli_select_db($conn, 'B00712667') or die ('db will not open');
print "Database Connected<br>";

$query = "SELECT * FROM movie";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            while ($row = mysqli_fetch_assoc($result)){
                echo $row['Title'] . "<br>";
            }
        }
    mysqli_close($conn);
?>