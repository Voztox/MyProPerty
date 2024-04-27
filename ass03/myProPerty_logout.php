<?php
// Start the session
session_start();
// Destroy the session. 
if(session_destroy()) { 
    //redirect to the login page
header("Location: myProPerty_login.php");
exit;
}
?>