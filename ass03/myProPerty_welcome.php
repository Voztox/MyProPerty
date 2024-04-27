<?php
// start the session 
session_start();
require_once('myProPerty_header.php');

   //COMMENT THIS redirect link for now,to test everything.
   //may not need this code as user can use site without having to login
   //this have the option to click on login on their own. 

   
// Check if the user is not logged in, then redirect the user to login page
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == false) {
header("location: index.php"); 
exit;

}

 ?>


 <!DOCTYPE html>
 <html lang="en">

      <head>
       <meta charset="UTF-8">

          <title>Welcome 
          <?php 
            echo isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : '';
           ?>
          </title>

          <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0alpha3/dist/css/bootstrap.min.css">
      </head>

  <body>

  <div class="container-fluid mt-3 ">

    <?php 
        echo isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : ' ';  
     ?>   <p> you're logged in!</p>


 
 <p>Would You Like to Logout?

 <a href="myProPerty_logout.php" class="btn btn-secondary btn-sm active"
role="button" aria-pressed="true">Log Out</a>
 </p>


 
  
 </div> 
 </body>
 </html>  