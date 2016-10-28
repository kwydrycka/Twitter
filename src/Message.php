<?php

class Message {
    private $messageId;
    private $text;
    private $isRead;
    private $creationDate;
    private $senderUserId;
    private $recipientUserId;
    private $senderUserName;
    private $recipientUserName;
    
    public function __construct() {
        $this->messageId = -1;
        $this->text = "";
        $this->isRead = 0;
        $this->senderUserId = "";
        $this->recipientUserId = "";
        $this->creationDate = "";
    }
   
    public function setSenderUserId($newSenderUserId) {
        $this->senderUserId = $newSenderUserId;
    }
    
    public function setRecipientUserId($newRecipientUserId) {
        $this->recipientUserId = $newRecipientUserId;
    }
    public function setText($newText) {
        $this->text = $newText;
    }
    
    public function setIsRead($newIsRead) {
        $this->isRead = $newIsRead;
    }
    public function setCreationDate($newDate) {
        $this->creationDate = $newDate;
    }
    public function getId() {
        return $this->messageId;
    }
    
    public function getSenderUserId() {
        return $this->senderUserId;
    }
    
    public function getRecipientUserId() {
        return $this->recipientUserId;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getIsRead() {
        return $this->isRead;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function getSenderUserName() {
        return $this->senderUserName;
    } 
    
    public function getRecipientUserName() {
        return $this->recipientUserName;
    }
    
      
    
    static public function loadMessageById(mysqli $connection, $id) {
        $sql = "SELECT m.*, urecipient.userName as recipientName, usender.userName as senderName
                FROM Messages as m
                JOIN Users as urecipient ON m.recipientUserId = urecipient.id
                JOIN Users as usender ON m.senderUserId = usender.id
                WHERE m.messageId=$id";
        $result = $connection->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedMessages = new Message();
            $loadedMessages->messageId = $row['messageId'];
            $loadedMessages->senderUserId = $row['senderUserId'];
            $loadedMessages->recipientUserId = $row['recipientUserId'];
            $loadedMessages->senderUserName = $row['senderName'];
            $loadedMessages->recipientUserName = $row['recipientName'];
            $loadedMessages->text= $row['text'];
            $loadedMessages->isRead= $row['isRead'];
            $loadedMessages->creationDate= $row['creationDate'];
            return $loadedMessages;
        }
        return null;
    }
    
    
    static public function getMessagesBySenderUserId(mysqli $connection, $senderUserId) {
        
        $sql = "SELECT Messages.messageId,recipientUserId,text,isRead,creationDate,userName 
                FROM Messages Join Users ON
                Users.userId = Messages.recipientUserId
                where senderUserId = $senderUserId ORDER BY creationDate DESC";
        
        $ret = [];
        $result = $connection->query($sql);
        
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedSenderMessages = new Message();
                $loadedSenderMessages->messageId = $row['messageId'];
                $loadedSenderMessages->recipientUserId = $row['recipientUserId'];
                $loadedSenderMessages->text= $row['text'];
                $loadedSenderMessages->isRead= $row['isRead'];
                $loadedSenderMessages->creationDate= $row['creationDate'];
                $loadedSenderMessages->recipientUserName= $row['userName'];
                $ret[] = $loadedSenderMessages;
            }
        }   
        return $ret;
    }
    
    static public function getMessagesByRecipientUserId(mysqli $connection, $recipientUserId) {
        
        $sql = "SELECT Messages.messageId,senderUserId,userName,text,isRead,creationDate 
                FROM Messages Join Users ON
                Users.userId = Messages.senderUserId
                where recipientUserId =$recipientUserId ORDER BY creationDate DESC";
        
        $ret = [];
        $result = $connection->query($sql);
        
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedRecipientMessages = new Message();
                $loadedRecipientMessages->messageId = $row['messageId'];
                $loadedRecipientMessages->senderUserId = $row['senderUserId'];
                $loadedRecipientMessages->text= $row['text'];
                $loadedRecipientMessages->isRead= $row['isRead'];
                $loadedRecipientMessages->creationDate= $row['creationDate'];
                $loadedRecipientMessages->senderUserName= $row['userName'];
                $ret[] = $loadedRecipientMessages;
            }
        }   
        return $ret;
    }
    
    
    /*
      Saving new comment to DB
     * 
     */
    public function saveToDB(mysqli $connection) {
        if ($this->messageId == -1) {
            $sql = "INSERT INTO Messages (senderUserId, recipientUserId, isRead, text, creationDate)
                  VALUES ('$this->senderUserId','$this->recipientUserId', $this->isRead, '$this->text', '$this->creationDate')";
            
            $result = $connection->query($sql);
            if ($result == true) {
                $this->messageId = $connection->insert_id;
                return true;
            } 
        } else {
            $sql = "UPDATE Messages SET isRead = 1
                    WHERE messageId=$this->messageId";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }
}