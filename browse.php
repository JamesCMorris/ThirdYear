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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    (function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

		var _input;

		function _onInputEvent(e) {
			_input = e.target;
			var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filter);
				});
			});
		}

		function _filter(row) {
			var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('light-table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = _onInputEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

})(document);

    </script>
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
            echo "<h2>Browse Active Club Details!</h2>";
            echo '<p class="login-status">You are logged in as ' . $_SESSION['userName'] . '!</p>';
            echo '<a href="create-club.php"><h3>Want to make a new club? Click here!</h3></a>';

            $result = mysqli_query($conn, "SELECT club_name, club_address, club_contact, club_email, club_coaches, club_notes FROM clubs");
            echo "Browse the information of all clubs below: </br></br>";
            echo "<input type=\"search\" class=\"light-table-filter\" data-table=\"order-table\" placeholder=\"Search Clubs..\"> </br></br>";
            echo "<table class=\"order-table\" id=\"myTable\">";
            echo "<thead>";
            echo "  <tr>";
            echo "    <th>Club Name</th>";
            echo "    <th>Club Address</th>";
            echo "    <th>Club Contact</th>";
            echo "    <th>Club Email</th>";
            echo "    <th>Club Coaches</th>";
            echo "    <th>Club Biography</th>";
            echo "  </tr>";
            echo "</thead>";

                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tbody>";
                      echo "<tr>";
                      echo "<td>" . $row['club_name'] . "</td>";
                      echo "<td>" . $row['club_address'] . "</td>";
                      echo "<td>" . $row['club_contact'] . "</td>";
                      echo "<td>" . $row['club_email'] . "</td>";
                      echo "<td>" . $row['club_coaches'] . "</td>";
                      echo "<td>" . $row['club_notes'] . "</td>";
                      echo "</tr>";
                      echo "</tbody>";
                    }
                    echo "</table>";
                    mysqli_close($conn);
          }
          else {
            echo "<h2>Welcome to VolleyHUB!</h2></br>";
            echo '<p class="login-status">You must be logged in to view your clubs!</p>';
          }
         ?>
      </section>
      <div class="club-create">

      </div>
    </div>

    <footer>
    </footer>


  <script src="js/master.js"></script>
</body>
