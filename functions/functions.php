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
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css\">
            <link href=\"https://unpkg.com/aos@2.3.1/dist/aos.css\" rel=\"stylesheet\">
            <link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\">
            <link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
            <link rel=\"shortcut icon\" href=\"../images/image2.jpg\" type=\"image/x-icon\">
        </head>
        <body>
    ";
    echo $element;
}

// Footer template
function footerTemplate()
{
    $year = date('Y');
    $element = " 
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\" > </script> 
    <script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js\" ></script> 
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM\" crossorigin=\"anonymous\"></script>
    <script src=\"https://unpkg.com/aos@2.3.1/dist/aos.js\"></script>
    <script src=\"js/main.js\"></script>
    ";
    echo $element;
}

?>
