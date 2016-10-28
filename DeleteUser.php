<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Remove Account</title>
    </head>
    <body>
<?php
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] == -1){ 
        
// przekierowanie do Login.php i zakonczenie dzialania skryptu
    header("Location: Login.php");
    exit();
}

require_once 'Header.php';
require_once 'src/User.php';
require_once 'src/Connection.php';

$currentUser = User::loadUserById($connection, $_SESSION['userId']);
printUserHeader($currentUser->getUserName() ,'Twitter Remove Account');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['remove'])) {
    if ($currentUser->delete($connection)) {
        $connection->close();
        $connection->null;
        session_unset();
        echo "Your account has been removed...<br/>";
        echo "Goodbye :)<br/>";
        header ('Refresh:2; url=Login.php');
        exit();
    } else {
        echo "Problem with removing account. Please, contact your adminstrator.";
    }
}

$connection->close();
$connection=null;
?>
        
     <h4>Are you sure you want to delete your account?</h4>
    <form method="POST" action = "#">
        <input type="button" name="cancel" value="Cancel" onclick="window.location='Index.php'" />
        <input type="submit" name="remove" value="Remove Account"/>
        </form>
     </body>
</html>
