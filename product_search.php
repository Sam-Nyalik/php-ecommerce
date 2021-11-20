<?php
// Start session
session_start();

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$search_item = "";
$search_item_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate Search input
    if (empty(trim($_POST['search']))) {
        $search_item_error = "Field is required!";
    } else {
        // check if the product exists in the database
        $sql = "SELECT id FROM all_products WHERE productName = :search";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":search", $param_search, PDO::PARAM_STR);
            // Set parameters
            $param_search = trim($_POST['search']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $search_item = trim($_POST['search']);
                } else {
                    $general_error = "Product does not exist!";
                }
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }
}
?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php"; ?>

<!-- Header Template -->
<?= headerTemplate('PRODUCT SEARCH'); ?>

<!-- Top Bar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
    <div class="side_nav" id="bars_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bars"></div>
            <div class="bars"></div>
            <div class="bars"></div>
        </div>
        <ul class="bars_drop dropdown-menu" aria-labelledby="bars_dropdown">
            <a href="" class="dropdown-item"><img src="icons/restaurant.png" alt="food"> Food</a>
            <a href="" class="dropdown-item"><img src="icons/soft-drink.png" alt="Beverages"> Beverages</a>
            <a href="" class="dropdown-item"><img src="icons/shoes.png" alt="shoes"> Shoes</a>
            <a href="" class="dropdown-item"><img src="icons/clothes-hanger.png" alt="clothes"> Clothes</a>
            <a href="" class="dropdown-item"><img src="icons/work.png" alt="office"> Office</a>
            <a href="" class="dropdown-item"><img src="icons/furnitures.png" alt="furniture"> Furniture</a>
            <a href="" class="dropdown-item"><img src="icons/console.png" alt="games"> Gaming</a>
            <a href="" class="dropdown-item"><img src="icons/open-book.png" alt="Books"> Education</a>
        </ul>

        <h3 class="navbar-brand"><a href="index.php?page=home">
             <!-- Fetch company Name from the database -->
             <?php
                $sql = $pdo->prepare("SELECT companyName FROM company_details WHERE id = 1");
                $sql->execute();
                $database_company_name = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_company_name as $company_name) : ?>
                    <?= $company_name['companyName']; ?>
                <?php endforeach; ?>
        </a></h3>
        <div class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                 <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item"><img src="icons/apple.png" alt="apple"> Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item"><img src="icons/samsung.png" alt="samsung"> Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item"><img src="icons/huawei.png" alt="huawei"> Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item"><img src="icons/dell.png" alt="dell"> Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item"><img src="icons/hp.png" alt="hp"> Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="index.php?page=laptop_products" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <a href="index.php?page=cart"><i class="bi bi-bag active" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<div id="search_bar">
    <div class="container">
        <div class="row d-flex">
           <div class="col-md-12">
           <form action="index.php?page=product_search" method="post" class="search_bar_form">
                <!-- General Error -->
                <div class="form-group">
                    <span class="text-danger">
                        <ul>
                            <li><?php
                                if ($general_error) {
                                    echo $general_error;
                                }
                                ?></li>
                        </ul>
                    </span>
                </div>
                <div class="form-group">
                    <input type="text" name="search" placeholder="Search here..." class="form-control">
                    <span class="text-danger"><?php echo $search_item_error; ?></span>
                </div>
                <div class="form-group my-3">
                    <input type="submit" class="btn rounded-pill" value="Search">
                </div>
            </form>
           </div>
        </div>
    </div>
</div>

<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php
            if (isset($_POST['search'])) {
                $product_data = trim($_POST['search']);

                // Prepare a SELECT statetemt to fetch product from the database with the specified input name
                $sql = $pdo->prepare("SELECT * FROM all_products WHERE productName LIKE '%$product_data%'");
                $sql->execute();
                if ($sql->rowCount() == 1) {
                    // Fetch the results and return them as an associative array
                    $database_searched_product = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

                    <h5 class="text-center">Results for "<?php echo $product_data; ?>"</h5>
                    <?php foreach ($database_searched_product as $searched_product) : ?>
                        <div class="col-md-3">
                            <a href="index.php?page=individual_product&id=<?= $searched_product['id']; ?>">
                                <div class="card">
                                    <div>
                                        <img src="<?= $searched_product['productImage1']; ?>" alt="<?= $searched_product['productName']; ?>" class="img-fluid img-responsive">
                                    </div>
                                    <div class="card-body">
                                        <h5><?= $searched_product['productName']; ?></h5>
                                        <h6 class="ratings">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </h6>
                                        <hr>
                                        <?php if ($searched_product['productRetailPrice'] > 0) : ?>
                                            <small class="text-muted"><s style="font-size: 16px;">Ksh. <?= $searched_product['productRetailPrice']; ?></s></small>
                                        <?php endif; ?>
                                        <h6 class="text-dark" style="font-weight: 600;">Ksh. <?= $searched_product['productPrice']; ?></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                <?php
                } else {
                ?>
                    <h3 class="text-center">Product with the name "<?php echo $product_data; ?>" wasn't found</h3>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Section -->
<?= footerTemplate(); ?>