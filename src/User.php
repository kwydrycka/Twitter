<?php

/*
 * Class User:
 */

class User {

    private $userId;
    private $userName;
    private $hashedPassword;
    private $email;

    //User constructor

    public function __construct() {

        $this->userId = -1;
        $this->userName = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    /*
     * Set and Get methods:
     */

    public function setUserName($newName) {
        $this->userName = $newName;
    }

    public function setPassword($newPassword) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }

    public function getId() {
        return $this->userId;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function getEmail() {
        return $this->email;
    }

    /**
      Saving new user to DB
     * 
     */
    public function saveToDB(mysqli $connection) {
        if ($this->userId == -1) {
            $sql = "INSERT INTO Users(userName, email, hashedPassword)
                  VALUES ('$this->userName', '$this->email', '$this->hashedPassword')";
            $result = $connection->query($sql);

            if ($result == true) {
                $this->userId = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Users SET userName='$this->userName', email='$this->email',
                    hashedPassword='$this->hashedPassword' WHERE userId=$this->userId";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mysqli $connection
     * @param type $id
     * @return \User
     */
    static public function loadUserById(mysqli $connection, $userId) {

        $sql = "SELECT * FROM Users WHERE userId=$userId";
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->userId = $row['userId'];
            $loadedUser->userName = $row['userName'];
            $loadedUser->hashedPassword = $row['hashedPassword'];
            $loadedUser->email = $row['email'];

            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers(mysqli $connection) {

        $sql = "SELECT * FROM Users";
        $ret = [];
        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->userId = $row['userId'];
                $loadedUser->userName = $row['userName'];
                $loadedUser->hashedPassword = $row['hashedPassword'];
                $loadedUser->email = $row['email'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    static public function checkUserPasswordGetId(mysqli $connection, $email, $pass) {
        
        $email = htmlentities($email, ENT_QUOTES, "UTF-8");
	$result = @$connection->query(
		   sprintf("SELECT * FROM Users WHERE email='%s'",
		   mysqli_real_escape_string($connection,$email)));
       /* $query = "SELECT * FROM Users WHERE email = '$email'";
        $result = $connection->query($query);
        */
        if ($result == TRUE && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $hashedPassword = $row['hashedPassword'];

            if (password_verify($pass, $hashedPassword)) {
                $id = $row['userId'];
                return $id;
            }
        }
        return -1;
    }

    public function delete(mysqli $connection) {
        if ($this->userId != -1) {
            $sql = "DELETE FROM Users WHERE userId=$this->userId";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->userId = -1; //usunelismy obiekt z bazy
                return true;
            }
            return false;
        }
        return true;
    }

}

//CRUD - create, read, update, delete