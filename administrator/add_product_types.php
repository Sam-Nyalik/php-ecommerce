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
$addType = $success = "";
$addType_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate add product type input
    if (empty(trim($_POST['addType']))) {
        $addType_error = "Add Product Type Field is required!";
    } else {
        // check whether the product type already exists
        // Prepare a SELECT statement
        $sql = "SELECT * FROM product_types WHERE productType = :addType";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":addType", $param_addType, PDO::PARAM_STR);
            // Set parameters
            $param_addType = trim($_POST['addType']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $addType_error = "This product type already exists!";
                } else {
                    $addType = trim($_POST['addType']);
                }
            } else {
                $addType_error = "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($addType_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO product_types(productType) VALUES(:addType)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":addType", $param_addType, PDO::PARAM_STR);
            // Set parameters
            $param_addType = $addType;
            // Attempt to execute
            if ($stmt->execute()) {
                header("location: index.php?page=administrator/all_product_types");
                $success = "The product type has been added successfully!";
            } else {
                $addType_error = "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
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
            <h5>Add a Product Type</h5>
        </div>
    </div>
</div>

<!-- Add Product type -->
<div class="container">
    <div id="add_product_type">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/add_product_types" method="post" class="add_product_type_form">
                    <!-- Success Message -->
                    <div class="form-group">
                        <span class="text-success">
                            <ul>
                                <li><?php
                                    if ($success) {
                                        echo $success;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- General errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <li><?php
                                    if ($addType_error) {
                                        echo $addType_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- Add Type -->
                    <div class="form-group">
                        <label for="addType">Add Type</label>
                        <input type="text" name="addType" class="form-control 
                        <?php echo (!empty($addType_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Product Type" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>