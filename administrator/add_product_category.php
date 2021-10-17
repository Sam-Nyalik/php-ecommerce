<?php
// Start a session
session_start();

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is loggedin 
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$product_category = $success = "";
$product_category_error = $general_error = "";

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate Add Product Category input
    if (empty(trim($_POST['product_category']))) {
        $product_category_error = "Field is required!";
    } else {
        // Check if the product already exists
        $sql = "SELECT * from product_categories WHERE product_category = :product_category";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":product_category", $param_product_category, PDO::PARAM_STR);
            // Set parameters
            $param_product_category = trim($_POST['product_category']);
            // Attempt to execute
            if ($stmt->execute()) {
                // Check if there is more than one product in the database with the same name
                if ($stmt->rowCount() == 1) {
                    $general_error = "Product already exists!";
                } else {
                    $product_category = trim($_POST['product_category']);
                }
            } else {
                $general_error = "There was an error. Please try again!";
            }
        }

        // Close the prepared statement
        unset($stmt);
    }

    // Check for errors before dealing with the database
    if (empty($product_category_error) && empty($general_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO product_categories(product_category) VALUES(:product_category)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":product_category", $param_product_category, PDO::PARAM_STR);
            // Set parameters
            $param_product_category = $product_category;
            // Attempt to execute
            if ($stmt->execute()) {
                $success = "Product Category has been added successfully!";
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the prepared statement
            unset($stmt);
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD_PRODUCT_CATEGORY'); ?>

<!-- Main admin navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Add Product</span> Category</h5>
        </div>
    </div>
</div>

<!-- Add Product Category -->
<div class="container">
    <div id="add_product_type">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/add_product_category" method="post" class="add_product_type_form">
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

                    <!-- General Error -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="AddProductCategory">Product Category</label>
                        <input type="text" name="product_category" class="form-control 
                        <?php echo (!empty($product_category_error)) ? 'is-invalid' : ''; ?>">
                        <span class="text-danger"><?php echo $product_category_error; ?></span>
                    </div>

                    <!-- Add Button -->
                    <div class="form-group py-3">
                        <input type="submit" value="Add Product Category" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?= footerTemplate(); ?>