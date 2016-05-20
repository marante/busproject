<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

include("connect.php");

if(isset($_POST['submit'])) {

    global $mysqli;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pwdFromDB = '';

    if($stmt = $mysqli->prepare("SELECT pwd FROM Persons WHERE email = ? ")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($pwdFromDB);
        $stmt->fetch();
        $stmt->close();
    }

    if(password_verify($password, $pwdFromDB)) {
        echo ("<script type='text/javascript'>
        window.alert('Du har loggat in!');
        window.location = 'index.html';
        </script>");
        exit();
    } else {
        echo ("<script type='text/javascript'>
        window.alert('Fel användarnamn eller lösenord! $pwdFromDB ');
        window.location = 'index.html';
        </script>");
        exit();
    }


}



?>
