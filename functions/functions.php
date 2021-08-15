<?php
// Database Connection Script
function databaseConnect()
{
    // Sql details
    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASSWORD = "";
    $DATABASE_NAME = "php_ecommerce";

    try {
        return new PDO("mysql:host=" . $DATABASE_HOST . ";dbname=" . $DATABASE_NAME . ";charset=utf8", $DATABASE_USER, $DATABASE_PASSWORD);
    } catch (PDOException $exception) {
        //Stop the script and display an error if there is a problem with the connection
        exit("Connection to the database failed!" . $exception->getMessage());
    }
}

// Header Template Script
function headerTemplate($title)
{
    $element = "
    <!DOCTYPE html>
    <html lang=\"en\">
        <head>
            <title>$title</title>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <meta http-eqiuv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta name=\"author\" content=\"Sam Nyalik\">
            <meta name=\"description\" content=\"This is an e-commerce web application built with php and SQL\">
            <meta name=\"keywords\" content=\"HTML5, CSS3, Javascript, PHP, MYSQL\">
            <link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\">
            <link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
            <link rel=\"shortcut icon\" href=\"\" type=\"image/x-icon\">
        </head>
    ";
    echo $element;
}

