<?php

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $subject = $_POST['subject'];
  $emailFrom = $_POST['email'];
  $message = $_POST['message'];

  $mailTo = "james1232morris@gmail.com";
  $headers = "From: ". $mailFrom;
  $txt = "You have received a support ticket from ".$name.".\n\n".$message;



  mail($mailTo, $subject, $txt, $headers);
  header("Location: http://localhost/index.php?mailsend");
}
?>
