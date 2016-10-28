<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter Registration</title>
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
        if(isset($_SESSION['userId']) && $_SESSION['userId'] != -1){       
            // przekierowanie do Index.php i zakonczenie dzialania skryptu
            header("Location: Index.php");
        exit();
        }
        
        require_once 'src/Connection.php';
        require_once 'src/User.php';
  
        
        echo '<a href="Login.php">[Go to Login Page]</a><br/>';
        echo '<h3 align = "center">Twitter Registration</h3>';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validation = true;

            if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) &&
                    isset($_POST['password2'])) {
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $password2 = trim($_POST['password2']);

                //Zapamiętaj wprowadzone dane
                $_SESSION['sv_username'] = $username;
                $_SESSION['sv_email'] = $email;
                $_SESSION['sv_password'] = $password;
                $_SESSION['sv_password2'] = $password2;

                if (strlen(trim($username)) > 0 && strlen(trim($email)) > 0 && strlen(trim($password)) > 0 &&
                        strlen(trim($password2)) > 0) {


                    if (ctype_alnum($username) == false) {
                        $validation = false;
                        $_SESSION['e_username'] = "A username can only contain alphanumeric characters";
                    }

                    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
                    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
                        $validation = false;
                        $_SESSION['e_email'] = "E-mail is incorrect";
                    }

                    if ($validation == true) {
                        $id = User::checkUserPasswordGetId($connection, $email, $password);
                        if ($id != -1) {
                            $validation = false;
                            $_SESSION['e_email'] = "This email already exist";
                        }
                    }

                    //Sprawdź poprawność hasła
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];

                    if ((strlen($password) < 3) || (strlen($password) > 14)) {
                        $validation = false;
                        $_SESSION['e_password'] = "Password length of 4 to 14 characters";
                    }

                    if ($password != $password2) {
                        $validation = false;
                        $_SESSION['e_password'] = "Passwords are not identical";
                    }

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    //walidacja przeszla pomyslnie

                    if ($validation == TRUE) {

                        $newUser = new User();
                        $newUser->setUserName($username);
                        $newUser->setEmail($email);
                        $newUser->setPassword($password);

                        if ($newUser->saveToDB($connection)) {
                            echo "<b>" . $newUser->getUserName() . "</b>, you have been registered! <br>";
                            echo "Your login is: <b>" . $newUser->getEmail() . " </b><br>";
                            //echo "Now, you can go to Login Page :)";
                           
                            $connection->close();
                            $connection = null;

                            unset($_SESSION['sv_username']);
                            unset($_SESSION['sv_email']);
                            unset($_SESSION['sv_password']);
                            unset($_SESSION['sv_password2']);
                            
                            //przekierowanie po 2 sekundach na main page
                            $_SESSION['userId'] =$newUser->getId();
                            header('Refresh:2; url =Index.php');
                            exit();
                        }
                    }
                } else {
                    echo '<span class = error>Please, provide all the data.</span><br><br>';
                }
            }
        }


        $connection->close();
        $connection = null;
 ?>

        <form method="POST">
            <label>Enter user name:</label><br>
            <input name="username" type="text" maxlength="255" value="<?php
        if (isset($_SESSION['sv_username'])) {
            echo $_SESSION['sv_username'];
            unset($_SESSION['sv_username']);
        }
        ?>"/><br>
                   <?php
                   if (isset($_SESSION['e_username'])) {
                       echo '<div class="error">' . $_SESSION['e_username'] . '</div>';
                       unset($_SESSION['e_username']);
                   }
                   ?>
            <label>Enter email:</label><br>
            <input name="email" type="text" maxlength="255" value="<?php
                   if (isset($_SESSION['sv_email'])) {
                       echo $_SESSION['sv_email'];
                       unset($_SESSION['sv_email']);
                   }
                   ?>"/><br>
                   <?php
                   if (isset($_SESSION['e_email'])) {
                       echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                       unset($_SESSION['e_email']);
                   }
                   ?>
            <label>Enter password:</label><br>
            <input name="password" type="password" maxlength="255" value="<?php
                   if (isset($_SESSION['sv_password'])) {
                       echo $_SESSION['sv_password'];
                       unset($_SESSION['sv_password']);
                   }
                   ?>"/><br>
                   <?php
                   if (isset($_SESSION['e_password'])) {
                       echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
                       unset($_SESSION['e_password']);
                   }
                   ?>
            <label>Re-enter password for verification:</label><br>
            <input name="password2" type="password" maxlength="255" value="<?php
                   if (isset($_SESSION['sv_password2'])) {
                       echo $_SESSION['sv_password2'];
                       unset($_SESSION['sv_password2']);
                   }
                   ?>"/><br><br>
            <input type="submit" name="submit" value="Register"><br><br>
        </form>

    </body>
</html>