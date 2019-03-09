<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "login-system";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
  die("Connection to database failed: ".mysqli_connect_error());
}

?>
