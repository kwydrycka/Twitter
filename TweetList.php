<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Tweets</title>
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
    printUserHeader($currentUser->getUserName() ,'User Tweets');
    
        //zabezpiecznie przed modyfikacjami adresu
    if (isset($_GET['userTweetId']) && is_numeric($_GET['userTweetId']) == true) {
        $_SESSION['userTweetId'] = (int) $_GET['userTweetId'];
    } else {
        header("Location: Index.php");
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['message']) && strlen(trim($_POST['message']))>0 &&
            isset($_SESSION['userTweetId'])) {

            $message = $_POST['message'];

            $newMessage = new Message();
            $newMessage->setSenderUserId($_SESSION['userId']);
            $newMessage->setRecipientUserId($_SESSION['userTweetId']);
            $newMessage->setText($message);
            $newMessage->setCreationDate(date('Y-m-d H:i:s'));

                if($newMessage->saveToDB($connection)) {
                    echo "Your message to ".User::loadUserById($connection,$_SESSION['userTweetId'])->getUserName()." has been sent...<br>";
                    $connection->close();
                    $connection = null;
                    header ('Refresh:1; url=TweetList.php?userTweetId='.$_SESSION['userTweetId']);
                    unset ($_SESSION['userTweetId']);
                    exit();
                } else {
                     echo "<span class= error>Error</span><br>";
                }  
        }
    }    
 ?>
  
    <form method="POST" action="#">
            <textarea name="message" cols="40" rows="4" placeholder="Insert your Message"></textarea><br>
            <input type="submit" name="submit" value="Send Message"/><br><br>
    </form>
<?php

$loadUserTweets = Tweet::loadAllTweetsByUserId($connection, $_SESSION['userTweetId']);

echo '<div>';
echo'<table border = 0>';

foreach ($loadUserTweets as $userTweet) {
    echo '<tr>';
    echo '<th width = "10%" align = "left">'.'@'.'<a href=TweetList.php?userTweetId='.trim($userTweet->getUserId()).'>'.trim($userTweet->getUserName()).'</a></th>';
    echo '<th width = "40%" align = "left">'.trim($userTweet->getCreationDate()).'</th>';
    echo '<th width = "50%"></th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td width = "10%">&nbsp</td>';
    echo '<td width = "40%"><i>'.$userTweet->getText().'</i></td>';
    echo '<td width = "50%" align = "left"><a href=AddComment.php?tweetId='. $userTweet->getId() .'> See '.count(Comment::loadAllCommentsByTweetId($connection,$userTweet->getId())).' comments...<a\></td>';
    echo '</tr>';
    echo '<tr><td colspan = "3">&nbsp</td></tr>';
  
}
echo'</table>';
echo '</div>';

$connection->close();
$connection = null;

?>