<?php
session_start();

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
   $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

   global $mysqli;
   $stmt = $mysqli->prepare("INSERT INTO persons (firstname, lastname, pnumber, age, email, pwd)
                            VALUES (?,?,?,?,?,?)");
   $stmt->bind_param('ssssss', $firstname, $lastname, $pnumber, $age, $email, $password);
   $stmt->execute();
   if ($mysqli)
   {
     $_SESSION['accountCreated'] = "Ditt konto har skapats, du kan nu logga in!";
     header("Location:index.php");
     exit();
   }
   else
   {
       echo ("<script type='text/javascript'>
       window.alert('Oj, det blev något fel i registreringen! Försök igen');
       window.location = 'index.php';
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
    $_SESSION['emailExistsError'] = "";
    $_SESSION['message'] = "success";
    NewUser();
  }
   else
  {
    $_SESSION['accountCreated'] = "";
    $_SESSION['emailExistsError'] = "Denna mejladdressen har redan använts!";
    $_SESSION['message'] = "error";
    header("Location:index.php");
    exit();
  }

}
}
  if(isset($_POST['submit']))
  {
    $close = false;

    if(empty($_POST["firstname"]))
    {
      $_SESSION['fnameError'] = "Du måste fylla i ditt förnamn!";
      $close = true;
    } else {
      $_SESSION['fnameError'] = "";
    }
    if(empty($_POST["lastname"]))
    {
      $_SESSION['lnameError'] = "Du måste fylla i ditt efternamn!";
      $close = true;
    } else {
      $_SESSION['lnameError'] = "";
    }
    if(empty($_POST["email"]))
    {
      $_SESSION['emailError'] = "Du måste fylla i din e-mail!";
      $close = true;
    } else {
      $_SESSION['emailError'] = "";
    }
    if(empty($_POST["password"]))
    {
      $_SESSION['passwordError'] = "Du måste fylla i ett lösenord!";
      $close = true;
    } else {
      $_SESSION['passwordError'] = "";
    }
    if(empty($_POST["pnumber"]))
    {
      $_SESSION['pnumberError'] = "Du måste fylla i ditt personnummer!";
      $close = true;
    } else {
      $_SESSION['pnumberError'] = "";
    }
    if(empty($_POST["age"]))
    {
      $_SESSION['ageError'] = "Du måste fylla i din ålder!";
      $close = true;
    } else {
      $_SESSION['ageError'] = "";
    }
    if($close == true) {
      header("Location:index.php");
      exit();
    } else {
      SignUp();
    }
  }
$mysqli->close();
?>
