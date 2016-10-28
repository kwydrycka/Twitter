<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Edit User</title>
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
<?php
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] == -1){ 
        
// przekierowanie do Login.php i zakonczenie dzialania skryptu
    header("Location: Login.php");
    exit();
}

require_once 'src/Connection.php';
require_once 'src/User.php';
require_once 'Header.php';
      
 $currentUser = User::loadUserById($connection, $_SESSION['userId']);
 printUserHeader($currentUser->getUserName() ,'Twitter Edit User');

$changes = false; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    if (isset ($_POST['changeusername']) && strlen(trim($_POST['changeusername']))>0)  {
        $username = $_POST ['changeusername'];
        if (ctype_alnum($username) == true) {
            $changes = true;
            $currentUser->setUserName($username);
        } else {
            $_SESSION['e_changeusername'] = " A username can only contain alphanumeric characters";
        }
    }
    
                        //Sprawdź poprawność hasła
    if (isset ($_POST['changepassword']) && strlen(trim($_POST['changepassword']))>0 &&
        isset ($_POST['changepassword2']) && strlen(trim($_POST['changepassword2']))>0) { 
                   
                    $password = $_POST['changepassword'];
                    $password2 = $_POST['changepassword2'];

                    if ((strlen($password) > 3) && (strlen($password) < 14) && $password == $password2  ) {
                        $changes = true;
                        $currentUser->setPassword($Password);
                    } else {
                        
                        $_SESSION['e_changepassword'] = " Password length of 4 to 14 characters. Passwords must be identical";
                    }
    }
    
    if ($changes) {
        if ($currentUser->saveToDB($connection) == true) {

           $connection->close();
           $connection = null;
           echo "...Data has been changed successfully...<br/><br/>";
           echo "<a href=Index.php>[Back to Main Page]</a>";
           header ('Refresh:2; url=Index.php');
           exit();
           
        } else {
           echo '<span class = "error">'.'Problem with updating user data'.'</span>'; 
        }
    }
}
    $connection->close();
    $connection = null;

?>
        
    <h4>Information: Leave blank input in case of no changes</h4>
    <form method="POST" action = "#">
        <label>Change your name:</label><br>
        <input name="changeusername" type="text" maxlength="255" value=""/>
                <?php
                   if (isset($_SESSION['e_changeusername'])) {
                       echo '<span class="error">' . $_SESSION['e_changeusername'] . '</span>';
                       unset($_SESSION['e_changeusername']);
                   }
                   ?><br>
        <label>Your new password:</label><br>
        <input name="changepassword" type="password" maxlength="255" value=""/>
                 <?php
                   if (isset($_SESSION['e_changepassword'])) {
                       echo '<span class="error">' . $_SESSION['e_changepassword'] . '</span>';
                       unset($_SESSION['e_changepassword']);
                   }
                   ?><br>
        <label>Re-type your new password:</label><br>
        <input name="changepassword2" type="password" maxlength="255" value=""/><br><br>
        <input type="button" name="cancel" value="Cancel" onclick="window.location='Index.php'" />
        <input type="submit" name="submit" value="Confirm changes"/>

    </form>
</body>
</html>