<?php

class Comment {

    private $commentId;
    private $userId;
    private $tweetId;
    private $text;
    private $creationDate;
    private $userName;
    
    
    public function __construct() {

        $this->commentId = -1;
        $this->userId = "";
        $this->tweetId = "";
        $this->text = "";
        $this->creationDate = "";
        $this->userName = "";
    }
    
    
    public function setUserId($newUserId) {
        $this->userId = $newUserId;
    }
    
    public function setTweetId($newTweetId) {
        $this->tweetId = $newTweetId;
    }

    public function setText($newText) {
        $this->text = $newText;
    }

    public function setCreationDate($newDate) {
        $this->creationDate = $newDate;
    }
    
    public function setUserName($newUserName) {
        $this->userName = $newUserName;
    }

    public function getId() {
        return $this->commentId;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getTweetId() {
        return $this->tweetId;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function getUserName() {
        return $this->userName;
    }
    
  
    
       static public function loadCommentById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Comment WHERE commentId=$id";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedComment = new Comment();
            $loadedComment->commentId = $row['commentId'];
            $loadedComment->userId = $row['userId'];
            $loadedComment->tweetId = $row['tweetId'];
            $loadedComment->text= $row['text'];
            $loadedComment->creationDate= $row['creationDate'];

            return $loadedComment;
        }

        return null;
    }
    
    
    static public function loadAllCommentsByTweetId(mysqli $connection, $tweetId) {

        $sql = "SELECT Comment.*, Users.userName "
                . "FROM Comment JOIN Users ON Comment.userId=Users.userId "
                . "WHERE tweetId=$tweetId "
                . "ORDER BY creationDate DESC";
        $ret = [];
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComments = new Comment();
                $loadedComments->commentId = $row['commentId'];
                $loadedComments->userId = $row['userId'];
                $loadedComments->tweetId = $row['tweetId'];
                $loadedComments->text= $row['text'];
                $loadedComments->creationDate= $row['creationDate'];
                $loadedComments->userName= $row['userName'];
                $ret[] = $loadedComments;
            }
        }   
        return $ret;
    }
    
    
    public function saveToDB(mysqli $connection) {
        if ($this->commentId == -1) {

            $sql = "INSERT INTO Comment (userId,tweetId, text, creationDate)
                  VALUES ('$this->userId','$this->tweetId', '$this->text', '$this->creationDate')";
            $result = $connection->query($sql);

            if ($result == true) {
                $this->commentId = $connection->insert_id;
                return true;
            } 
        } else {
            $sql = "UPDATE Comment "
                    . "SET text='$this->text', creationDate='$this->creationDate' "
                    . "WHERE commentId=$this->commentId";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }
}