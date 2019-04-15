<?php

//Establishes connection to database//
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "login-system";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

//If connection fails, show error message//
if (!$conn) {
  die("Connection to database failed: ".mysqli_connect_error());
}

?>
