<?php
// Start a session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<?= headerTemplate('ADMIN | DASHBOARD'); ?>

<!-- Main Navbar script -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Admin Dashboard</h5>
        </div>
    </div>
</div>

<!-- dashboard options -->
<div id="dashboard_options">
    <div class="container">
        <div class="row text-center">

        <!-- Phone Products -->
            <div class="col-md-4">
                <h4>Phone Products</h4>
                <h6><a href="index.php?page=administrator/phone_products/all_phone_products">
                <!-- Prepare a SELECT Query to get all the phone products from the database -->
                        <?php
                            $sql = $pdo->prepare("SELECT * FROM phone_products");
                            $sql->execute();
                            $database_phone_products = $sql->rowCount();
                        ?>
                        Total Phone Products: <?php echo $database_phone_products; ?>
                    </a></h6>
            </div>

            <!-- Laptop products -->
            <div class="col-md-4">
                <h4>Laptop Products</h4>
            </div>

            <!-- Recently Added Products -->
            <div class="col-md-4">
                <h4>Recently Added Products</h4>
                <h6><a href="">
                        <?php
                            $sql = $pdo->prepare("SELECT * FROM recently_added_products");
                            $sql->execute();
                            $database_recently_added_products = $sql->rowCount();
                        ?>
                        Total Recently Added products: <?php echo $database_recently_added_products; ?>
                    </a></h6>
            </div>

            <!-- All Products -->
            <div class="col-md-4 my-4">
                <h4>All Products</h4>
                <a href="index.php?page=administrator/all_products">All Products</a>
            </div>
            
            <!-- Product Types -->
            <div class="col-md-4 my-4">
                <h4>Product Types</h4>
                <h6><a href="index.php?page=administrator/all_product_types">
                    <!-- Prepare a SELECT query to get the number of all product types from the database -->
                    <?php 
                        $sql = $pdo->prepare("SELECT * FROM product_types");
                        $sql->execute();
                        $database_product_types = $sql->rowCount();
                    ?>
                    Total Product Types: <?php echo $database_product_types ?>
                    </a></h6>
            </div>

            <!-- All product Brands -->
            <div class="col-md-4 my-4">
                <h4>Product Brands</h4>
                <a href="index.php?page=administrator/all_product_brands">All Product Brands</a>
            </div>
        </div>
    </div>
</div>

<?= footerTemplate(); ?>