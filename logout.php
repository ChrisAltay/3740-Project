<?php

session_start();
// Checks if user clicked on ok for confirmation logout dailog box
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $_SESSION = array();

// This will terminate the current session
session_destroy();

// After termination, the user will be re-directed to the home page (index.html)
header("Location: index.html"); 
exit;

}
?>



