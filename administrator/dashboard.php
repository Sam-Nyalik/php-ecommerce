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
        <div class="row g-0 text-center">

            <!-- All Products -->
            <div class="col-md-4">
            <h4>All Products</h4>
                <h6><a href="index.php?page=administrator/all_products">
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM all_products");
                        $sql->execute();
                        $database_all_products = $sql->rowCount();
                        ?>
                        Total Products: <?php echo $database_all_products; ?>
                    </a></h6>
            </div>

            <!-- Laptop products -->
            <div class="col-md-4">
                <h4>Laptop Products</h4>
                <h6><a href="index.php?page=administrator/laptop_products/all_laptop_products">
                        <!-- Prepare a SELECT statement to get the total number of laptop products from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM all_products WHERE productType = 'Laptop'");
                        $sql->execute();
                        $database_laptop_products = $sql->rowCount();
                        ?>
                        Total Laptop Products: <?php echo $database_laptop_products; ?>
                    </a></h6>
            </div>

            <!-- Recently Added Products -->
            <div class="col-md-4">
                <h4>Recently Added Products</h4>
                <h6><a href="index.php?page=administrator/recently_added_products">
                        <!-- Prepare a SELECT statement to get the total number of the recently added products -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM all_products ORDER BY date_added DESC LIMIT 4");
                        $sql->execute();
                        $database_recently_added_products = $sql->rowCount();
                        ?>
                        Total Recently Added products: <?php echo $database_recently_added_products; ?>
                    </a></h6>
            </div>

            <!-- Phone Products -->
            <div class="col-md-4 my-4">
            <h4>Phone Products</h4>
                <h6><a href="index.php?page=administrator/phone_products/all_phone_products">
                        <!-- Prepare a SELECT Query to get all the phone products from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM all_products WHERE productType = 'Mobile phone'");
                        $sql->execute();
                        $database_phone_products = $sql->rowCount();
                        ?>
                        Total Phone Products: <?php echo $database_phone_products; ?>
                    </a></h6>
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
                <h6><a href="index.php?page=administrator/all_product_brands">
                <!-- Prepare SELECT statement to get the total number of product brands from the database -->
                <?php 
                    $sql = $pdo->prepare("SELECT * FROM product_brands");
                    $sql->execute();
                    $database_product_brands = $sql->rowCount();
                ?>
                Total Product Brands: <?php echo $database_product_brands; ?>
            </a></h6>
            </div>

            <!-- Main Advertisement -->
            <div class="col-md-4 my-4">
                <h4>Main Advertisement</h4>
                <h6><a href="index.php?page=administrator/main_advertisement/main_advertisement_product">
                    <!-- Prepare a SELECT statement to fetch the total number of products in the main_advertisement table in the database -->
                    <?php
                        $sql = $pdo->prepare("SELECT * FROM main_advertisement");
                        $sql->execute();
                        $database_main_advertisement = $sql->rowCount();
                    ?>
                    Total Advertisements: <?php echo $database_main_advertisement; ?>
                </a></h6>
            </div>

            <!-- Total Users -->
            <div class="col-md-4 my-4">
                <h4>Total Users</h4>
                <h6><a href="index.php?page=administrator/users/all_users">
                    <!-- Prepare a  SELECT statement to fetch all the users from the database -->
                    <?php 
                        $sql = $pdo->prepare("SELECT * FROM users WHERE success = '1'");
                        $sql->execute();
                        $database_users = $sql->rowCount();
                    ?>
                    Total Users: <?php echo $database_users; ?>
                </a></h6>
            </div>

            <!-- Total Regions -->
            <div class="col-md-4 my-4">
                <h4>Total Regions</h4>
                <h6><a href="index.php?page=administrator/all_regions">
                <!-- Prepare a SELECT statement to fetch the total number of regions -->
                <?php 
                    $sql = $pdo->prepare("SELECT * FROM region");
                    $sql->execute();
                    $database_region = $sql->rowCount();
                ?>
                Total Regions: <?php echo $database_region; ?>
            </a></h6>
            </div>
        </div>
    </div>
</div>

<?= footerTemplate(); ?>