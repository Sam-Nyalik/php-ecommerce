<?php 
    // Start session
    session_start();

    // Check if admin is logged in
    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();


?>

<!-- Header Template -->
<?=headerTemplate('ADMIN | PRODUCT_CATEGORIES'); ?>

<!-- Main Admin header -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>All Product</span> Categories</h5>
        </div>
    </div>
</div>

<!-- Add Regions and Cities -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_product_category">Add Product Category</a></button>
        </div>
    </div>
</div>

<!-- Footer -->
<?=footerTemplate(); ?>
