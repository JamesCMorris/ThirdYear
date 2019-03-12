<?php

  require 'PHPMailer/PHPMailerAutoload.php';

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $subject = $_POST['subject'];
  $emailFrom = $_POST['email'];
  $message = $_POST['message'];

  $mail = new PHPMailer();
  $mail->Host = "smtp.gmail.com";
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Username = "volleyhubhelp@gmail.com";
  $mail->Password = "finalproject";
  $mail->SMTPSecure = "ssl";
  $mail->Port = 465;
  $mail->IsHTML(true);

  $mail->setFrom($emailFrom, $_POST['name']);
  $mail->addAddress('volleyhubhelp@gmail.com');
  $mail->addReplyTo($_POST['email'], $_POST['name']);

  $mail->Subject = 'User issue: ' . $_POST['subject'];
  $mail->Body = "You have received a support ticket from " . $_POST['name'] . ".\n\n" . $_POST['message'];

  if (!$mail->send()) {
    echo "Error occured in sending support email.";
  } else {
    echo "Email successfully sent!";
  }


  //$mailTo = "james1232morris@gmail.com";
  //$headers = "From: ". $mailFrom;
  //$txt = "You have received a support ticket from ".$name.".\n\n".$message;




  header("Location: http://localhost/index.php?mailsend");
}
?>
