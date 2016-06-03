<!DOCTYPE html>
<?php
session_start();
include('connect.php');
?>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="bower_components/moment/min/moment-with-locales.min.js"></script>
  <script type="text/javascript" src="bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
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
          { ?>
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
      <div class="col-xs-4 col-xs-offset-3 login">
        <div class="panel panel-default panelbox">
          <div class="panel-body">
            <h3>Bokning</h3>

            <form method="get" action="tripfinder.php">
              <div class="form-group">
                <label for="sel1">Från</label>
                <select class="form-control" id="sel1" name="departureCity">

                <?php
                global $mysqli;
                $sql = "SELECT name FROM cities ORDER BY name asc";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                ?>
                            <option>
                            <?php
                            echo $row["name"]
                            ?>
                            </option>;
                <?php
                        }
                    } else {
                        echo "0 results";
                    }
                ?>

              </select>
              <!-- <?php echo $loginSession; ?> -->
              </div>

              <div class="form-group">
                <label for="sel1">Till</label>
                <select class="form-control" id="sel2" name="arrivalCity">

                    <?php
                    global $mysqli;
                    $sql = "SELECT name FROM cities ORDER BY name desc";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                    ?>
                                <option>
                                <?php
                                echo $row["name"]
                                ?>
                                </option>;
                    <?php
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>

              </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Vecka</label>
                  <select class="form-control" id="sel1" name="weekOfTrip">
                      <option>Välj vecka</option>
                    <?php
                    for ($i = 1; $i < 53; $i++) {
                      ?>
                      <option> <?php echo $i ?> </option>
                      <?php
                    }
                    ?>
                  </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Avgångstid</label>
                <div class='input-group date' id='datetimepicker1' name="dateOfTrip">
                  <input type='text' class="form-control" name="dateOfTrip"/>
                  <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Sök resa">
              <span class="error">
                  <?php
                  $noResults = "";
                  if(isset($_SESSION['noResults'])) {
                    $noResults = $_SESSION['noResults'];
                    unset($_SESSION['noResults']);
                  }
                  echo $noResults;
                  ?>
                  </span>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function() {
      $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD',
          locale: 'sv'
      });
    });
  </script>
</body>

</html>
