<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

session_start();
?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <title>Välkommen till reseföretaget</title>
  </head>

  <body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-inverse">
      <ul class="nav navbar-nav">
        <a id="logo" href="index.php"><img src="images/logo1.png" /></a>
        <li><a href="book.php">Boka</a></li>
        <li><a href="#">Resemål</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="pright"><a href="#">
            <?php if(isset($_SESSION['email']))
            {
            ?>
            <form method="post" action="logout.php">
                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Logga ut">
            </form>
            <?php
            } else {
                echo "Inte inloggad";
            } ?></a></li>
      </ul>
    </nav>

    <!-- Main page -->
    <!-- Top part -->
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-0">
          <div class="transbox">
            <h2>Välkommen till Blomstermåla Buss. </h2>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras porta varius tincidunt. Donec varius purus id rutrum fermentum. Nunc vel erat posuere sapien vehicula maximus interdum sed purus. Proin commodo libero sit amet orci semper elementum. Ut ornare
              neque enim, quis cursus turpis laoreet eu. Vestibulum id orci ornare, porttitor ex vel, dapibus metus. Cras in dui magna.
            </p>
          </div>
        </div>

        <div class="col-xs-4 col-xs-offset-1 login">
          <div class="panel panel-default panelbox">
            <div class="panel-body">
              <h3>Logga in </h3>

              <form method="post" action="login.php">
                <div class="form-group">
                  <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Lösenord">
                </div>
                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Logga in">
              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- Bottom part -->
      <div class="row">
        <div class="col-xs-6 col-xs-offset-0">
          <div class="transbox">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras porta varius tincidunt. Donec varius purus id rutrum fermentum. Nunc vel erat posuere sapien vehicula maximus interdum sed purus. Proin commodo libero sit amet orci semper elementum. Ut ornare
              neque enim, quis cursus turpis laoreet eu. Vestibulum id orci ornare, porttitor ex vel, dapibus metus. Cras in dui magna.
            </p>
          </div>
        </div>
        <div class="col-xs-4 col-xs-offset-1 register">
          <div class="panel panel-default panelbox">
            <div class="panel-body">
              <h3>Registrera dig</h3>
              <form role="form" method="POST" action="register.php">
                <div class="form-group">
                  <input type="text" id="firstname" class="form-control" name="firstname" placeholder="Förnamn">
                  <span class="error">
              <?php
              $fnameError = "";
              $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
              if(isset($_SESSION['fnameError'])) {
                $fnameError = $_SESSION['fnameError'];
                unset($_SESSION['fnameError']);
              }
              echo $fnameError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Efternamn">
                  <span class="error">
              <?php
              $lnameError = "";
              if(isset($_SESSION['lnameError'])) {
                $lnameError = $_SESSION['lnameError'];
                unset($_SESSION['lnameError']);
              }
              echo $lnameError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="email" id="email" class="form-control" name="email" placeholder="Email">
                  <span class="error">
              <?php
              $emailError = "";
              if(isset($_SESSION['emailError'])) {
                $emailError = $_SESSION['emailError'];
                unset($_SESSION['emailError']);
              }
              echo $emailError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control" name="password" placeholder="Lösenord">
                  <span class="error">
              <?php
              $passwordError = "";
              if(isset($_SESSION['passwordError'])) {
                $passwordError = $_SESSION['passwordError'];
                unset($_SESSION['passwordError']);
              }
              echo $passwordError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="number" id="pnumber" class="form-control" name="pnumber" placeholder="Personnummer">
                  <span class="error">
              <?php
              $pnumberError = "";
              if(isset($_SESSION['pnumberError'])) {
                $pnumberError = $_SESSION['pnumberError'];
                unset($_SESSION['pnumberError']);
              }
              echo $pnumberError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="number" id="age" class="form-control" name="age" placeholder="Ålder">
                  <span class="error">
              <?php
              $ageError = "";
              if(isset($_SESSION['ageError'])) {
                $ageError = $_SESSION['ageError'];
                unset($_SESSION['ageError']);
              }
              echo $ageError;
              ?>
              </span>
                </div>
                <div class="form-group">
                  <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Submit">
                  <br />
                  <span class="<?php echo $_SESSION['message'] ?>">
              <?php
              $emailExistsError = "";
              $accountCreated = "";
              if(isset($_SESSION['emailExistsError'])) {
                $emailExistsError = $_SESSION['emailExistsError'];
                unset($_SESSION['emailExistsError']);
              }
              if(isset($_SESSION['accountCreated'])) {

                $accountCreated = $_SESSION['accountCreated'];
                unset($_SESSION['accountCreated']);
              }
              echo $accountCreated;
              echo $emailExistsError;
              ?>
              </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>
