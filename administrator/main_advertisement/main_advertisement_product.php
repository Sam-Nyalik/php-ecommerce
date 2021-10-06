<?php

// Start session
session_start();

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | MAIN_ADVERTISEMENT_PRODUCT'); ?>

<!-- Main Navbar -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Main Advertisement</h5>
        </div>
    </div>
</div>

<!-- Main Advertisement Product -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <!-- Prepare a SELECT statement to fetch all the products from the main_advertisement table -->
            <?php
            $sql = $pdo->prepare("SELECT * FROM main_advertisement ORDER BY date_added DESC");
            $sql->execute();
            $database_main_advertisement = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($database_main_advertisement as $main_advertisement) : ?>
                <div class="col-md-3">
                    <a href="index.php?page=administrator/main_advertisement/single_main_advertisement_product&id=<?= $main_advertisement['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $main_advertisement['productImage']; ?>" alt="<?= $main_advertisement['productName']; ?>" class="img-fluid card-img-top">
                            </div>
                            <div class="card-body">
                                <h5><?= $main_advertisement['productName']; ?></h5>
                                <h6><span class="text-dark">Type: </span><?= $main_advertisement['productType']; ?></h6>
                                <h6><span class="text-dark">Brand: </span><?= $main_advertisement['productBrand']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Main Advertisement Product -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/main_advertisement/add_main_advertisement_product">Add Advertisement Product</a></button>
        </div>
    </div>
</div>

<!-- Footer -->
<?= footerTemplate(); ?>