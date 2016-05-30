<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

$mysqli = new mysqli("localhost", "root", "", "busproject");
// $mysqli = new mysqli("localhost", "csgofree_kemkoi", "srslyno123", "csgofree_busproject");

/* check mysqliection */
if ($mysqli->connect_errno)
{
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
else
{
    //printf("Access granted: %s\n", $mysqli->connect_error);
}

?>
