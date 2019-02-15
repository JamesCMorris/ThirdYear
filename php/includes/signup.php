<?php

  include_once 'php/includes/dbh.php';

  $sql = "INSERT INTO members (username, fullname, postcode, email, position,
    password) VALUES ('James', 'Morris', 'postcde', 'email@email.com', 'MB',
      'password');";
    mysqli_query($conn, $sql);

    header("Location: ../index,php?signup=success");









 ?>
