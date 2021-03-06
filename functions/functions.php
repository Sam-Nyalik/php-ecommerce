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
            <script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>
            <link rel=\"icon\" href=\"images/image7.jpg\" sizes=\"16*16\">
        </head>
        <body>
    ";
    echo $element;
}

// Primary Footer
function primary_footerTemplate()
{
    $date = date('Y');
    $pdo = databaseConnect();
    $sql = $pdo->prepare("SELECT companyName FROM company_details WHERE id = 1");
    $sql->execute();
    $database_company_name = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($database_company_name as $company_name) :
       $companyName = $company_name['companyName'];
    endforeach;
    $element = "
    <div id=\"primary_footer\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-4\">
               <div class=\"title_footer\">
               <h2>$companyName</h2>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam voluptas quasi, corporis laboriosam suscipit architecto, corrupti ipsam porro explicabo amet ratione vero a dolor fuga? Repellendus, labore totam!</p>
                <h5>$companyName | All Rights Reserved &copy; $date </h5>
               </div>
            </div>
            <div class=\"col-md-4\">
                <h2>Menu -</h2>
                <div class=\"menu_links\">
                    <ul>
                        <li><a href=\"index.php?page=home\">Home</a></li>
                        <li><a href=\"index.php?page=all_products\">All Products</a></li>
                        <li><a href=\"index.php?page=contact-us\">Contact</a></li>
                    </ul>
                </div>
                <div class=\"logins\">
                    <h2>Login Links</h2>
                    <h5><a href=\"index.php?page=administrator/login\">Administrator</a></h5>
                    <h5><a href=\"index.php?page=user/login\">Visitor</a></h5>
                    <h5><a href=\"\">Sell with us</a></h5>
                </div>
            </div>
            <div class=\"col-md-4\">
                <h2>Latest Events</h2>
            </div>
        </div>
    </div>
</div>

    ";
    echo $element;
}

// Search Bar Template
function searchBarTemplate()
{
    $element = "
    <div id=\"home_search_link\">
    <div class=\"container\">
        <div class=\"row\">
           <a href=\"index.php?page=product_search\">Search For Products Here...</a>
        </div>
    </div>
</div>

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
    <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCYiduC0VtcteVlIGb7pVZCW4rQIA0EQbY&callback=myMap&libraries=&v=weekly\" async></script>
    <script src=\"js/main.js\"></script>
    ";
    echo $element;
}
