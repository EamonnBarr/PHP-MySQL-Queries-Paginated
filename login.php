<?php
// Start the session
include "session.php";
 
// Check session to see if the user is already logged in, then redirect to start page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: start.php");
    exit;
}
 
// Include config file with db connection
include "startconfig.php";
 
// Define variables
$username = "";
$password = "";
$username_error = "";
$password_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_error = "Enter Username Please.";
        
    } else{
        
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_error = "Enter Password Please.";
        
    } else{
        
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_error) && empty($password_error)){
        
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                // Store the statement result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    
                    if(mysqli_stmt_fetch($stmt)){
                        
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store in session variables, with log in check for next page
                            // Count set for next page also
                            $_SESSION['count'] = 0;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username; 
                            
                            
                            // Redirect user to start.php
                            header("location: start.php");
                            
                        } else{
                            
                            // Display an error message if password is not valid
                            $password_error = "This password is not valid, Please retry.";
                          }
                    }
                } else{
                    
                    // Display an error message if username doesn't exist
                    $username_error = "This Username does not exist.";
                }
            } else{
                
                echo "Something went wrong";
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
    <title>Login</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <style type="text/css">
        
        body{ font: 15px sans-serif; }
        
        .wrapper{ width: 400px; padding: 20px; }

    </style>
</head>
<body>
    <div class="wrapper">
        
        <h2>Login</h2>
        
        <p>Please log in.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_error)) ? 'Error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_error; ?></span>
            </div>    
            
            <div class="form-group <?php echo (!empty($password_error)) ? 'Error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_error; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
            <p>Don't have an account? <a href="register.php">Register Here</a>.</p>
            
        </form>
    </div>    
</body>
</html>