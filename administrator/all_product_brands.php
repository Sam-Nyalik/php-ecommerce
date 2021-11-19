<?php

// Start a session
session_start();
// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();


?>

<!-- Header template -->
<?= headerTemplate('ADMIN | ALL_PRODUCT_BRANDS'); ?>

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

<!-- All Product Brands -->
<div class="user_orders_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Brand</th>
                                <th>Date Added</th>
                                <th>Updation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- Fetch product brands from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM product_brands");
                        $sql->execute();
                        $count = 1;
                        $database_product_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($database_product_brand as $product_brand) : ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?= $product_brand['productBrand']; ?></td>
                                    <td><?= $product_brand['dateAdded']; ?></td>
                                    <td><?= $product_brand['updationDate']; ?></td>
                                    <td><a href="index.php?page=administrator/single_product_brand&id=<?= $product_brand['id']; ?>"><i class="bi bi-eye"></i></a> | <a href="index.php?page=administrator/delete_product_brand&id=<?= $product_brand['id']; ?>" onclick="return confirm('Are you sure you want to delete the <?= $product_brand['productBrand']; ?> as a product brand?')" class="text-danger tooltips" tooltip-placement="top" tooltip="Remove"><i class="bi bi-trash"></i></a></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
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