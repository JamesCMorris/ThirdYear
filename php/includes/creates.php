<?php
//Only accessable through the create club submit button//
  if (isset($_POST['club-submit'])) {

//Gets functions to connect to database//
    require 'C:\xampp\htdocs\php\includes\dbh.php';

//Assigns inputs to variables that can be called later in script//
    $clubname = $_POST['clubname'];
    $clubaddress = $_POST['clubaddress'];
    $clubcity = $_POST['clubcity'];
    $clubcontact = $_POST['clubcontact'];
    $clubphone = $_POST['clubphone'];
    $clubemail = $_POST['clubemail'];
    $clubwebpage = $_POST['clubwebpage'];
    $clubcoaches = $_POST['clubcoaches'];
    $clubnotes = $_POST['clubnotes'];

//Checks if fields are empty, if they are then returns user//
    if (empty($clubname) || empty($clubaddress) || empty($clubcity) || empty($clubcontact) || empty($clubphone) || empty($clubemail)) {
      header("Location:http://localhost/browse.php?error=emptyfields&clubname=".$clubname."&clubaddress=".$clubaddress."&clubcity=".$clubcity."&clubcontact=".$clubcontact."&clubphone=".$clubphone."&clubemail=".$clubemail);
      exit();
    }
//Checks if email submitted is a valid email (Contains @)//
    elseif (!filter_var($clubemail, FILTER_VALIDATE_EMAIL)) {
      header("Location:http://localhost/browse.php?error=invalidemail&clubname=".$clubname."&clubaddress=".$clubaddress."&clubcity=".$clubcity."&clubcontact=".$clubcontact."&clubphone=".$clubphone);
      exit();
    }
    else {

//SQL query with prepared statements//
      $sql = "SELECT club_name FROM clubs WHERE club_name=?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:http://localhost/browse.php?error=sqlerror");
        exit();
      }
//Assigns the '?' value in the above query to the $clubname variable input//
      else {
        mysqli_stmt_bind_param($stmt, "s", $clubname);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultsCheck = mysqli_stmt_num_rows($stmt);
//If result of query is not 0, return user to page//
        if ($resultsCheck > 0) {
          header("Location:http://localhost/browse.php?error=clubnametaken&clubaddress=".$clubaddress."&clubcity=".$clubcity."&clubcontact=".$clubcontact."&clubphone=".$clubphone."&clubemail=".$clubemail);
          exit();
        }
//If result of query is 0, insert data of club into the database//
        else {
          $sql = "INSERT INTO clubs(club_name, club_address, club_city, club_contact, club_phone, club_email, club_webpage, club_coaches, club_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                   $stmt = mysqli_stmt_init($conn);
                   if (!mysqli_stmt_prepare($stmt, $sql)) {
                     header("Location:http://localhost/browse.php?error=sqlerrorinsert");
                     exit();
                   }
                   else {
                     mysqli_stmt_bind_param($stmt, "sssssssss", $clubname, $clubaddress, $clubcity, $clubcontact, $clubphone, $clubemail, $clubwebpage, $clubcoaches, $clubnotes);
                     mysqli_stmt_execute($stmt);

                    header("Location:http://localhost/browse.php?create=success");
                    exit();

                }
        }
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else {
    header("Location:http://localhost/index.php");
    exit();
  }
?>
