<?php
// Include config file with db connection
include "startconfig.php";

// Initialize Variables
$username = "";
$password = "";
$password_confirm = "";
$username_errors = "";
$password_errors = "";
$password_confirm_errors = "";
 
// Processing form data
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Username Validation
    if(empty(trim($_POST["username"]))){
        $username_errors = "Please enter a username.";
        
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // prepared statement
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_errors = "Username already exists.";
                    
                } else{
                    $username = trim($_POST["username"]);
                }
                
            } else{
                
                echo "Something went wrong.";
                
              }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(!empty($_POST["password"]) && ($_POST["password"] == $_POST["confirm_password"])) {
    $password = ($_POST["password"]);
    $password_confirm = ($_POST["confirm_password"]);
      if (strlen($_POST["password"]) <= '8') {
          
        $password_errors = "Your Password Must Contain At Least 8 Characters!";
          
      }
      elseif(!preg_match("#[0-9]+#",$password)) {
          
        $password_errors = "Your Password Must Contain At Least 1 Number!";
          
      }
      elseif(!preg_match("#[A-Z]+#",$password)) {
          
        $password_errors = "Your Password Must Contain At Least 1 Capital Letter!";
          
      }
      elseif(!preg_match("#[a-z]+#",$password)) {
          
        $password_errors = "Your Password Must Contain At Least 1 Lowercase Letter!";
          
      }
    }
    
elseif(!empty($_POST["password"])) {
    $password_confirm = "Please Check You've Entered Or Confirmed Your Password!";
} else {
     $password_errors = "Please enter password   ";
  }
    
    // Check If there are any errors
    if(empty($username_errors) && empty($password_errors) && empty($password_confirm_errors)){
        
        // Insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // prepared statement
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt prepared statement, then redirect to login
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        
        body{ font: 15px sans-serif; }
        
        .wrapper{ width: 400px; padding: 20px; }
        
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        
        <p>Please fill this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_errors)) ? 'Error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_errors; ?></span>
            </div>    
            
            <div class="form-group <?php echo (!empty($password_errors)) ? 'Error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_errors; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($password_confirm_errors)) ? 'Error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $password_confirm; ?>">
                <span class="help-block"><?php echo $password_confirm_errors; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            
            <p>Already Registered? <a href="login.php">Then Login here</a>.</p>
            
        </form>
    </div>    
</body>
</html>