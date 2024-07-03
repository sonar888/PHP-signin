<?php


//Setting variables to display to the user
$error_message = "";
$message= "";

//Setting variables to connect to the DB
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "usersdb";


//Making sure that the for is sent (this needs revision)
if($_SERVER["REQUEST_METHOD"]=== "POST") {

    // Step 1: Sanitize the input from the user

        //Setting the variables with the user's input
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $uname = $_POST["uname"];
        $email = $_POST["email"];
        $age = $_POST["age"];
        $pswd = $_POST["pswd"];

        // A sanitazion function to be added here




    //Step 2: Connect to the database

    $mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_name);
        
    if ($mysqli -> connect_errno) {

            echo "Failed to connect" . $mysqli -> connect_error;
            exit();

        } 

    

    
    //Step 3: Checking to see if the email exists in the db

    $select_email = mysqli_query($mysqli, "SELECT `user_email` FROM `users` WHERE `user_email` = '".$email."'") or exit(mysqli_error($mysqli));
    $select_username = mysqli_query($mysqli, "SELECT `username` FROM `users` WHERE `username` =  '".$uname."'") or exit(mysqli_error($mysqli));
    

    if(mysqli_num_rows($select_email)) {
        exit('This email is already being used'); //If the email already exists => exit the page

    } elseif (mysqli_num_rows($select_username)) { //If the username already exists => exit the page

        exit("This username is already in use");

        


    } else { // If both are ok, adding the user to the DB and redirecting to the login page

        $input = 'INSERT INTO users (user_fname, user_lname, username, user_age, user_email, user_password) VALUES (?, ?, ?, ?, ?, ?)';

        $mysqli->execute_query($input, [$fname, $lname, $uname, $age, $email, $pswd]);
        header("Location: login.php");
        
    }

    

}


?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="description" content="Webpage description goes here" />
    <meta charset="utf-8">
    <title>Sign-up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" conten>
    <link rel="stylesheet" href="css/style.css">
  </head>

  <header>

    


  </header>

  <body>
    <form method="POST">
        <label for="fname"> First Name</label>
        <input type="text" placeholder="First name" id="fname" name="fname" required  >

        <label for="lname"> Last Name</label>
        <input type="text" placeholder="Last name" id="lname" name="lname">

        <label for="uname"> Userame</label>
        <input type="text" placeholder="Username" id="uname" name="uname" required>

        <label for="age"> Age</label>
        <input type="number" placeholder="Age" id="age" name="age" min=18 max=124>

        <label for="email"> Email</label>
        <input type="email" placeholder="Email" id="email"  name="email" required>

        <label for="pswd"> Password </label>
        <input type="password" placeholder="Password" id="pswd" name="pswd" required>

        <button> Send </button>

        <p> <?= $error_message ?></p>
    </form>


    <p> Already a user? Try to <a href ="login.php">login</a> </p>
  </body>

  <footer>
  </footer>
</html>