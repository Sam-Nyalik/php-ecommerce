<?php

include_once "functions/functions.php";
$pdo = databaseConnect();

// Prepare a SELECT statement to fetch products from the database whose productBrand = Huawei
$sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'Huawei' ORDER BY date_added DESC");
$sql->execute();
$database_huawei_products = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php" ?>

<!-- Header Template -->
<?= headerTemplate('HUAWEI_PRODUCTS'); ?>

<!-- Top Bar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Main Navbar -->
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
                    <a href="" class="nav-link dropdown-toggle active" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item"><img src="icons/apple.png" alt="apple"> Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item"><img src="icons/samsung.png" alt="samsung"> Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item active"><img src="icons/huawei.png" alt="huawei"> Huawei</a>
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
                <a href="index.php?page=cart"> <i class="bi bi-cart4" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Huawei</span> Products</h5>
        </div>
    </div>
</div>

<!-- Huawei Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php foreach ($database_huawei_products as $huawei_products) : ?>
                <div class="col-md-3">
                    <a href="index.php?page=individual_product&id=<?= $huawei_products['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $huawei_products['productImage']; ?>" alt="<?= $huawei_products['productName']; ?>" class="img-fluid card-img-top">
                            </div>
                            <div class="card-body">
                                <h5><?= $huawei_products['productName']; ?></h5>
                                <h6 class="ratings">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </h6>
                                <hr>
                                <?php if ($huawei_products['productRetailPrice'] > 0) : ?>
                                    <small class="text-muted"><s style="font-size: 16px;">&dollar;<?= $huawei_products['productRetailPrice']; ?></s></small>
                                <?php endif; ?>
                                <h6 class="text-dark" style="font-weight: 600;">&dollar;<?= $huawei_products['productPrice']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Primary Footer Template -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>