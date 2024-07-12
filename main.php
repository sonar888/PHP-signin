
<?php


//Retrieving data from the user input in the login.php form
session_start();

$problem_html = "";
$html="";


//If the session does not exist we display problem_html

if(!isset($_SESSION["email"]) ) {

  $problem_html ='<p>You are not logged in. Go to the <a href="login.php">login</a> page or <a href ="sign-up.php">sign-up</a instead</p>';


} else {

  //Else we handle the users input in the session


$fname = "";
$lname = "";
$email = $_SESSION["email"];
$uname = $_SESSION["uname"];
$pswd = $_SESSION["pswd"];


//Connect to the DB

$db_hostname = "";
$db_username = "";
$db_password = "";
$db_name = "";

   

$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_name);

if ($mysqli -> connect_errno) {
  echo "Something went wrong"  . $mysqli -> connect_error ;
  exit();

}

// Create a SQL query to retrieve the additiona user's data

$query = "SELECT `user_fname`, `user_lname`  FROM `users` WHERE `user_email` = '".$email."' AND `username` = '".$uname."' AND `user_password` = '".$pswd."'";


$result = mysqli_query($mysqli, $query);


//Double check to make sure there is only one matching element in the DB
if (mysqli_num_rows($result) != 1) {
  echo "Something went wrong, we could not find your profile";
}


// Output the retrieved result and assigning it to the variables
while($row = $result->fetch_assoc()) {
   global $fname, $lname; 
   $fname = $row["user_fname"];
   $lname = $row["user_lname"];
}



// We declare the html to display with the retrived variables
$html= "
  <h1> You are logged in !</h1>
    <p> This is your information:</p>
    <ul>
        <li> First name: $fname </li>
        <li> Last name: $lname</li>
        <li> Email $email</li>
        <li> Username: $uname</li>
        <li> Password: $pswd </li>

        
    </ul>
  
  ";

}




// Separately, we handle the session log-out

if(array_key_exists('logout',$_POST)){
  echo "Logged out";

  global $fname, $lname;

  $fname="";
  $lname="";
  unset($_SESSION['uname']);
  unset($_SESSION['email']);
  unset ($_SESSION['pswd']);
  header("location: login.php");

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

  <?= $problem_html; ?>

  <?= $html; ?>
  

    


  </header>

  <body>
    
    

    <form method="POST"> 
      <input type="submit" name="logout" class="button" value="Logout" /> 
    </form> 

  </body>

  <footer>


  </footer>
</html>