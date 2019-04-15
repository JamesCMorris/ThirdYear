<?php
//Only accessible from the reset password submit button//
  if (isset($_POST["reset-password-submit"])) {

//Establishes variables//
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

//Empty check//
      if (empty($selector) || empty($validator)) {
        header("Location: http://localhost/create-new-password.php?newpwd=empty");
        exit();
        //Check if password and repeated password are the same//
      } elseif ($password != $passwordRepeat) {
        header("Location: http://localhost/create-new-password.php?newpwd=nomatch");
        exit();
      }
//Creates the current date as variable U so timeout on email link can be established//
      $currentDate = date("U");

//Gets database functions//
      require 'C:\xampp\htdocs\php\includes\dbh.php';

//SQL query for the reset password database to store validator and selector and token//
      $sql = "SELECT * FROM `pwdreset` WHERE `pwdResetSelector`= ? AND `pwdResetExpires` >= ?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was a problem connecting to database!";
        exit();
      } else {
         mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
         mysqli_stmt_execute($stmt);

         $result = mysqli_stmt_get_result($stmt);
         if (!$row = mysqli_fetch_assoc($result)) {
           echo "You must re-submit your password reset request!";
           exit();
         } else {

           $tokenBin = hex2bin($validator);
           $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

           if ($tokenCheck === false) {
             echo "You need to re-submit your password reset request!";
             exit();
           } elseif ($tokenCheck === true) {

             $tokenEmail = $row["pwdResetEmail"];

             $sql = "SELECT * FROM users WHERE email=?;";
             $stmt = mysqli_stmt_init($conn);
             if (!mysqli_stmt_prepare($stmt, $sql)) {
               echo "There was a problem connecting to database!";
               exit();
             } else {
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (!$row = mysqli_fetch_assoc($result)) {
                  echo "You have to re-submit your password reset request!";
                  exit();
                } else {

                  $sql = "UPDATE users SET userPwd=? WHERE email=?;";
                  $stmt = mysqli_stmt_init($conn);
                  if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was a problem connecting to database!";
                    exit();
                  } else {
                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                     mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                     mysqli_stmt_execute($stmt);

                     $sql= "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                     $stmt = mysqli_stmt_init($conn);
                     if (!mysqli_stmt_prepare($stmt, $sql)) {
                       echo "There was a problem connecting to the database!";
                       exit();
                     } else {
                       mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                       mysqli_stmt_execute($stmt);
                       header("Location: http://localhost/sign-in.php?newpwd=passwordupdated");
                     }

             }
           }


         }
      }

}
}

  } else {
    header("Location: http://localhost/index.php");
  }
