
<?php


//Retrieving data from the user input in the login.php form
session_start();

$fname = "";
$lname = "";
$email = $_SESSION["email"];
$uname = $_SESSION["uname"];
$pswd = $_SESSION["pswd"];


//Connecting to the DB

$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "usersdb";

   

$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_name);

if ($mysqli -> connect_errno) {
  echo "Something went wrong"  . $mysqli -> connect_error ;
  exit();

}

// Creating a SQL query to retrieve the additiona user's data

$query = "SELECT `user_fname`, `user_lname`  FROM `users` WHERE `user_email` = '".$email."' AND `username` = '".$uname."' AND `user_password` = '".$pswd."'";


$result = mysqli_query($mysqli, $query);


//Double checking to make sure there is only one matching element in the DB
if (mysqli_num_rows($result) != 1) {
  echo "Something went wrong, could not find your profile";
}


// Outputting the retrieved result and assigning it to the variables
while($row = $result->fetch_assoc()) {
   global $fname, $lname; 
   $fname = $row["user_fname"];
   $lname = $row["user_lname"];
}

?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="description" content="Webpage description goes here" />
    <meta charset="utf-8">
    <title>Main page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/style.css">
  
  </head>

  <header>

    


  </header>

  <body>
    <h1> You are logged in !</h1>
    <p> This is your information:</p>
    <ul>
        <li> First name: <?= $fname ; ?></li>
        <li> Last name: <?= $lname ; ?> </li>
        <li> Email <?= $email ; ?></li>
        <li> Username:  <?= $uname ; ?></li>
        <li> Password:  <?= $pswd ; ?></li>

        
    </ul>

    <a href="login.php"><button>Logout</button></a>
    
  </body>

  <footer>


  </footer>
</html>