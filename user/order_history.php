<?php

// Start a session
session_start();

// Check if the user is logged in
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('USER | ORDER_HISTORY'); ?>

<!-- Topbar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Main Navigation -->
<?php include_once "inc/navbar.inc.php"; ?>

<!-- Section Title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Order History</h5>
        </div>
    </div>
</div>

<div class="user_orders_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <!-- Prepare a SELECT statement to fetch user orders from the database joining the all_products and orders tables -->
                        <?php
                        $sql = $pdo->prepare("SELECT all_products.productImage AS productImage, all_products.productName AS productName, orders.* FROM orders JOIN all_products ON all_products.id = orders.product_id WHERE orders.user_id = '" . $_SESSION['id'] . "'");
                        $sql->execute();
                        $database_user_order_history = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $count = 1;
                        ?>
                        <?php foreach ($database_user_order_history as $user_order_history) : ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><img src="<?= $user_order_history['productImage']; ?>" alt="<?= $user_order_history['productName']; ?>" style="width: 200px" class="img-fluid img-responsive"></td>
                                        <td><?= $user_order_history['productName']; ?></td>
                                        <td><?= $user_order_history['order_id']; ?></td>
                                        <td><?= $user_order_history['date_added']; ?></td>
                                        <td>&dollar;<?= $user_order_history['product_grand_price']; ?></td>
                                    </tr>
                                </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer Template -->
<?= primary_footerTemplate(); ?>

<!-- Main Footer -->
<?= footerTemplate(); ?>