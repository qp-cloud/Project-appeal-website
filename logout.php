<?php
// Start the session
session_start();

// Destroy all session data
session_unset(); // Removes all session variables
session_destroy(); // Destroys the session

// Redirect the user to the login page
header("Location: home.html");
exit();
?>
