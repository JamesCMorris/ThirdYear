<?php

//Only accessible from login submit button, otherwise send user to index//
if (isset($_POST['login-submit'])) {

//Gets database functions//
   require 'C:\xampp\htdocs\php\includes\dbh.php';

//Establishes username and password inputs as variables//
   $username = $_POST['username'];
   $password = $_POST['password'];

//Empty check//
   if (empty($username) || empty($password)) {
    header("Location:http://localhost/index.php?error=emptyfields");
     exit;
   }
//If not empty check database for username//
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
//Checks the row where username matches database and checks if password is the same//
       if ($row = mysqli_fetch_assoc($result)) {
         $pwdCheck = password_verify($password, $row['userPwd']);
         //If password doesn't match, return error//
         if ($pwdCheck == false) {
           header("Location:http://localhost/index.php?error=wrongpwd");
           exit;
         }
         //If password matches, start user session (Now signed in)//
         else if ($pwdCheck == true) {
          session_start();
          $_SESSION['userId'] = $row['userId'];
          $_SESSION['userName'] = $row['userName'];

          header("Location: http://localhost/my-profile.php?login=success");
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
