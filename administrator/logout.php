<?php
    // Start a session
    session_start();

    //Destroy sessions
    $_SESSION = array();

    session_destroy();

    // Redirect the admin to the login page
    header("location: index.php?page=administrator/login");
    exit;

?>