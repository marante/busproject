<?php

ini_set("display_errors", true);
error_reporting( E_ALL );

include('connect.php');

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

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
       echo "You fucked up along time ago";
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
    echo "SORRY...YOU ARE ALREADY REGISTERED USER...";
  }

}
}
  if(isset($_POST['submit']))
{
  SignUp();
}
$mysqli->close();
?>
