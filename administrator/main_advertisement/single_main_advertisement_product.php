<?php

// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// check if the admin is logged in
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

    // Validate Product description
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

    // Validate product Brand
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

    // Check for errors before dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productType_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productPrice_error) && empty($productQuantity_error)) {
        $id = false;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        // Upload the updated image
        if (!empty($_FILES['productImage']['name'])) {
            move_uploaded_file($_FILES['productImage']['tmp_name'], "administrator/allProductImages/" . $_FILES['productImage']['name']);
            $productImage = "administrator/allProductImages/" . $_FILES['productImage']['name'];

            // Prepare an UPDATE statement
            $sql = "UPDATE main_advertisement SET productName = :productName, productDescription = :productDescription, productType = :productType, productBrand = :productBrand, productRetailPrice = :productRetailPrice, productPrice = :productPrice, productQuantity = :productQuantity, productImage = :productImage WHERE id = '$id'";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
                $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
                $stmt->bindParam(":productType", $param_productType, PDO::PARAM_STR);
                $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
                $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_INT);
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
                    $success = "Product has been updated successfully!";
                } else {
                    $general_error = "There was an error. Please try again!";
                }

                // Close the prepared statement
                unset($stmt);
            }
        }
    }
}

// Prepare a SELECT statement to fetch details about the advertisement product with the specified GET id
$id = false;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$sql = $pdo->prepare("SELECT * FROM main_advertisement WHERE id = '$id'");
$sql->execute();
$database_single_advertisement = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | SINGLE_MAIN_ADVERTISEMENT_PRODUCT'); ?>

<!-- Main Navigation -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<?php foreach ($database_single_advertisement as $single_advertisement) : ?>

    <!-- Section Title -->
    <div class="section-title" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <h5><span>Edit</span> <?= $single_advertisement['productName']; ?></h5>
            </div>
        </div>
    </div>

    <!-- Individual Product -->
    <div id="individual_product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= $single_advertisement['productImage']; ?>" alt="<?= $single_advertisement['productName']; ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <form action="#" method="post" enctype="multipart/form-data" class="individual_product_form">
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

                                    <!-- General Error -->
                                    <li><?php 
                                        if($general_error){
                                            echo $general_error;
                                        }
                                    ?></li>
                                </ul>
                            </span>
                        </div>
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" name="productName" value="<?= $single_advertisement['productName']; ?>" class="form-control 
                            <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Product Description -->
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
                            <textarea name="productDescription" class="form-control w-100"><?= $single_advertisement['productDescription']; ?></textarea>
                        </div>

                        <!-- Product Type -->
                        <div class="form-group">
                            <label for="productType">Product Type</label>
                            <select name="productType" class="form-control">
                                <option value="Select Product Type" disabled>Select Product Type
                                <option value="<?= $single_advertisement['productType']; ?>" disabled><?= $single_advertisement['productType']; ?></option>
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
                            <label for="productBrand">Product Brand</label>
                            <select name="productBrand" class="form-control">
                                <option value="Select a Product Brand" disabled>Select a Product Brand
                                    <!-- Prepare a SELECT statement to fetch product brands from the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM product_brands");
                                    $sql->execute();
                                    $database_product_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                <option value="<?= $single_advertisement['productBrand']; ?>" disabled><?= $single_advertisement['productBrand']; ?></option>
                                <?php foreach ($database_product_brands as $product_brands) : ?>
                                    <option value="<?= $product_brands['productBrand']; ?>"><?= $product_brands['productBrand']; ?></option>
                                <?php endforeach; ?>
                                </option>
                            </select>
                        </div>

                        <!-- Product Retail Price -->
                        <div class="form-group">
                            <label for="productRetailPrice">Product Retail Price</label>
                            <input type="number" name="productRetailPrice" class="form-control 
                            <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>" value="<?= $single_advertisement['productRetailPrice']; ?>">
                        </div>

                        <!-- Product Price -->
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="number" name="productPrice" class="form-control 
                            <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>" value="<?= $single_advertisement['productPrice']; ?>">
                        </div>

                        <!-- Product Quantity -->
                        <div class="form-group">
                            <label for="productQuantity">Product Quantity</label>
                            <input type="number" name="productQuantity" class="form-control 
                            <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>" value="<?= $single_advertisement['productQuantity']; ?>">
                        </div>

                        <!-- Product Image -->
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" name="productImage" accept=".jpg, .jpeg, .png" class="form-control 
                            <?php echo (!empty($productImage_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Update Btn -->
                        <div class="form-group my-3">
                            <input type="submit" value="Update Advertisement" class="btn w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



<?php endforeach; ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>