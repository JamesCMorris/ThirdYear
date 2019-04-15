<?php
  //Gets the PHPMailer for the email functions//
  require 'PHPMailer/PHPMailerAutoload.php';

//Only allows access to this page by clicking the submit button on the contact form//
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $subject = $_POST['subject'];
  $emailFrom = $_POST['email'];
  $message = $_POST['message'];

//PHPMailer functions assign values and set security of emails//
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

//Formatting of the email//
  $mail->Subject = 'User issue: ' . $_POST['subject'];
  $mail->Body = "You have received a support ticket from " . $_POST['name'] . " at " . $_POST['email'] . " :
   " . $_POST['message'];

//If the email doesn't send correctly (If email is not correct) then display message, otherwise display success//
  if (!$mail->send()) {
    echo "Error occured in sending support email.";
  } else {
    echo "Email successfully sent!";
  }
  header("Location: http://localhost/contact.php?mailsend=success");
}
?>
