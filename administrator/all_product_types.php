<?php

    // Start a session
    session_start();
    // Check if the admin is logged in
    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

?>

<!-- Header Template -->
<?=headerTemplate('ADMIN | ALL_PRODUCT_TYPES'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>All Product Types</h5>
        </div>
    </div>
</div>

<!-- All Product Types -->


<!-- Add More Product Types -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_product_types">Add Product Type</a></button>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?=footerTemplate(); ?>