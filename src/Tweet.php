<?php


class Tweet {

    private $tweetId;
    private $text;
    private $creationDate;
    private $userId;
    private $userName;

    public function __construct() {
        $this->tweetId = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }


    public function getId() {
        return $this->tweetId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserId($newUserId) {
        $this->userId = $newUserId;
    }

    public function setText($newText) {
        $this->text = $newText;
    }

    public function setCreationDate($newDate) {
        $this->creationDate = $newDate;
    }

    static public function loadTweetById(mysqli $connection, $id) {
        
        $sql = "SELECT Tweet.*, Users.userName "
                . "FROM Tweet, Users "
                . "WHERE Tweet.userId = Users.userId AND Tweet.tweetId=$id";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->tweetId = $row['tweetId'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];
            $loadedTweet->userName = $row['userName'];
            return $loadedTweet;
        }
        return null;
    }

    static public function loadAllTweetsByUserId(mysqli $connection, $userId) {
        $sql = "SELECT Tweet.*, Users.userName"
                . " FROM Tweet, Users"
                . " WHERE Tweet.userId = Users.userId AND Tweet.userId=$userId"
                . " ORDER BY creationDate DESC";
        $ret = [];
        $result = $connection->query($sql);
     
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweets = new Tweet();
                $loadedTweets->tweetId = $row['tweetId'];
                $loadedTweets->userId = $row['userId'];
                $loadedTweets->text = $row['text'];
                $loadedTweets->creationDate = $row['creationDate'];
                $loadedTweets->userName = $row['userName'];
                $ret[] = $loadedTweets;
            }
        }
        return $ret;
    }

    static public function loadAllTweets(mysqli $connection) {
        $sql = "SELECT Tweet.*, Users.userName "
                . "FROM Tweet, Users "
                . "WHERE Tweet.userId = Users.userId "
                . "ORDER BY creationDate DESC";
        $ret = [];
        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweets = new Tweet();
                $loadedTweets->tweetId = $row['tweetId'];
                $loadedTweets->userId = $row['userId'];
                $loadedTweets->text = $row['text'];
                $loadedTweets->creationDate = $row['creationDate'];
                $loadedTweets->userName = $row['userName'];
                $ret[] = $loadedTweets;
            }
        }
        return $ret;
    }


    public function saveToDB(mysqli $connection) {
        if ($this->tweetId == -1) {
            $sql = "INSERT INTO Tweet (userId, text, creationDate)
                  VALUES ('$this->userId', '$this->text', '$this->creationDate')";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->tweetId = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Tweet "
                    . "SET text='$this->text', creationDate='$this->creationDate' "
                    . "WHERE tweetId=$this->tweetId";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }
    
    public function delete(mysqli $connection) {
        if ($this->tweetId != -1) {
            $sql = "DELETE FROM Tweet WHERE tweetId=$this->tweetId";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->tweetId = -1; //usunelismy obiekt z bazy
                return true;
            }
            return false;
        }
        return true;
    }

}
