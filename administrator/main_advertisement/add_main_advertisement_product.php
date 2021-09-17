<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productName = $productDescription = $productType = $productBrand = $productRetailPrice = $productPrice = $productQuantity = $productImage = $success = "";
$productName_error = $productDescription_error = $productType_error = $productBrand_error = $productRetailPrice_error = $productPrice_error = $productQuantity_error = $productImage_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Product Name
    if (empty(trim($_POST["productName"]))) {
        $productName_error = "Product Name field is required!";
    } else {
        $productName = trim($_POST["productName"]);
    }

    // Validate Product Description
    if (empty(trim($_POST["productDescription"]))) {
        $productDescription_error = "Product Description field is required!";
    } else {
        $productDescription = trim($_POST["productDescription"]);
    }

    // Validate Product Type
    if (empty($_POST["productType"])) {
        $productType_error = "Product Type field is required!";
    } else {
        $productType = $_POST["productType"];
    }

    // Validate Product Brand
    if (empty($_POST["productBrand"])) {
        $productBrand_error = "Product Brand field is required!";
    } else {
        $productBrand = $_POST["productBrand"];
    }

    // Validate Product Retail Price
    if (empty(trim($_POST["productRetailPrice"]))) {
        $productRetailPrice_error = "Product Retail Price field is required!";
    } else {
        $productRetailPrice = trim($_POST["productRetailPrice"]);
    }

    // Validate Product Price
    if (empty(trim($_POST["productPrice"]))) {
        $productPrice_error = "Product Price field is required!";
    } else {
        $productPrice = trim($_POST["productPrice"]);
    }

    // Validate Product Quantity
    if (empty(trim($_POST["productQuantity"]))) {
        $productQuantity_error = "Product Quantity field is required!";
    } else {
        $productQuantity = trim($_POST["productQuantity"]);
    }

    // Ensure there are no errors before uploading the image and dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productType_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productPrice_error) && empty($productQuantity_error)) {
        if (!empty($_FILES["productImage"]["name"])) {
            move_uploaded_file($_FILES["productImage"]["tmp_name"], "administrator/allProductImages/" . $_FILES["productImage"]["name"]);
            $productImage = "administrator/allProductImages/" . $_FILES["productImage"]["name"];

            // Prepare an INSERT statement to the main_advertisement table in the database
            $sql = "INSERT INTO main_advertisement(productName, productDescription, productType, productBrand, productRetailPrice, productPrice, productQuantity, productImage) VALUES(
                :productName, :productDescription, :productType, :productBrand, :productRetailPrice, :productPrice, :productQuantity, :productImage)";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
                $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
                $stmt->bindParam(":productType", $param_productType, PDO::PARAM_STR);
                $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
                $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_STR);
                $stmt->bindParam(":productPrice", $param_productPrice, PDO::PARAM_INT);
                $stmt->bindParam(":productQuantity", $param_productQuantity, PDO::PARAM_INT);
                $stmt->bindParam(":productImage", $param_productImage, PDO::PARAM_STR);

                // Set Parameters
                $param_productName = $productName;
                $param_productDescription = $productDescription;
                $param_productType = $productType;
                $param_productBrand = $productBrand;
                $param_productRetailPrice = $productRetailPrice;
                $param_productPrice = $productPrice;
                $param_productQuantity = $productQuantity;
                $param_productImage = $productImage;

                // Attempt to execute
                if ($stmt->execute()) {
                    $success = "Main advertisement product has been added successfully!";
                } else {
                    $general_error = "There was an error. Please try again!";
                }

                // close the statement
                unset($sql);
            }
        } else {
            $productImage_error = "Upload a product image!";
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD_ADVERTISEMENT_PRODUCT'); ?>

<!-- Main Navbar -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Add Main Advertisement Product</h5>
        </div>
    </div>
</div>

<!-- Add Advertisement Product -->
<div class="container">
    <div id="profile">
        <div class="row my-5">
            <div class="col-md-5">
                <h1>Main Advertisement Product</h1>
                <form action="index.php?page=administrator/main_advertisement/add_main_advertisement_product" method="post" enctype="multipart/form-data" class="profile_form">
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

                    <!-- General Errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- Product Name Error -->
                                <li><?php
                                    if ($productName_error) {
                                        echo $productName_error;
                                    }
                                    ?></li>

                                <!-- Product Description Error -->
                                <li><?php
                                    if ($productDescription_error) {
                                        echo $productDescription_error;
                                    }
                                    ?></li>

                                <!-- Product Type Error -->
                                <li><?php
                                    if ($productType_error) {
                                        echo $productType_error;
                                    }
                                    ?></li>

                                <!-- Product Brand Error -->
                                <li><?php
                                    if ($productBrand_error) {
                                        echo $productBrand_error;
                                    }
                                    ?></li>

                                <!-- Product Retail Price Error -->
                                <li><?php
                                    if ($productRetailPrice_error) {
                                        echo $productRetailPrice_error;
                                    }
                                    ?></li>

                                <!-- Product Price Error -->
                                <li><?php
                                    if ($productPrice_error) {
                                        echo $productPrice_error;
                                    }
                                    ?></li>

                                <!-- Product Quantity Error -->
                                <li><?php
                                    if ($productQuantity_error) {
                                        echo $productQuantity_error;
                                    }
                                    ?></li>

                                <!-- Product Image Error -->
                                <li><?php
                                    if ($productImage_error) {
                                        echo $productImage_error;
                                    }
                                    ?></li>

                                <!-- General Error -->
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="ProductName">Product Name</label>
                        <input type="text" name="productName" class="form-control 
                        <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $productName; ?>">
                    </div>

                    <!-- Product Description -->
                    <div class="form-group">
                        <label for="ProductDescription">Product Description</label>
                        <textarea name="productDescription" class="form-control 
                        <?php echo (!empty($productDescription_error)) ? 'is-invalid' : ''; ?>"><?php echo $productDescription; ?></textarea>
                    </div>

                    <!-- Product Type -->
                    <div class="form-group">
                        <label for="ProductType">Product Type</label>
                        <select name="productType" class="form-control">
                            <option value="Select Product Type" disabled>Select Product Type
                                <!-- Prepare a SELECT statement to fetch all the product types from the database -->
                                <?php
                                $sql = $pdo->prepare("SELECT * FROM product_types");
                                $sql->execute();
                                $database_product_types = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php foreach ($database_product_types as $product_types) : ?>
                            <option value="<?= $product_types['productType']; ?>"><?= $product_types['productType']; ?></option>
                        <?php endforeach; ?>
                        </option>
                        </select>
                    </div>

                    <!-- Product Brand -->
                    <div class="form-group">
                        <label for="ProductBrand">Product Brand</label>
                        <select name="productBrand" class="form-control">
                            <option value="Select Product Brand" disabled>Select Product Brand
                                <!-- Prepare a SELECT statement to fetch product brands from the database -->
                                <?php
                                $sql = $pdo->prepare("SELECT * FROM product_brands");
                                $sql->execute();
                                $database_product_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php foreach ($database_product_brands as $product_brands) : ?>
                            <option value="<?= $product_brands['productBrand']; ?>"><?= $product_brands['productBrand']; ?></option>
                        <?php endforeach; ?>
                        </option>
                        </select>
                    </div>

                    <!-- Product Retail Price -->
                    <div class="form-group">
                        <label for="ProductRetailPrice">Product Retail Price</label>
                        <input type="number" name="productRetailPrice" class="form-control 
                        <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>" min="1" value="<?php echo $productRetailPrice; ?>">
                    </div>

                    <!-- Product Price -->
                    <div class="form-group">
                        <label for="ProductPrice">Product Price</label>
                        <input type="number" name="productPrice" class="form-control 
                        <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>" min="1" value="<?php echo $productPrice; ?>">
                    </div>

                    <!-- Product Quantity -->
                    <div class="form-group">
                        <label for="ProductQuantity">Product Quantity</label>
                        <input type="number" name="productQuantity" class="form-control 
                        <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>" min="1" value="<?php echo $productQuantity; ?>">
                    </div>

                    <!-- Product Image -->
                    <div class="form-group">
                        <label for="ProductImage">Product Image</label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="productImage" class="form-control 
                        <?php echo (!empty($productImage_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Product" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>