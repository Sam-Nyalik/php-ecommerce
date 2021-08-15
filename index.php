<?php
// Start a session
session_start();
// Include the functions folder, the functions file and connect to the database using the databaseConnect() function
include_once "functions/functions.php";
$pdo = databaseConnect();

// Page routing(Make the home.php be the default home page)
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';

// include and show the request page
include_once $page . '.php';

?>