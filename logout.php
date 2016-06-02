<?php
session_start();

ini_set("display_errors", true);
error_reporting( E_ALL );

include("connect.php");

if(isset($_POST['submit'])) {

    session_unset();
    header("Location:index.php");

}

?>
