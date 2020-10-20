<?php
// Initialize the session


include "session.php";
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php"); 
    exit();
}

else{
    //Logged in
    echo "Successfully logged in!";
}



$path =  $_SERVER['PHP_SELF'];
$filenameExt = basename($path);// "start.php"


//$_SESSION["count"] = 0;
$currentPage = $filenameExt;
$nextPage;
$prevPage;

$PHPFiles = array(); 
$PHPFilesPrevious = array(); 

$PHPFiles[] = 'sql1.php';
$PHPFiles[] = 'sql2.php';
$PHPFiles[] = 'sql3.php';
$PHPFiles[] = 'sql4.php';
$PHPFiles[] = 'sql5_1.php';
$PHPFiles[] = 'sql6.php';
$PHPFiles[] = 'sql7.php';
$PHPFiles[] = 'sql8.php';
$PHPFiles[] = 'sql9.php';   
$PHPFiles[] = 'sql10.php';      


$nextPage=$PHPFiles[rand(0, count($PHPFiles)-1)]; 

$prevPage=$currentPage; 
 
$thePrev=$filenameExt; 

array_push($PHPFilesPrevious, $prevPage); 

unset($PHPFiles[$nextPage]);

$prevPage=array_pop($PHPFilesPrevious);
$myprevpage = array_pop($PHPFilesPrevious);

array_push($PHPFiles, $prevPage);

function push($PHPFiles, $currentPage, $nextPage) {

  array_push($PHPFiles, $currentPage);
  unset($PHPFiles[$nextPage]); 
}

if(isset($_POST['next'])) {
echo $nextPage;
echo $prevPage;
    
}

if(isset($_GET['dec'])) { 
    if($_SESSION['count'] > 0){// decreasing
     --$_SESSION['count'];
      echo --$_SESSION['count'];
        }
}






$message = $myprevpage;

if ($_SESSION['count'] <=0) {
echo '<button><a href="#">Current Page - ' . $currentPage . '</a> </button>';


echo '<button name = "next" id = "next"> <a href="' . $nextPage . '?theprev=' . $thePrev . '"">Next Page - ' . $nextPage . '</a> </button>'; } else
if ($_SESSION['count'] < 10) {
    echo '<button name = "next" id = "previous"> <a href="' . $passedPrev . '?dec=TRUE" onclick="">Prev Page - ' . $passedPrev . '</a>';
echo '<button> <a href="#">Current Page - ' . $currentPage . '</a> </button>';
echo '<button name = "next" id = "next"> <a href="' . $nextPage . '?theprev=' . $thePrev . '"">Next Page - ' . $nextPage . '</a> </button>';
} else {
echo '<button> <a href="' . $passedPrev . '?dec=TRUE" onclick="" class="">Previous</a></button>';
echo '<button> <a href="#">Current Page - ' . $currentPage . '</a> </button>';

    }
    ?> 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

    <p>
       <br/> <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <?php echo $message; ?>
    </p>
</body>
</html>