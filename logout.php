<?php

// Start session
session_start();

// Unset all the session variables
session_unset();

// Destroy all the sessions
session_destroy();

// Redirect user to the home page
header("location: index.php?page=home");
exit;
?>