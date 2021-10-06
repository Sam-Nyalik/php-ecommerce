<?php 

    // Check if the admin is logged in
    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

?>

<!-- Header Template -->
<?=headerTemplate('ADMIN | ALL_REGIONS'); ?>

<!-- Navbar -->
<?php include_once "includes/main_navbar.php" ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Regions &</span> Cities</h5>
        </div>
    </div>
</div>

<!-- Add Regions and Cities -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_region">Add Regions</a></button>
        </div>
    </div>
</div>

