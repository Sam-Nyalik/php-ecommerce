<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include the functions file
include_once "functions/functions.php";
$pdo = databaseConnect();

// The total number of products that will be displayed on each page
$number_of_products_on_each_page = 12;

// The current page in the url
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

// // Prepare a SELECT statement to fetch the products from the database in DESC order with a LIMIT
$sql = $pdo->prepare("SELECT * FROM all_products ORDER BY date_added DESC LIMIT ?,?");

// // Bind values
$sql->bindValue(1, ($current_page - 1) * $number_of_products_on_each_page, PDO::PARAM_INT);
$sql->bindValue(2, $number_of_products_on_each_page, PDO::PARAM_INT);

// // Execute
$sql->execute();

// // Fetch the products from the database as an associative array
$database_products = $sql->fetchAll(PDO::FETCH_ASSOC);

// // Get the total number of products from the database
$total_number_of_products = $pdo->query("SELECT * FROM all_products")->rowCount();

?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php" ?>

<!-- Header Template -->
<?= headerTemplate('ALL_PRODUCTS'); ?>

<!-- Top Bar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce.</a></h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item">Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item">Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item">Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item">Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item">Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle active" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item active">All Products</a>
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

<!-- Search bar -->
<?= searchBarTemplate(); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>All</span> Products</h5>
        </div>
    </div>
</div>

<!-- Total number of products -->
<div id="number_of_products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h6> <span><?= $total_number_of_products ?></span> Products</h6>
            </div>
        </div>
    </div>
</div>

<!-- All Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php foreach ($database_products as $products) : ?>
                <div class="col-md-3">
                    <a href="index.php?page=individual_product&id=<?= $products['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $products['productImage']; ?>" alt="<?= $products['productName']; ?>" class="img-card-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5><?= $products['productName']; ?></h5>
                                <h6 class="ratings">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </h6>
                                <hr>
                                <?php if ($products['productRetailPrice'] > 0) : ?>
                                    <small class="text-muted"><s style="font-size: 16px;"><?= $products['productRetailPrice']; ?></s></small>
                                <?php endif; ?>
                                <h6 class="text-dark" style="font-weight: 600;">&dollar;<?= $products['productPrice']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Pagination(This will be visible if the total number of products is greater than 12) -->
<div id="pagination">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <?php if ($current_page > 1) : ?>
                    <a href="index.php?page=all_products&p=<?= $current_page - 1 ?>"><i class="bi bi-chevron-double-left"></i> Prev Page</a>
                <?php endif; ?>
                <?php if ($total_number_of_products > ($current_page * $number_of_products_on_each_page) - $number_of_products_on_each_page + count($database_products)) : ?>
                    <a href="index.php?page=all_products&p=<?= $current_page + 1; ?>">Next Page <i class="bi bi-chevron-double-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer Template -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>