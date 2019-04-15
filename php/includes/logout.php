<?php
//Stops session when user presses log out button//
  session_start();
  session_unset();
  session_destroy();
  header("Location: http://localhost/index.php");
 ?>
