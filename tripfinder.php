<?php
session_start();

ini_set("display_errors", true);
error_reporting( E_ALL );

include("connect.php");

if(isset($_GET['submit'])) {

    global $mysqli;
    $fromCity = $_GET['departureCity'];
    $toCity = $_GET['arrivalCity'];
    $date = $_GET['dateOfTrip'];

    $fromCityID = 0;
    $toCityID = 0;

    $sqlFromCityID = ("SELECT DISTINCT city_id FROM cities
                    WHERE name = '$fromCity'");

                    if ($stmt = $mysqli->prepare($sqlFromCityID)) {

                            $stmt->bind_result($fromCityID);
                            $stmt->execute();
                            /* Fetching results */
                            while ($stmt->fetch()) {
                            }
                            $stmt->close();
                        }
                        if ($stmt === FALSE) {
                            die ("Mysql Error: " . $mysqli->error);
                                }

    $sqlToCityID = ("SELECT DISTINCT city_id FROM cities
                    WHERE name = '$toCity'");

                    if ($stmt = $mysqli->prepare($sqlToCityID)) {

                            $stmt->bind_result($toCityID);
                            $stmt->execute();
                            /* Fetching results */
                            while ($stmt->fetch()) {
                            }
                            $stmt->close();
                        }
                        if ($stmt === FALSE) {
                            die ("Mysql Error: " . $mysqli->error);
                                }

    $sql = ("SELECT c1.name, c2.name, trips.depart_time, trips.arrival_time, trips.max_passengers,
                    trips.current_passengers
        	FROM trips
        	INNER JOIN arrivals
        	ON arrivals.trip_id = trips.trip_id
        	INNER JOIN departures
        	ON arrivals.trip_id = departures.trip_id
        	INNER JOIN cities AS c1
        	ON departures.city_id = c1.city_id
            INNER JOIN cities AS c2
            ON arrivals.city_id = c2.city_id
        	WHERE departures.city_id = ?
        	AND arrivals.city_id = ?
        	AND trips.depart_time = ?
        	GROUP BY c1.name");


            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('sss', $fromCityID, $toCityID, $date);

                $stmt->bind_result($ans['fromCity'], $ans['toCity'],
                                    $ans['depart_time'], $ans['arrival_time'],
                                    $ans['max_passengers'], $ans['current_passengers']);

                $stmt->execute();
                $stmt->store_result();
                $countRows = $stmt->num_rows;
                if ($countRows > 0) {
                    for ($col=0; $col < $countRows; $col++) {
                        $stmt->data_seek($col);
                        $stmt->fetch();
                        foreach ($ans as $key => $value) {
                            $result[$col][$key] = $value;
                        }
                    }
                        $_SESSION['resultArray'] = $result;
                        header("Location:foundBookings.php");
                        $stmt->close();

                    }

                    else if ($countRows < 1) {
                        $_SESSION['noResults'] = "Inga avgångar vid angiven tid";
                        header("Location:book.php");
                        exit();
                    }

                    else if ($stmt === FALSE) {
                        die ("Mysql Error: " . $mysqli->error);
                        }
                }

        $mysqli->close();

    }

?>
