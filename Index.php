<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Main Page</title>
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
    require_once 'Header.php';
 

    $currentUser = User::loadUserById($connection, $_SESSION['userId']);
    printUserHeader($currentUser->getUserName() ,'Twitter Main Page');
   
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['tweet']) && strlen(trim($_POST['tweet']))>0) {

            $tweet = substr($_POST['tweet'],0,139);

            $newTweet = new Tweet();
            $newTweet->setUserId($_SESSION['userId']);
            $newTweet->setText($tweet);
            $newTweet->setCreationDate(date('Y-m-d H:i:s'));

                if($newTweet->saveToDB($connection)) {
                    $connection->close();
                    $connection = null;
                    echo "Your tweet has been added...<br>";
                    header ('Refresh:1; url=Index.php');
                    exit();
                } else {
                     echo "<span class= error>Error</span><br>";
                }  
        }
    }   
?>
    
<br/>
    <form method="POST" action="#">
            <textarea name="tweet" cols="40" rows="4" placeholder="Insert your tweet (max. 140 characters)"></textarea><br>
            <input type="submit" name="submit" value="Add New Tweet"/><br><br>
    </form>
    

<?php

$loadAllTweets = Tweet::loadAllTweets($connection);

echo '<div>';
echo'<table border = 0>';

foreach ($loadAllTweets as $tweet) {
    echo '<tr>';
    echo '<th width = "10%" align = "left">'.'@'.'<a href=TweetList.php?userTweetId='.trim($tweet->getUserId()).'>'.trim($tweet->getUserName()).'</a></th>';
    echo '<th width = "40%" align = "left">'.trim($tweet->getCreationDate()).'</th>';
    echo '<th width = "50%"></th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td width = "10%">&nbsp</td>';
    echo '<td width = "40%"><i>'.$tweet->getText().'</i></td>';
    echo '<td width = "50%" align = "left"><a href=AddComment.php?tweetId='. $tweet->getId() .'>See comments...<a\></td>';
    echo '</tr>';
    echo '<tr><td colspan = "3">&nbsp</td></tr>';
  
}
echo'</table>';
echo '</div>';

$connection->close();
$connection = null;

?>
    </body>
</html>
