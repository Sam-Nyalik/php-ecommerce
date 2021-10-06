<?php
// Start session
session_start();

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | RECENTLY_ADDED_PRODUCTS'); ?>

<!-- Main Navigation -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<!-- Section Title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Recently Added Products</h5>
        </div>
    </div>
</div>

<!-- Recently Added Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <!-- Prepare a SELECT statement from the database to fetch all products added recently. Limit is 4 -->
            <?php
                $sql = $pdo->prepare("SELECT * FROM all_products ORDER BY date_added DESC LIMIT 4");
                $sql->execute();
                $database_recently_added_products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach($database_recently_added_products as $recently_added_products): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <div>
                                <img src="<?=$recently_added_products['productImage'];?>" class="img-fluid card-img-top" alt="<?=$recently_added_products['productName'];?>">
                            </div>
                            <div class="card-body">
                                <h5><?=$recently_added_products['productName'];?></h5>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>            
        </div>
    </div>
</div>