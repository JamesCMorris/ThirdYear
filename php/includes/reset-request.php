<?php

if (isset($_POST["submit-reset-request"])) {
//Establishes selector and token random variables//
  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);

//Url to be sent to the user to reset password//
  $url = "http://localhost/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

//Expiration date for link (1 hour from creation)//
  $expires = date("U") + 3600;

  require 'C:\xampp\htdocs\php\includes\dbh.php';

  $userEmail = $_POST["email"];

  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was a problem connecting to database!";
    exit();
  } else {
     mysqli_stmt_bind_param($stmt, "s", $userEmail);
     mysqli_stmt_execute($stmt);
  }

//Insert reset data into database//
  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was a problem connecting to database!";
    exit();
  } else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
     mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
     mysqli_stmt_execute($stmt);
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);


  require 'PHPMailer\PHPMailerAutoload.php';

//PHPMailer functions//
  $to = $userEmail;

  $mail = new PHPMailer();
  $mail->Host = "smtp.gmail.com";
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Username = "volleyhubhelp@gmail.com";
  $mail->Password = "finalproject";
  $mail->SMTPSecure = "ssl";
  $mail->Port = 465;
  $mail->Subject = "Reset your password for VolleyHUB";
  $mail->Body = "We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this request. The link will expire within an hour.

                Here is your password reset link: $url ";
  $mail->setFrom('volleyhubhelp@gmail.com', 'VH');
  $mail->addAddress($to);
  if (!$mail->send()) {
    echo "Something wrong";
  } else {
    echo "Email sent";
  }

  header("Location: http://localhost/password-reset.php?reset=success");

} else {
  header("Location: http://localhost/index.php");
}
