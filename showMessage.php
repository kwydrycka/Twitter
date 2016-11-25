<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mail Box: Message</title>
        <link rel="stylesheet"  type="text/css" href="css/style.css">      
    </head>
    <body>

<?php
    session_start();
     
    if(!isset($_SESSION['userId']) || $_SESSION['userId'] == -1){ 
        
        // przekierowanie do Login.php i zakonczenie dzialania skryptu
        header("Location: Login.php");
        exit();
    }
    
        //zabezpiecznie przed modyfikacjami adresu
    if (isset($_GET['id']) && is_numeric($_GET['id']) == true) {
        $_SESSION['messageId'] = (int) $_GET['id'];
    } else {
        header("Location: Index.php");
        exit();
    }
    
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    require_once 'src/Tweet.php';
    require_once 'src/Comment.php';
    require_once 'src/Message.php';
    require_once 'Header.php';
    
    $currentUser = User::loadUserById($connection, $_SESSION['userId']);
    printUserHeader($currentUser->getUserName() ,'Mail Box: Message');
    
    
    if (isset ($_SESSION['messageId'])) {
        $loadMessage = Message::loadMessageById($connection, $_SESSION['messageId']);
        if (isset($loadMessage) && ($loadMessage->getRecipientUserId() == $_SESSION['userId'] || 
                $loadMessage->getSenderUserId()== $_SESSION['userId'] )) {
            echo '<h3>Message:</h3>';
            echo'<table border = 0>';
     
            echo '<tr>';  
            echo '<td width = "15%">From: </td>';
            echo '<td width = "15%">To: </td>';
            echo '<td width = "15%">Date: </td>';
            echo '<td width = "50%">Text:</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>@'.trim($loadMessage->getSenderUserName()).'</td>';
            echo '<td>@'.trim($loadMessage->getRecipientUserName()).'</td>';
            echo '<td>'.trim($loadMessage->getCreationDate()).'</td>';
            echo '<td>'.$loadMessage->getText().'</td>';
            echo '</tr>';
            echo '<tr><td colspan = "4">&nbsp</td></tr>';
            echo'</table>';
            
            if (!$loadMessage->getIsRead() && $loadMessage->getRecipientUserId()==$_SESSION['userId']) {
                $loadMessage->saveToDB($connection);
            }
        }
    }
  echo '<a href=MailBox.php>[Return to MailBox] </a>';
      
    
$connection->close();
$connection = null;

?>
</body>
</html>