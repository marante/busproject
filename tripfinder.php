<?php

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

    $sql = ("SELECT depart_time, arrival_time, max_passengers, current_passengers
            FROM trips
            INNER JOIN arrivals
            ON arrivals.trip_id = trips.trip_id
            INNER JOIN departures
            ON arrivals.trip_id = departures.trip_id
            INNER JOIN cities
            ON departures.city_id = cities.city_id
            WHERE departures.city_id = '$fromCityID'
            AND arrivals.city_id = '$toCityID'
            AND trips.depart_time = '$date'
            GROUP BY trips.trip_id");

            if ($stmt = $mysqli->prepare($sql)) {

                $stmt->bind_result($depart_time, $arrival_time,
                                    $max_passengers, $current_passengers);

                $stmt->execute();

                while ($stmt->fetch()) {
                    printf ("%s, %s, %s, %s\n", $depart_time, $arrival_time,
                                    $max_passengers, $current_passengers);
                }
                    $stmt->close();
                }

                if ($stmt === FALSE) {
                    die ("Mysql Error: " . $mysqli->error);
                        }

        $mysqli->close();

    }

?>
