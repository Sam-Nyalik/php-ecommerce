<?php

    // Start session
    session_start();

    // Check if the admin is logged in
    include_once "./administrator/includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

?>

<!-- Header Template -->
<?=headerTemplate('ADMIN | ALL_LAPTOP_PRODUCTS'); ?>

<!-- Main Navbar Script -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5><span>All Laptop </span> Products</h5>
        </div>
    </div>
</div>

<!-- Laptop Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php
            // Prepare a SELECT statement to fetch all the products with the productType of Laptop from the database
            $sql = $pdo->prepare("SELECT * FROM all_products WHERE productType = 'Laptop' ORDER BY date_added DESC");
            $sql->execute();
            $database_all_products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach($database_all_products as $all_products): ?>
                <div class="col-md-3 col-sm-6 my-3 my-md-0">
                    <a href="index.php?page=administrator/laptop_products/single_laptop_product&id=<?=$all_products['id'];?>">
                        <div class="card">
                            <div>
                                <img src="<?=$all_products['productImage'];?>" alt="<?=$all_products['productName'];?>" class="img-card-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5><?=$all_products['productName'];?></h5>
                                <h6><span class="text-dark">Brand: </span><?=$all_products['productBrand'];?></h6>
                            </div>
                        </div>          
                </a>
                </div>
            <?php endforeach; ?>    
        </div>
    </div>
</div>

<!-- Footer Template -->
<?=footerTemplate(); ?>