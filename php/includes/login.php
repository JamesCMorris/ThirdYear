<?php

if (isset($_POST['login-submit'])) {

   require 'C:\xampp\htdocs\php\includes\dbh.php';

   $username = $_POST['username'];
   $password = $_POST['password'];

   if (empty($username) || empty($password)) {
    header("Location:http://localhost/index.php?error=emptyfields");
     exit;
   }
   else {
     $sql = "SELECT * FROM users WHERE userName=? OR email=?;";
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
       header("Location:http://localhost/index.php?error=sqlerror");
       exit;
     }
     else {

       mysqli_stmt_bind_param($stmt, "ss", $username, $email);
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       if ($row = mysqli_fetch_assoc($result)) {
         $pwdCheck = password_verify($password, $row['userPwd']);
         if ($pwdCheck == false) {
           header("Location:http://localhost/index.php?error=wrongpwd");
           exit;
         }
         else if ($pwdCheck == true) {
          session_start();
          $_SESSION['userId'] = $row['userId'];
          $_SESSION['userName'] = $row['userName'];

          header("Location: http://localhost/index.php?login=success");
          exit;
         }
         else {
           header("Location:http://localhost/index.php?error=wrongpwd");
           exit;
         }
       }
       else {
         header("Location:http://localhost/index.php?error=nouser");
         exit;
       }
     }
   }

}
else {
  header("Location: http://localhost/index.php");
  exit;
}
 ?>
