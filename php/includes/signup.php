<?php
if (isset($_POST['signup-submit'])) {

  require 'C:\xampp\htdocs\php\includes\dbh.php';

//Establishes variables from inputs//
  $username = $_POST['username'];
  $fullname = $_POST['fullname'];
  $postcode = $_POST['postcode'];
  $email = $_POST['email'];
  $position = $_POST['position'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

//Validation for forms//
  if (empty($username) || empty($fullname) || empty($postcode) || empty($email) || empty($position) || empty($password) || empty($passwordRepeat)) {
    header("Location:http://localhost/index.php?error=emptyfields&username=".$username."&fullname=".$fullname."&postcode=".$postcode."&email=".$email."&position=".$position."&pwd=".$password."&pwd-repeat=".$passwordRepeat);
    exit;
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
  header("Location:http://localhost/index.php?error=invalidemailusername&fullname=".$fullname."&postcode=".$postcode."&position=".$position);
    exit;
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location:http://localhost/index.php?error=invalidemail&username=".$username."&fullname=".$fullname."&postcode=".$postcode."&position=".$position);
    exit;
  }
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location:http://localhost/index.php?error=invalidusername&fullname=".$fullname."&email=".$email."&postcode=".$postcode."&position=".$position);
    exit;
}
  else if ($password !== $passwordRepeat) {
    header("Location:http://localhost/index.php?error=passwordcheck&username=".$username."&fullname=".$fullname."&postcode=".$postcode."&position=".$position);
    exit;
  }
  else {

//Prepared statements for SQL queries//
    $sql = "SELECT userName FROM users WHERE userName=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location:http://localhost/index.php?error=sqlerror");
      exit;
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultsCheck = mysqli_stmt_num_rows($stmt);
      if ($resultsCheck > 0) {
        header("Location:http://localhost/index.php?error=usertaken&fullname=".$fullname."&postcode=".$postcode."&position=".$position);
        exit;
      }
      else {

//Insert into users database the user details//
        $sql = "INSERT INTO users (userName, fullName, postCode, email, position, userPwd) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location:http://localhost/index.php?error=sqlerrorinsert");
          exit;
        }
        else {
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          mysqli_stmt_bind_param($stmt, "ssssss", $username, $fullname, $postcode, $email, $position, $hashedPwd);
          mysqli_stmt_execute($stmt);
          header("Location: http://localhost/index.php?signup=success");
          exit;
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: http://http://localhost/index.php");
  exit;
}
?>
