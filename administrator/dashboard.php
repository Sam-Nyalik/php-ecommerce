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
        <div class="row">
            <div class="col-md-4">
                <h4>Phone Products</h4>
                <h6><a href="index.php?page=administrator/phone_products/all_phone_products">
                        <?php
                        $sql = $pdo->query("SELECT * FROM phone_products");
                        $rowCount = $sql->rowCount();
                        echo "Total Phone Products: " . $rowCount;
                        ?>
                    </a></h6>
            </div>
            <div class="col-md-4">
                <h4>Laptop Products</h4>
            </div>
            <div class="col-md-4">
                <h4>Other Devices</h4>
            </div>
        </div>
    </div>
</div>

<?= footerTemplate(); ?>