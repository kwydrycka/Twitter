<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Add Comment</title>
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
    require_once 'Header.php';
    
    $currentUser = User::loadUserById($connection, $_SESSION['userId']);
    printUserHeader($currentUser->getUserName() ,'Twitter Add Comment');
   
    //zabezpiecznie przed modyfikacjami adresu
    if (isset($_GET['tweetId']) && is_numeric($_GET['tweetId']) == true) {
        $_SESSION['tweetId'] = (int) $_GET['tweetId'];
    } else {
        header("Location: Index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['comment']) && strlen(trim($_POST['comment']))>0 && isset($_SESSION['tweetId'])) {

            $comment = substr($_POST['comment'],0,59);
            //$tweetId = $_SESSION['tweetId'];

            $newComment = new Comment();
            $newComment->setUserId($_SESSION['userId']);
            $newComment->setTweetId($_SESSION['tweetId']);
            $newComment->setText($comment);
            $newComment->setCreationDate(date('Y-m-d H:i:s'));

                if($newComment->saveToDB($connection)) {
                    echo "Your comment has been added...<br>";
                    $connection->close();
                    $connection = null;
                    header ('Refresh:1; url=AddComment.php?tweetId='.$_SESSION['tweetId']);
                    unset ($_SESSION['tweetId']);
                    exit();
                } else {
                     echo "<span class= error>Error</span><br>";
                }  
        }
    }
  ?>
  
    <form method="POST" action="#">
            <textarea name="comment" cols="40" rows="4" placeholder="Insert your Comment (max. 60 characters)"></textarea><br>
            <input type="submit" name="submit" value="Add New Comment"/><br><br>
    </form>
        
  <?php
   
    $loadTweet = Tweet::loadTweetById($connection, $_SESSION['tweetId']);

     echo'<table border = 0>';
         echo'<table border = 0';
         echo '<tr>';
         echo '<td colspan="3" align = "left"><b>Tweet:</b></td>';
         echo '</tr>';
         echo '<tr>';
         echo '<th width = "10%" align = "left">'.'@'.'<a href=TweetList.php?userTweetId='.trim($loadTweet->getUserId()).'>'.trim($loadTweet->getUserName()).'</a></th>';
         echo '<th width = "40%" align = "left">'.trim($loadTweet->getCreationDate()).'</th>';
         echo '<th width = "50%"></th>';
         echo '</tr>';
         echo '<tr>';
         echo '<td width = "10%">&nbsp</td>';
         echo '<td width = "40%"><i>'.$loadTweet->getText().'</i></td>';
        // echo '<td width = "50%" align = "left"><a href=AddComment.php?tweetId='. $loadTweet->getId() .'>Add comment...<a\></td>';
         echo '</tr>';
         echo '<tr><td colspan = "2">&nbsp</td></tr>';
         
    echo'</table>';
    
    $loadAllComments = Comment::loadAllCommentsByTweetId($connection, $_SESSION['tweetId']);
    
    echo'<table border = 0';
    echo '<tr>';
    echo '<td width = "20%"></td>';
    echo '<td colspan="2" align = "left"><b>Comments:</b></td>';
    echo '</tr>';
    foreach ($loadAllComments as $comment) {
        echo '<tr>';
        echo '<td width = "20%"></td>';
        echo '<td width = "10%" align = "left">'.'@'.'<a href=TweetList.php?userTweetId='.trim($comment->getUserId()).'>'.trim($comment->getUserName()).'</a></td>';
        echo '<td width = "40%" align = "left"><b>'.trim($comment->getCreationDate()).'</b></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width = "20%"></td>';
        echo '<td width = "10%">&nbsp</td>';
        echo '<td width = "40%">'.$comment->getText().'</td>';
        echo '</tr>';
        echo '<tr><td colspan = "3">&nbsp</td></tr>';
    }
    echo'</table>';
    
    $connection->close();
    $connection = null;
    
?>
    

    
