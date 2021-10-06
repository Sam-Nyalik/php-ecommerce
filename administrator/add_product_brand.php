<?php

// start a session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productBrand = $success = "";
$productBrand_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product brand input
    if (empty(trim($_POST['productBrand']))) {
        $productBrand_error = "Product Brand field is required!";
    } else {
        // Check if the product brand already exists
        // Prepare a SELECT statement to the database to check the row count
        $sql = "SELECT * FROM product_brands WHERE productBrand = :productBrand";

        if ($stmt = $pdo->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
            // Set parameters
            $param_productBrand = trim($_POST["productBrand"]);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $productBrand_error = "Product Brand already exists!";
                } else {
                    $productBrand = trim($_POST["productBrand"]);
                }
            } else {
                $productBrand_error = "There was an error. Please try again!";
            }

            // Close the statement 
            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($productBrand_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO product_brands(productBrand) VALUES(:productBrand)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
            // Set parameters
            $param_productBrand = $productBrand;
            // Attempt to execute
            if ($stmt->execute()) {
                // Echo a success message
                $success = "The product brand has been added successfully!";
            } else {
                $productBrand_error = "There was an error. Please try again!";
            }

            //Close the prepared statement
            unset($stmt);
        }
    }
}

?>

<!-- Header template -->
<?= headerTemplate('ADMIN | ADD_PRODUCT_BRAND'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Add Product Brand</h5>
        </div>
    </div>
</div>

<!-- Add Product Brand -->
<div class="container">
    <div id="add_product_type">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/add_product_brand" method="post" class="add_product_type_form">
                    <!-- Success Message -->
                    <div class="form-group">
                        <span class="text-success">
                            <ul>
                                <li><?php 
                                    if($success){
                                        echo $success;
                                    }
                                ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- General Error -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <li><?php
                                    if ($productBrand_error) {
                                        echo $productBrand_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- Product Brand -->
                    <div class="form-group">
                        <label for="ProductBrand">Product Brand</label>
                        <input type="text" name="productBrand" value="<?php echo $productBrand ?>" class="form-control 
                        <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Product Brand" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Footer Template -->
<?= footerTemplate(); ?>