<?php
$servername = 'localhost';
$usernameDB = 'root';
$passwordDB = 'CodersLab';
$basename = 'twitterDB';

// wyciszenie komunikatow poprzez @
$connection = @new mysqli($servername, $usernameDB, $passwordDB, $basename);

if($connection->connect_error) {
    
// dla bezpieczenstwa podaje jedynie numer bledu
    
    die("Connection failed: $connection->connect_errno");
}

?>