<?php

// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productTypeName = "";
$productTypeName_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate user input
    if (empty(trim($_POST['productTypeName']))) {
        $productTypeName_error = "Field is required!";
    } else {
        $productTypeName = trim($_POST['productTypeName']);
    }

    // Check for errors before dealing with the database
    if (empty($productTypeName_error)) {
        // Prepare an UPDATE statement
        $sql = "UPDATE product_types SET productType = :productTypeName WHERE id = '" . $_GET['id'] . "'";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":productTypeName", $param_productTypeName, PDO::PARAM_STR);
            // Set parameters
            $param_productTypeName = $productTypeName;
            // Attempt to execute
            if ($stmt->execute()) {
                echo "<script>alert('Product type name has been updated successfully!');</script>";
            } else {
                $productTypeName_error = "There was an error. Please try again!";
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | SINGLE_PRODUCT_TYPE'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<!-- Fetch Product type name from the database -->
<?php
$sql = "SELECT productType FROM product_types WHERE id = '" . $_GET['id'] . "'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$database_product_type = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach ($database_product_type as $product_type) : ?>
    <div class="section-title" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <h5><span><?= $product_type['productType']; ?></span> Product Type</h5>
            </div>
        </div>
    </div>
<?php endforeach ?>

<div class="container">
    <div id="add_product_type">
        <div class="row">
            <div class="col-md-5">
                <form action="#" method="post" class="add_product_type_form">
                    <div class="form-group">
                        <label for="ProductTypeName">Product Type Name</label>
                        <input type="text" name="productTypeName" value="<?= $product_type['productType']; ?>" class="form-control 
                        <?php echo (!empty($productTypeName_error)) ? 'is-invalid' : ''; ?>" placeholder="Product Type Name">
                        <span class="errors text-danger"><?php echo $productTypeName_error; ?></span>
                    </div>

                    <div class="form-group my-3">
                        <input type="submit" value="Update Product Type Name" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>