<?php
session_start();
  include_once 'C:\xampp\htdocs\php\includes\dbh.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VolleyHUB</title>
    <link rel="stylesheet" href="/css/master.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="/tabledit/jquery.tabledit.js"></script>
    <script type="text/javascript" src="/js/custom-table-edit.js"></script>
</head>

<body>
  <body>
    <header>
      <div class="wrapper-head">
        <a href="index.php"><img src="images/logo.png" alt="VolleyHUB Logo" class="logo"></a>
          <div class="menu" id="menu-toggle">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
          </div>

          <nav id="menu-nav">
              <a href="index.php">Homepage</a>
              <a href="browse.php">Browse</a>
              <a href="my-profile.php">My Profile</a>
              <a href="my-schedule.php">My Schedule</a>
              <a href="contact.php">Contact Us</a>
              <a href="sign-in.php">Sign In</a>
          </nav>
        </div>
      </header>

      <div class="sidebar">
        <div class="sidebar">
          <?php
            if (isset($_SESSION['userId'])) {
              echo '<h2>Log Out</h2>
              <form class="logout" action="/php/includes/logout.php" method="post">
                  <button type="submit" class="submitbutton" name="logout-submit">Log Out</button>
              </form>';
            }
            else {
              echo '<h2>Sign Up Here!</h2>
              <button onclick="document.getElementById(\'signupblock\').style.display=\'block\'" style="width: auto;">Sign Up</button>
              <div id="signupblock" class="signup">
                <span onclick="document.getElementById(\'signupblock\').style.display=\'none\'" class="close" title="Close Signup">&times;</span>

                <form class="signup-content" action="/php/includes/signup.php" method="POST">
                  <div class="container-signup">
                    <h1>VolleyHUB Sign Up</h1>
                    <p>Please submit your details here.</p>
                    <hr>
                    <label for="username"><b>Username</b></label>
                    <input type="text" name="username" placeholder="Username" required>
                    </br>
                    <label for="fullname"><b>Full Name</b></label>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                    </br>
                    <label for="postcode"><b>Postcode</b></label>
                    <input type="text" name="postcode" placeholder="Postcode" required>
                    </br>
                    <label for="email"><b>Email</b></label>
                    <input type="text" name="email" placeholder="Email Address" required>
                    </br>
                    <label for="position"><b>Position</b></label>
                    <input type="text" name="position" placeholder="Position" required>
                    </br>
                    <label for="pwd"><b>Password</b></label>
                    <input type="password" name="pwd" placeholder="Password" required>
                    </br>
                    <label for="repeatpwd"><b>Repeat Password</b></label>
                    <input type="password" name="pwd-repeat" placeholder="Repeat Password" required>
                    </br>
                    <label>
                      <input type="checkbox" name="rememberuser" checked="checked" style="margin-bottom:15px">
                      Remember Me!
                    </label>

                    <p> By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Conditions</a>.</p>

                    <div class="clearfix">
                      <button type="button" onclick="document.getElementById(\'signupblock\').style.display=\'none\'" class="cancelbutton">Cancel</button>
                      <button type="submit" name="signup-submit" class="submitbutton">Signup</button>
                    </div>
                  </div>
                </form>

              </div>';
            }
           ?>
        </div>
      </div>

      <div class="main-content">
        <section>
          <?php
            if (isset($_SESSION['userId'])) {
              echo "<h2>Your Profile Page!</h2>";
              echo '<p class="login-status">You are logged in as ' . $_SESSION['userName'] . '!</p>';

              $sql = "SELECT userName, fullName, postCode, email, position FROM users WHERE userId = '" . $_SESSION['userId'] . "'";
              $result = mysqli_query($conn, $sql);



              echo "<table id=\"myTable\">";

              while ($row = mysqli_fetch_array($result)) {
                echo "<tr><th>Your Username: </th><td>" . $row['userName'] . "</td></tr>
                      <tr><th>Your Full Name: </th><td>" . $row['fullName'] . "</td></tr>
                      <tr><th>Your Post Code: </th><td>" . $row['postCode'] . "</td></tr>
                      <tr><th>Your Contact Email: </th><td>" . $row['email'] . "</td></tr>
                      <tr><th>Your Court Position: </th><td>" . $row['position'] . "</td></tr>";
              }
              echo "</table></br>";

            }
            else {
              echo "<h2>Welcome to VolleyHUB!</h2></br>";
              echo '<p class="login-status">You must be logged in to view your profile!</p>';
            }
           ?>
        </section>
      </div>

      <footer>
      </footer>


  <script src="js/master.js"></script>
</body>
