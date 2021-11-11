<?php

// Start a session
session_start();
// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Process form data when the del button is clicked
if (isset($_GET['del'])) {
    // Delete product type from the database
    $sql = "DELETE FROM product_types WHERE id = '" . $_GET['id'] . "'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['del']]);

    if ($stmt) {
        echo "<script>alert('You have successfully deleted this product type!');</script>";
    } else {
        echo "There was an error. Please try again!";
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL_PRODUCT_TYPES'); ?>

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
<div class="user_orders_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Type</th>
                                <th>Date Added</th>
                                <th>Updation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        // Fetch All product types from the database
                        $sql = $pdo->prepare("SELECT * FROM product_types");
                        $sql->execute();
                        $count = 1;
                        $database_product_types = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <tbody>
                            <?php foreach ($database_product_types as $product_types) : ?>
                                <tr>
                                    <td style="padding: 15px;"><?php echo $count++; ?></td>
                                    <td><?= $product_types['productType']; ?></td>
                                    <td><?= $product_types['date_added']; ?></td>
                                    <td><?=$product_types['updation_date'];?></td>
                                    <td><a href="index.php?page=administrator/single_product_type&id=<?= $product_types['id']; ?>"><i class="bi bi-eye"></i></a> | <a href="index.php?page=administrator/delete_product_type&id=<?= $product_types['id']; ?>" onclick="return confirm('Are you sure you want to delete <?=$product_types['productType'];?> as a product type?')" class="text-danger tooltips" tooltip-placement="top" tooltip="Remove"><i class="bi bi-trash"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add More Product Types -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_product_types">Add Product Type</a></button>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>