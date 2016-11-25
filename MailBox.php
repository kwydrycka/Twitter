<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mail Box</title>
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
    
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    require_once 'src/Tweet.php';
    require_once 'src/Comment.php';
    require_once 'src/Message.php';
    require_once 'Header.php';
    
    $currentUser = User::loadUserById($connection, $_SESSION['userId']);
    printUserHeader($currentUser->getUserName() ,'Mail Box');
    
    $loadReceived = Message::getMessagesByRecipientUserId($connection, $_SESSION['userId']);
    echo '<h3>Received Message:</h3>';
    echo'<table border = 0>';

    foreach ($loadReceived as $message) {
        
        if (!$message->getIsRead()) {
            $startB = '<b>';
            $unread = "<b>Unread</b>";
            $endB = '</b>';
        } else {
            $startB = '';
            $unread = '';
            $endB = '';   
        }
        
        $messageId = $message->getId();
        
        echo '<tr>';      
        echo '<td width = "5%">'.$unread.'</td>';
        echo '<td width = "15%" align = "left">'.$startB.'From: @'.trim($message->getSenderUserName()).$endB.'</td>';
        echo '<td width = "15%" align = "left">'.$startB.trim($message->getCreationDate()).$endB.'</td>';
        echo '<td width = "50%">'.$startB.'Text:'.$endB.'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan = "3"></td>';
        echo '<td width = "50%"><a href="showMessage.php?id='.$messageId.'">'.$startB.substr($message->getText(),0,29) .'...'.$endB.'</a></td>';
        echo '</tr>';
        echo '<tr><td colspan = "4">&nbsp</td></tr>';
  
    }
    echo'</table>';
    
    $loadSent = Message::getMessagesBySenderUserId($connection, $_SESSION['userId']);
    echo '<h3>Sent Message:</h3>';
        echo'<table border = 0>';

    foreach ($loadSent as $message) {
        if (!$message->getIsRead()) {
            $startB = '<b>';
            $unread = "<b>Unread</b>";
            $endB = '</b>';
        } else {
            $startB = '';
            $unread = '';
            $endB = '';
        }
        
        $messageId = $message->getId();
        
        echo '<tr>';
        echo '<td width = "5%">'.$unread.'</td>';
        echo '<td width = "15%" align = "left">'.$startB.'Sent to: @'.trim($message->getRecipientUserName()).$endB.'</td>';
        echo '<td width = "15%" align = "left">'.$startB.trim($message->getCreationDate()).$endB.'</td>';
        echo '<td width = "50%">'.$startB.'Text:'.$endB.'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan = "3"></td>';      
        echo '<td width = "50%"><a href="showMessage.php?id='.$messageId.'">'.$startB.substr($message->getText(),0,29).'...'.$endB.'</a></td>';
        echo '</tr>';
        echo '<tr><td colspan = "4">&nbsp</td></tr>';
  
    }
    echo'</table>';
    
    
$connection->close();
$connection = null;

?>
</body>
</html>