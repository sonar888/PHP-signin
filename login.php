<?php

session_start();




$error_message="";



if($_SERVER["REQUEST_METHOD"] === "POST") {


    $db_hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "usersdb";

   

    $mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_name);

    if ($mysqli -> connect_errno) {
        echo "An error occurred, try again later" . $mysqli -> connect_error; 
        exit();   
    }

    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    

    $check_uname = mysqli_query($mysqli, "SELECT `username` FROM `users` WHERE `username` = '".$uname."' ") or exit(mysqli_error($mysqli));
    $check_email = mysqli_query($mysqli, "SELECT `user_email` FROM users WHERE `user_email` = '".$email."' ") or exit(mysqli_error($mysqli));
    $check_pswd = mysqli_query($mysqli, "SELECT `user_password` FROM users WHERE `user_password` = '".$pswd."' ") or exit(mysqli_error($mysqli));

    

    if (mysqli_num_rows($check_uname) === 1 && mysqli_num_rows($check_email) === 1 && mysqli_num_rows($check_pswd) === 1) {
        $_SESSION["uname"] = $uname;
        $_SESSION["email"] = $email;
        $_SESSION["pswd"] = $pswd;

        header("Location: main.php");
    } else {
        $error_message = "Input does not match, try again!";
    }

}




?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="description" content="Webpage description goes here" />
    <meta charset="utf-8">
    <title>Login page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/style.css">
  
  </head>

  <header>

    


  </header>

  <body>
    <form method="POST">

        <label for="uname"> Usename</label>
        <input type="text" placeholder="Username" id="uname" value="" name="uname" required>

        <label for="email"> Email</label>
        <input type="email" placeholder="Email" id="email" value="" name="email" required >

        <label for="pswd"> Password </label>
        <input type="password" placeholder="Password" id="pswd" value="" name="pswd" required>

        <p> <?= $error_message; ?> </p>

        <button> Send </button>
    </form>

    <p> Not a user yet?  <a href ="sign-up.php">Sign-up</a> instead</p>
  </body>

  <footer>


  </footer>
</html>
  