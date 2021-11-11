<?php

// Start a session
session_start();

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL_PRODUCTS') ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>All Products</h5>
        </div>
    </div>
</div>

<!-- All Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php
            // Prepare a SELECT statement to fetch all the products from the database
            $sql = $pdo->prepare("SELECT * FROM all_products");
            $sql->execute();
            $database_all_products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach($database_all_products as $all_products): ?>
                <div class="col-md-3 col-sm-6 my-3 my-md-0">
                        <div class="card">
                            <div>
                                <img src="<?=$all_products['productImage1'];?>" alt="<?=$all_products['productName'];?>" class="img-card-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5><?=$all_products['productName'];?></h5>
                                <h6><span class="text-dark">Type: </span><?=$all_products['productType'];?></h6>
                                <h6><span class="text-dark">Brand: </span><?=$all_products['productBrand'];?></h6>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>    
        </div>
    </div>
</div>

<!-- Add More Products -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_products">Add Products</a></button>
        </div>
    </div>
</div>

<!-- Footer template -->
<?= footerTemplate(); ?>