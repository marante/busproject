<?php
  session_start();
  ini_set("display_errors", true);
  error_reporting( E_ALL );
  include('connect.php');


  if(isset($_POST['submit'])) {

  global $mysqli;

  if(isset($_SESSION['resultArray'])) {
      $result = $_SESSION['resultArray'];
  }

  if(isset($_SESSION['email'])) {
      $loginSession = $_SESSION['email'];
  }

  $sqlEmail = ("SELECT person_id
        FROM persons
        WHERE email = ? ");

        if ($stmt = $mysqli->prepare($sqlEmail)) {
          $stmt->bind_param('s', $loginSession);
          $stmt->bind_result($personID);
          $stmt->execute();
          //FETCH ALL VALUES FROM STATEMENT
          while ($stmt->fetch()) {
          }
          $stmt->store_result();
          $countRows = $stmt->num_rows;
          $stmt->close();
        } else if ($countRows < 1) {
          $_SESSION['personIDError'] = "Bokningen kunde inte utföras, du är inte inloggad!";
          header("Location:foundBookings.php");
          exit();
        } else if ($stmt === FALSE) {
            die ("Mysql Error: " . $mysqli->error);
        }

        $sqlTripID = ("SELECT trips.trip_id
            	FROM trips
            	INNER JOIN arrivals
            	ON arrivals.trip_id = trips.trip_id
            	INNER JOIN departures
            	ON arrivals.trip_id = departures.trip_id
            	INNER JOIN cities AS c1
            	ON departures.city_id = c1.city_id
              INNER JOIN cities AS c2
              ON arrivals.city_id = c2.city_id
            	WHERE c1.name = ?
            	AND c2.name = ?
            	AND trips.depart_time = ?
            	GROUP BY c1.name");

        if($stmt = $mysqli->prepare($sqlTripID)) {
          foreach ( $result as $var ) {
            $fromCity = $var['fromCity'];
            $toCity = $var['toCity'];
            $fromDate = $var['depart_time'];
          }

          $stmt->bind_param('sss', $fromCity, $toCity, $fromDate);
          $stmt->bind_result($tripID);
          $stmt->execute();
          //FETCH ALL VALUES
          while ($stmt->fetch()) {
          }
          $stmt->store_result();
          $countRows = $stmt->num_rows;
          $stmt->close();
        } else if ($stmt === FALSE) {
            die ("Mysql Error: " . $mysqli->error);
        }

        $currentTime = date('Y-m-d', time());

  $sqlBooking = ("INSERT INTO bookings(booking_date, trip_id, person_id)
        VALUES(?, ?, ?)");

        if ($stmt = $mysqli->prepare($sqlBooking)) {
          $stmt->bind_param('sss', $currentTime, $tripID, $personID);
          $stmt->execute();
          $stmt->close();

          echo ("<script type='text/javascript'>
          window.location = 'foundBookings.php';
          window.alert('Din bokning är genomförd, tack för att du använder Blomstermåla Buss!');
          </script>");
         exit();
        } else if ($stmt === FALSE) {
          echo ("<script type='text/javascript'>
          window.location = 'confirmBooking.php';
          window.alert('Din bokning är genomförd, tack för att du använder Blomstermåla Buss!');
          </script>");
         exit();
        }


$mysqli->close();
}

?>
