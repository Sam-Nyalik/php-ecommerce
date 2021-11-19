<?php

// Start session
session_start();

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | USER_INFO'); ?>

<!-- Main Navbar script -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>


<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>User Info</h5>
        </div>
    </div>
</div>

<div class="user_personal_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Fetch user info from the database with the id in the URL -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM users WHERE id = '" . $_GET['id'] . "'");
                $sql->execute();
                $database_user_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_user_info as $user_info) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th>First Name</th>
                                <td><?= $user_info['firstName']; ?></td>
                                <th>Last Name</th>
                                <td><?= $user_info['lastName']; ?></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td><?= $user_info['email']; ?></td>
                                <th>User IP</th>
                                <td><?= $user_info['userIP']; ?></td>
                            </tr>
                            <tr>
                                <th>Creation Date</th>
                                <td><?= $user_info['date_added']; ?></td>
                                <th>Last Updation Date</th>
                                <td><?= $user_info['updation_date']; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- User Order History -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Order History(if any)</h5>
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
                                <th>Product Name</th>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <!-- Prepare a SELECT statement to fetch orders each user made -->
                        <?php
                        $sql = $pdo->prepare("SELECT all_products.productName AS productName, orders.* FROM orders JOIN all_products ON all_products.id = orders.product_id WHERE orders.user_id = '" . $_GET['id'] . "'");
                        $sql->execute();
                        $database_user_orders_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $count = 1;
                        ?>
                        <?php foreach ($database_user_orders_info as $user_orders_info) : ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $count++ ?></td>
                                    <td><?= $user_orders_info['productName']; ?></td>
                                    <td><?= $user_orders_info['order_id']; ?></td>
                                    <td><?= $user_orders_info['date_added']; ?></td>
                                    <td>Ksh. <?= $user_orders_info['product_grand_price']; ?></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?=footerTemplate(); ?>