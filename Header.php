<?php

function printUserHeader ($userName,$pageName) {
    
    echo '<b>Welcome '.$userName. '! </b>'; 
    echo '<a href="Index.php">[Home]   </a>';
    echo '<a href=MailBox.php>[MailBox] </a>';
    echo '<a href=EditUser.php>[Edit Profile Data] </a>';
    echo '<a href=DeleteUser.php>[Remove Account] </a>';
    echo '<a href="Logout.php">[Logout] </a><br />';
    echo '<h3 align = "center">'.$pageName.'</h3>';
} 
 
?>    
