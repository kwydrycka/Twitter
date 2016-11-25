<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Login Page</title>
        <link rel="stylesheet"  type="text/css" href="css/style.css">     
    </head>
    <body>
        
<?php
    session_start();
    if(isset($_SESSION['userId']) && $_SESSION['userId'] != -1){       
        
        // przekierowanie do Index.php i zakonczenie dzialania skryptu
        header("Location: Index.php");
        exit();
    }
     
    require_once 'src/Connection.php';
    require_once 'src/User.php';
   
    echo '<h3 align = "center">Twitter Login Page</h3>';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if(strlen(trim($_POST['email']))>0 && strlen(trim($_POST['password']))>0) {
                $email = trim($_POST['email']);
                $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
                $password = trim($_POST['password']);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==true) && ($emailB == $email)) {
	
                    $id = User::checkUserPasswordGetId($connection, $email, $password);

                    if ($id!= -1) {
                        $_SESSION['userId'] = $id; 
                        header('Location: Index.php');
                        exit();
                    }  
                }
            }
        }
        echo '<span class=error>Invalid email or password.</span><br><br>';
    }

    $connection->close();
    $connection = null;
	

?>	
	<form action="Login.php" method="POST">
	    
            Email:    <br/> 
                      <input type="text" name="email"/> <br/>
            Password: <br/> 
                      <input type="password" name="password"/> <br/><br/>
		      <input type="submit" value="Login" />
	</form>
        <br />
        If you are a new user you have to register on <a href="Registration.php">Registration page</a>

    </body>
</html>
         


        