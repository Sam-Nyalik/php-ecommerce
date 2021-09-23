<?php

// Check if the admin is logged in, if not redirect to the login page
if(!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true){
    header("location: index.php?page=administrator/login");
    exit;
}

?>