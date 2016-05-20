<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

include('connect.php');

function NewUser()
{
   global $email;

   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $pnumber = $_POST['pnumber'];
   $age = $_POST['age'];
   $email = $_POST['email'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   // echo "$firstname + $lastname + $pnumber + $age + $email + $password";


   global $mysqli;
   //$query = ("INSERT INTO persons (firstname, lastname, pnumber, age, email, pwd) VALUES (?,?,?,?,?,?)");

   $stmt = $mysqli->prepare("INSERT INTO persons (firstname, lastname, pnumber, age, email, pwd)
                            VALUES (?,?,?,?,?,?)");
   $stmt->bind_param('ssssss', $firstname, $lastname, $pnumber, $age, $email, $password);
   $stmt->execute();
   //printf ("New Record has id %d.\n", $mysqli->insert_id);
   if ($mysqli)
   {
       echo ("<script type='text/javascript'>
       window.alert('Ditt konto har skapats, du kan nu logga in!');
       window.location = 'index.html';
       </script>");
       exit();
   }
   else
   {
       echo ("<script type='text/javascript'>
       window.alert('Oj, det blev något fel i registreringen! Försök igen');
       window.location = 'index.html';
       </script>");
      exit();
   }
 }

function SignUp()
  {
    if(!empty($_POST['email']))
  {
  global $mysqli;
  $query = ("SELECT * FROM persons WHERE email = ?");
  if ($stmt = $mysqli->prepare($query))
  {
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $stmt->store_result();
        $countRows = $stmt->num_rows;
        $stmt->close();
  }

  if($countRows < 1)
  {
    NewUser();
  }
   else
  {
    echo ("<script type='text/javascript'>
       window.alert('Denna mejladdressen har redan använts!');
       window.location = 'index.html';
       </script>");
      exit();
  }

}
}
  if(isset($_POST['submit']))
  {
    $close = false;

    if(empty($_POST["firstname"]))
    {
      $nameerror = "Du måste fylla i ditt förnamn!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }
    if(empty($_POST["lastname"]))
    {
      $nameerror = "Du måste fylla i ditt efternamn!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }
    if(empty($_POST["email"]))
    {
      $nameerror = "Du måste fylla i din e-mail!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }
    if(empty($_POST["password"]))
    {
      $nameerror = "Du måste fylla i ett lösenord!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }
    if(empty($_POST["pnumber"]))
    {
      $nameerror = "Du måste fylla i ditt personnummer!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }
    if(empty($_POST["age"]))
    {
      $nameerror = "Du måste fylla i din ålder!"; //Detta funkar inte än, kanske något som ska fixas?
      $close = true;
    }

    if($close == true) {
       echo ("<script type='text/javascript'>
       window.alert('Din registrering lyckades inte, du måste fylla i alla fält!');
       window.location = 'index.html';
       </script>");
      exit();
    } else {
      SignUp();
    }
  }
$mysqli->close();
?>
