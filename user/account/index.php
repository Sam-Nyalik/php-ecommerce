<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Ensure the user is logged in
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('USER | ACCOUNT'); ?>

<?php
// Top Bar
include_once "inc/top-bar.php";
// Navbar
include_once "inc/navbar.inc.php";
?>

<!-- Search bar -->
<?= searchBarTemplate(); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Account</span> Overview</h5>
        </div>
    </div>
</div>

<!-- Account Overview -->
<div class="container">
    <div id="account_overview">
        <div class="row">
            <div class="col-md-4">
                <div class="my_account">
                    <div class="title">
                        <h6>My Ecommerce. Account</h5>
                    </div>
                    <i class="bi bi-shop-window"></i> <a href="index.php?page=user/order_history">Orders</a>
                    <hr>
                    <h6>Details</h6>
                    <a href="index.php?page=user/account/address">Address Book</a><br>
                    <a href="index.php?page=user/account/deactivate" class="text-danger">Deactivate Account</a>
                    <a href="index.php?page=user/logout"><input type="submit" value="Logout" class="btn w-100 my-3"></a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="overview_section">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Account Details</h5>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php?page=user/account/edit">
                                <h6>Edit</h6>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $id = false;
                    if (isset($_SESSION['id'])) {
                        $id = $_SESSION['id'];
                    }
                    // Prepare a SELECT statement to fetch the user's name from the database
                    $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                    $sql->execute();
                    $database_user_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_user_info as $user_info) : ?>
                        <div class="user_info">
                            <h3><?= $user_info['firstName']; ?> <?= $user_info['lastName']; ?></h3>
                            <h6><?= $user_info['email']; ?></h6>
                        </div>
                    <?php endforeach; ?>
                    <a href="index.php?page=user/account/password_reset">
                        <p>Change Password</p>
                    </a>
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
                                <img src="<?= $latest_products['productImage1']; ?>" alt="<?= $latest_products['productName']; ?>" class="img-fluid card-img-top">
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