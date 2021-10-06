<?php 

// If the user is not logged in, redirect to the login page
if(!isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] !== true)){
    header("location: index.php?page=user/login");
    exit;
}
