<?php
session_start();

// Destroy the session to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page after logging out with a message
header("Location: login.php?message=Thank you for using our system!"); // You can pass a message through URL
exit();
?>
