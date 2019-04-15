<?php
session_start();
  include_once 'C:\xampp\htdocs\php\includes\dbh.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VolleyHUB</title>
  <link rel="stylesheet" href="/css/master.css">

</head>

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
              <input type="text" name="username" placeholder="Enter Username.." required>
              </br>
              <label for="fullname"><b>Full Name</b></label>
              <input type="text" name="fullname" placeholder="Enter Full Name.." required>
              </br>
              <label for="postcode"><b>Postcode</b></label>
              <input type="text" name="postcode" placeholder="Enter Postcode.." required>
              </br>
              <label for="email"><b>Email</b></label>
              <input type="text" name="email" placeholder="Enter Email Address.." required>
              </br>
              <label for="position"><b>Position</b></label>
              <input type="text" name="position" placeholder="Enter Court Position.." required>
              </br>
              <label for="pwd"><b>Password</b></label>
              <input type="password" name="pwd" placeholder="Password" required>
              </br>
              <label for="repeatpwd"><b>Repeat Password</b></label>
              <input type="password" name="pwd-repeat" placeholder="Repeat Password" required>
              </br>

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

  <div class="main-content">
    <section>
      <?php
        if (isset($_SESSION['userId'])) {
          echo '<p class="login-status">You are logged in as ' . $_SESSION['userName'] . '!</p>';echo "<h2>Welcome to VolleyHUB!</h2></br>";
          echo "<h3>VolleyHUB aims to be the number one place for volleyball players to organise themselves and search for local clubs and teams to play with. On this site, you will be able to create an secure and safe account, browse clubs on the site, add items to your own personal calendar to keep yourself up to date with training and game times.</h3></br>";
          echo "<p>If you spot a problem or a bug on the site, please don't hesistate to use the 'Contact Us' page on VolleyHUB to report it and we will fix the issue as soon as possible!</p>";
          echo "<p>Now that you've made an account, you are free to access all features of the website!</p>";
        }
        else {
          echo "<h2>Welcome to VolleyHUB!</h2></br>";
          echo '<p class="login-status">You are logged out!</p>';
          echo "<h3>VolleyHUB aims to be the number one place for volleyball players to organise themselves and search for local clubs and teams to play with. On this site, you will be able to create an secure and safe account, browse clubs on the site, add items to your own personal calendar to keep yourself up to date with training and game times.</h3></br>";
          echo "<p>If you spot a problem or a bug on the site, please don't hesistate to use the 'Contact Us' page on VolleyHUB to report it and we will fix the issue as soon as possible!</p>";
          echo "<h3>To make an account, use the 'Sign In' section of the website to log in!</h3></br>";
          if (isset($_GET["signup"])) {
            if ($_GET["signup"] == "success") {
            echo '</br></br></br></br><h3>Account successfully created! Please sign in to continue!<h3>';
            }
          }

        }
       ?>
    </section>
</div>
  <footer>

  </footer>

  <script src="js/master.js"></script>
</body>
