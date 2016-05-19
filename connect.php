<?php

$mysqli = new mysqli("localhost", "root", "", "busproject");

/* check mysqliection */
if ($mysqli->connect_errno)
{
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
else
{
    printf("Access granted: %s\n", $mysqli->connect_error);
}

?>
