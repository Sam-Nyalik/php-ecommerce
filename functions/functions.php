<?php
// Database Connection Script
function databaseConnect(){
        // Sql details
        $DATABASE_HOST = "localhost";
        $DATABASE_USER = "root";
        $DATABASE_PASSWORD = "";
        $DATABASE_NAME = "php_ecommerce";

        try {
            return new PDO("mysql:host=" . $DATABASE_HOST . ";dbname=" . $DATABASE_NAME . ";charset=utf-8", $DATABASE_USER, $DATABASE_PASSWORD);
        }
        catch(PDOException $exception){
            //Stop the script and display an error if there is a problem with the connection
            exit("Connection to the database failed!" . $exception->getMessage());
        }    
}