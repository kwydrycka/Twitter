<?php
  session_start();
    
  /* usuniecie wszystkich zmiennych sesyjnych */
    
  session_unset();
  
  /* przekierowanie do strony logowania */
  header('Location: Login.php');
       
?>