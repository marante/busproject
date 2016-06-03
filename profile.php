<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

include('connect.php');

session_start();
global $mysqli;
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
        <li><a href="profile.php">Profil</a></li>
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

    <div class="container">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-4 login">
          <div class="panel panel-default panelbox">
            <div class="panel-body">
              <h3 class="center">Profil</h3>

                <?php
                global $mysqli;

                $email = $_SESSION['email'];

                $sql = ("SELECT firstname, lastname, pnumber, age, email
                         FROM persons
                         WHERE email = ? ");

                         if ($stmt = $mysqli->prepare($sql)) {

                             $stmt->bind_param('s', $email);
                             $stmt->execute();
                             $stmt->bind_result($firstname, $lastname, $pnumber, $age, $email);
                             while($stmt->fetch()) {
                             }
                             $stmt->close();
                         }
                         else if ($stmt === FALSE) {
                             die ("Mysql Error: " . $mysqli->error);
                             }

                        if(isset($_POST['update'])) {
                            $varFirstname = $_POST['firstname'];
                            $varLastname = $_POST['lastname'];
                            $varPnumber = $_POST['pnumber'];
                            $varAge = $_POST['age'];

                            $updateSql = ("UPDATE persons SET firstname = ?,
                                           lastname = ?, pnumber = ?,
                                           age = ?
                                           WHERE firstname = ?
                                           AND
                                           lastname = ?
                                           AND
                                           pnumber = ?
                                           AND
                                           age = ?");

                           if ($stmt = $mysqli->prepare($updateSql)) {
                               $stmt->bind_param('ssssssss', $varFirstname, $varLastname,
                                                 $varPnumber, $varAge, $firstname, $lastname,
                                                    $pnumber, $age);
                               $stmt->execute();
                               $stmt->close();
                               echo ("<script type='text/javascript'>
                               window.alert('Din profil är uppdaterad!');
                               window.location = 'profile.php';
                               </script>");
                           }
                           else if ($stmt === FALSE) {
                               die ("Mysql Error: " . $mysqli->error);
                               }
                           }


                         ?>
                         <form method="post" action="<?php $_PHP_SELF ?>">
                           <div class="form-group">
                               <label for="sel1">Förnamn</label>
                                <input type="text" class="form-control" name ="firstname" id="firstname" placeholder="<?php echo $firstname ?> ">
                              </div>
                              <div class="form-group">
                                <label for="sel2">Efternamn</label>
                                <input type="text" class="form-control" name ="lastname" id="lastname" placeholder="<?php echo $lastname ?> ">
                              </div>
                              <div class="form-group">
                                <label for="sel3">Personnummer</label>
                                <input type="text" class="form-control" name ="pnumber" id="pnumber" placeholder="<?php echo $pnumber ?> ">
                              </div>
                              <div class="form-group">
                                <label for="sel4">Ålder</label>
                                <input type="text" class="form-control" name ="age" id="age" placeholder="<?php echo $age ?> ">
                              </div>
                              <input name = "update" type = "submit" id = "update" value = "Update" class="btn btn-default">
                            </form>

                  </table>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
