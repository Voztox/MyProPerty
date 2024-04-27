<?php

// Start the session
session_start();

// if the user is already logged in then redirect user to welcome page
//or index.php page , changed userid to cusomterID to match database
if (isset($_SESSION["userID"]) && $_SESSION["userID"] === true) {
    //redirect user if they log in to home page
    header("location: myProPerty_welcome.php");
    exit;
}

// // check for email
// if (isset($_SESSION["email"]) && $_SESSION["email"] === true) {
//     //redirect user if they log in to home page
//     header("location: myProPerty_welcome.php");
//     exit;
// }
?>