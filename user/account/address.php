<?php

// Ensure the user is logged in
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('USER | ADDRESS_BOOK'); ?>

<?php
// Top Bar 
include_once "inc/top-bar.php";
// Navbar
include_once "inc/navbar.inc.php";
?>

<!-- Search Bar -->
<?= searchBarTemplate(); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Address</span> Book</h5>
        </div>
    </div>
</div>

<!-- Address Book -->
<div class="container">
    <div id="account_overview">
        <div class="row">
            <div class="col-md-8">
                <div class="overview_section">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Address Details</h5>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php?page=user/account/edit">
                                <h6>Edit Address Book</h6>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <?php

                    $uid = false;
                    if (isset($_SESSION['id'])) {
                        $uid = $_SESSION['id'];
                    }

                    // Fetch user info from the database
                    $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                    $sql->execute();
                    $database_user_address = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_user_address as $user_address) : ?>
                        <div class="user_info">
                            <h3><?= $user_address['firstName']; ?> <?= $user_address['lastName']; ?></h3>
                            <h6><b>Physical Address: </b><?= $user_address['address']; ?></h6>
                            <h6><b>Telehone Number: </b><?= $user_address['phoneNumber']; ?></h6>
                            <h5 class="my-3 text-success" style="text-transform: capitalize; font-weight: 400; font-size: 16px">Default Address</h5>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <h5 style="text-align: start;">Latest Products</h5>
            <?php
            $sql = $pdo->prepare("SELECT * FROM all_products ORDER BY date_added DESC LIMIT 4");
            $sql->execute();
            $database_latest_products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($database_latest_products as $latest_products) : ?>
                <div class="col-md-3">
                    <a href="index.php?page=individual_product&id=<?= $latest_products['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $latest_products['productImage']; ?>" alt="<?= $latest_products['productName']; ?>" class="img-fluid card-img-top">
                            </div>
                            <div class="card-body">
                                <h5><?= $latest_products['productName']; ?></h5>
                                <h6 class="ratings">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </h6>
                                <hr>
                                <?php if ($latest_products['productRetailPrice'] > 0) : ?>
                                    <small class="text-muted"><s style="font-size: 16px;">&dollar;<?= $latest_products['productRetailPrice']; ?></s></small>
                                <?php endif; ?>
                                <h6 class="text-dark" style="font-weight: 600;"><?= $latest_products['productPrice']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>