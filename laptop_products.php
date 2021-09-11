<?php

include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('LAPTOP_PRODUCTS'); ?>

<!-- Top Bar -->
<?= top_barTemplate(); ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce</a></h3>
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
                        <a href="" class="dropdown-item">Apple</a>
                        <a href="" class="dropdown-item">Samsung</a>
                        <a href="" class="dropdown-item">Huawei</a>
                        <a href="" class="dropdown-item">Dell</a>
                        <a href="" class="dropdown-item">Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle active" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="index.php?page=laptop_products" class="dropdown-item active">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <i class="bi bi-bag" style="margin-right: 30px;"><span class="text-dark">(0)</span></i>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
                <i class="bi bi-search"></i>
            </span>
        </div>
    </div>
</nav>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Laptop</span> Products</h5>
        </div>
    </div>
</div>

<!-- Laptop Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <!-- Prepare a SELECT statement to fetch laptop products from the database  -->
            <?php
            $sql = $pdo->prepare("SELECT * FROM all_products WHERE productType = 'Laptop' ORDER BY date_added DESC");
            $sql->execute();
            $database_laptop_products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($database_laptop_products as $laptop_products) : ?>
                <div class="col-md-3 col-sm-6">
                    <a href="index.php?page=individual_product&id=<?= $laptop_products['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $laptop_products['productImage']; ?>" alt="<?= $laptop_products['productName']; ?>" class="img-card-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5><?= $laptop_products['productName']; ?></h5>
                                <h6 class="ratings">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </h6>
                                <hr>
                                <?php if ($laptop_products['productRetailPrice'] > 0) : ?>
                                    <small class="text-muted"><s style="font-size: 16px;"><?= $laptop_products['productRetailPrice']; ?></s></small>
                                <?php endif; ?>
                                <h6 class="text-dark" style="font-weight: 600;">&dollar;<?= $laptop_products['productPrice']; ?></h6>
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