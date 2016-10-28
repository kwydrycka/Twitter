<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mail Box</title>
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
        echo '<tr>';
        echo '<td width = "30%" align = "left">Received from: @'.trim($message->getSenderUserName()).'</td>';
        echo '<td width = "20%" align = "left">'.trim($message->getCreationDate()).'</td>';
        echo '<td width = "50%">Text:</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan = "2"></td>';
        echo '<td width = "50%">'.$message->getText().'</td>';
        echo '</tr>';
        echo '<tr><td colspan = "3">&nbsp</td></tr>';
  
    }
    echo'</table>';
    
    $loadSent = Message::getMessagesBySenderUserId($connection, $_SESSION['userId']);
    echo '<h3>Sent Message:</h3>';
        echo'<table border = 0>';

    foreach ($loadSent as $message) {
        echo '<tr>';
        echo '<td width = "30%" align = "left">Sent to: @'.trim($message->getRecipientUserName()).'</td>';
        echo '<td width = "20%" align = "left">'.trim($message->getCreationDate()).'</td>';
        echo '<td width = "50%">Text:</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan = "2"></td>';      
        echo '<td width = "50%">'.$message->getText().'</td>';
        echo '</tr>';
        echo '<tr><td colspan = "3">&nbsp</td></tr>';
  
    }
    echo'</table>';