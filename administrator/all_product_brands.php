<?php

    // Start a session
    session_start();
    // Check if the admin is logged in
    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();


?>

<!-- Header template -->
<?=headerTemplate('ADMIN | ALL_PRODUCT_BRANDS'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>All Product Brands</h5>
        </div>
    </div>
</div>

<!-- Add More Products -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_product_brand">Add Product Brand</a></button>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>
