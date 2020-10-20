<?php
//Start session
include "session.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php");
    exit;
}

include('startconfig.php');

//GET CURRENT URL AND GET LOCAL PATH
$path =  $_SERVER['PHP_SELF'];
$filenameExt = basename($path);// "start.php"
$currentPage = $filenameExt;

/*
$url = $filenameExt;
$url = strtok($url, "?");   //Remove GET from URL - NOT USED
$currentPage = $url;    
*/

//IF Next button is clicked, Increase count
  if(isset($_GET['inc'])) { // Increasing
    ++ $_SESSION['count'] ; // Increment The Count Session
  }

//IF Previous button is clicked, Decrease count
  if(isset($_GET['dec'])) { // Decreasing
    -- $_SESSION['count'] ; // Decrement The Count Session
  }

//INSERT CURRENT PAGE INFO INTO PREVTABLE
$insertprev =  mysqli_query($conn,"INSERT INTO prevtable(link, available)
  SELECT * FROM (SELECT '$currentPage', 'yes') AS tmp
");

//GET CURRENT PAGE ID FROM PREVTABLE   
$getprevid = mysqli_query($conn,"select id FROM prevtable WHERE link = '$currentPage'");
  while($row1 = mysqli_fetch_array($getprevid)){
    $currentpageid = $row1[0];
  }

//GET PREVIOUS LINK
$getprevlink = mysqli_query($conn,"select link FROM prevtable WHERE id = (select max(id) FROM prevtable WHERE id < $currentpageid ORDER BY id LIMIT 1 )");
  while($row2 = mysqli_fetch_array($getprevlink)){
    $prevpagelink = $row2[0];
  }

//SELECT RANDOM LINK FROM AS3TABLE, IF AVAILABLE    
$result = mysqli_query($conn,"SELECT link FROM as3table WHERE available = 'yes' ORDER BY RAND() LIMIT 1");
  //IF THERE IS A RESULT
  if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
      $nextpage = $row['link'];
    }
      
    //REMOVES LINK FROM NEXT SELECTION ABOVE
    $removenext = mysqli_query($conn,"UPDATE as3table SET available = 'no' WHERE link = '$nextpage'");
      
  }
  //IF THERE IS NO RESULT
  else{
    $getnextlink = mysqli_query($conn,"select link FROM prevtable WHERE id = (select min(id) FROM prevtable WHERE id > $currentpageid ORDER BY id LIMIT 1 )");
      while($row3 = mysqli_fetch_array($getnextlink)){
        $nextpage = $row3['link'];
      }
  }

//Buttons Below v

  //IF COUNT SESSION WHICH WAS SET IN LOGIN.PHP PAGE, IS LESS THAN OR EQUAL TO 0, CURRENT AND NEXT BUTTONS DISPLAYED
  if ($_SESSION['count'] <=0) {
    echo '<button><a href="#">Current Page - ' . $currentPage . '</a> </button>';
    echo '<button name = "next" id = "next"> <a href="' . $nextpage . '?inc=TRUE"">Next Page - ' . $nextpage . '</a> </button>';
  }
                                
  //IF COUNT SESSION IS MORE THAN 0 AND LESS THAN 10, PREVIOUS, CURRENT AND NEXT BUTTONS DISPLAYED
  if (($_SESSION['count'] > 0) && ($_SESSION['count'] < 10 )) { 
    echo '<button name = "previous" id = "previous"> <a href="' . $prevpagelink . '?dec=TRUE" onclick="">Prev Page - ' . $prevpagelink . '</a>';
    echo '<button> <a href="#">Current Page - ' . $currentPage . '</a> </button>';
    echo '<button name = "next" id = "next"> <a href="' . $nextpage . '?inc=TRUE"">Next Page - ' . $nextpage . '</a> </button>';
  }

  //IF COUNT SESSION IS MORE THAN OR EQUAL TO 10, CURRENT AND PREVIOUS BUTTONS DISPLAYED
  if ($_SESSION['count'] >= 10) { 
    echo '<button name = "previous" id = "previous"> <a href="' . $prevpagelink . '?dec=TRUE" onclick="">Prev Page - ' . $prevpagelink . '</a>';
    echo '<button> <a href="#">Current Page - ' . $currentPage . '</a> </button>';
  }

//CLOSE CONNECTION
mysqli_close($conn);
?>
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>