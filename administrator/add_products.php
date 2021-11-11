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
$productName = $productDescription = $productType = $productBrand = $productRetailPrice = $productPrice = $productQuantity = $productImage1 = $productStorage = $productBatteryCapacity = $productDisplay = $productRearCamera = $productFrontCamera = $productNetwork = $productWeight = $productColor1 = $productColor2 = $productColor3 = $productMemory = $productImage2 = $productImage3 = $success = "";
$productName_error = $productDescription_error = $productType_error = $productBrand_error = $productRetailPrice_error = $productPrice_error = $productQuantity_error = $productImage1_error = $productStorage_error = $productBatteryCapacity_error = $productDisplay_error = $productRearCamera_error = $productFrontCamera_error = $productNetwork_error = $productWeight_error = $productColor1_error = $productColor2_error = $productColor3_error = $productMemory_error = $productImage2_error = $productImage3_error = $general_error =  "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Product Name
    if (empty(trim($_POST["productName"]))) {
        $productName_error = "Field is required!";
    } else {
        $productName = trim($_POST["productName"]);
    }

    // Validate Product Description
    if (empty(trim($_POST["productDescription"]))) {
        $productDescription_error = "Field is required!";
    } else {
        $productDescription = trim($_POST["productDescription"]);
    }

    // Validate Product Type
    if (empty($_POST["productType"])) {
        $productType_error = "Field is required!";
    } else {
        $productType = $_POST["productType"];
    }

    // Validate Product Brand
    if (empty($_POST["productBrand"])) {
        $productBrand_error = "Field is required!";
    } else {
        $productBrand = $_POST["productBrand"];
    }

    // Validate Product Retail Price
    if (empty(trim($_POST["productRetailPrice"]))) {
        $productRetailPrice_error = "Field is required!";
    } else {
        $productRetailPrice = trim($_POST["productRetailPrice"]);
    }

    // Validate Product Price
    if (empty(trim($_POST["productPrice"]))) {
        $productPrice_error = "Field is required!";
    } else {
        $productPrice = trim($_POST["productPrice"]);
    }

    // Validate Product Quantity
    if (empty(trim($_POST["productQuantity"]))) {
        $productQuantity_error = "Field is required!";
    } else {
        $productQuantity = trim($_POST["productQuantity"]);
    }

    // Validate Product Storage Capacity
    if (empty(trim($_POST['productStorage']))) {
        $productStorage_error = "Field is required!";
    } else {
        $productStorage = trim($_POST['productStorage']);
    }

    // Validate Product Battery Capacity
    if (empty(trim($_POST['batteryCapacity']))) {
        $productBatteryCapacity_error = "Field is required!";
    } else {
        $productBatteryCapacity = trim($_POST['batteryCapacity']);
    }

    // Validate Product Display
    if (empty(trim($_POST['productDisplay']))) {
        $productDisplay_error = "Field is required!";
    } else {
        $productDisplay = trim($_POST['productDisplay']);
    }

    // Validate Product Front Camera
    if (empty(trim($_POST['productFrontCamera']))) {
        $productFrontCamera_error = "Field is required!";
    } else {
        $productFrontCamera = trim($_POST['productFrontCamera']);
    }

    // Validate Product Rear Camera
    if (empty(trim($_POST['productRearCamera']))) {
        $productRearCamera_error = "Field is required!";
    } else {
        $productRearCamera = trim($_POST['productRearCamera']);
    }

    // Validate Product Weight
    if (empty(trim($_POST['productWeight']))) {
        $productWeight_error = "Field is required!";
    } else {
        $productWeight = trim($_POST['productWeight']);
    }

    // Validate Product Network
    if (empty(trim($_POST['productNetwork']))) {
        $productNetwork_error = "Field is required!";
    } else {
        $productNetwork = trim($_POST['productNetwork']);
    }

    // Validate Product Color 1
    if (empty($_POST['productColor1'])) {
        $productColor1_error = "Field is required!";
    } else {
        $productColor1 = $_POST['productColor1'];
    }

    // Validate Product Color 2
    if (empty($_POST['productColor2'])) {
        $productColor2_error = "Field is required!";
    } else {
        $productColor2 = $_POST['productColor2'];
    }

    // Validate Product Color 3
    if (empty($_POST['productColor3'])) {
        $productColor3_error = "Field is required!";
    } else {
        $productColor3 = $_POST['productColor3'];
    }

    // Validate Product Memory
    if (empty(trim($_POST['productMemory']))) {
        $productMemory_error = "Field is required!";
    } else {
        $productMemory = trim($_POST['productMemory']);
    }

    // Check for errors before dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productType_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productQuantity_error) && empty($productPrice_error) && empty($productStorage_error) && empty($productBatteryCapacity_error) && empty($productDisplay_error) && empty($productRearCamera_error) && empty($productFrontCamera_error) && empty($productNetwork_error) && empty($productWeight_error) && empty($productColor1_error) && empty($productColor2_error) && empty($productColor3_error) && empty($productMemory_error)) {
        // Upload product image 1
        if (!empty($_FILES["productImage1"]["name"])) {
            move_uploaded_file($_FILES["productImage1"]["tmp_name"], "administrator/allProductImages/" . $_FILES["productImage1"]["name"]);
            $productImage1 = "administrator/allProductImages/" . $_FILES["productImage1"]["name"];

            // Upload product image 2
            if (!empty($_FILES["productImage2"]["name"])) {
                move_uploaded_file($_FILES["productImage2"]["tmp_name"], "administrator/allProductImages/" . $_FILES["productImage2"]["name"]);
                $productImage2 = "administrator/allProductImages/" . $_FILES["productImage2"]["name"];

                // Upload product image 3
                if (!empty($_FILES["productImage3"]["name"])) {
                    move_uploaded_file($_FILES["productImage3"]["tmp_name"], "administrator/allProductImages/" . $_FILES["productImage3"]["name"]);
                    $productImage3 = "administrator/allProductImages/" . $_FILES["productImage3"]["name"];

                    // Prepare an INSERT statement
                    $sql = "INSERT INTO all_products(productName, productDescription, productType, productBrand, productRetailPrice, productPrice, productQuantity, productImage1, storage, battery, display, rearCamera, frontCamera, network, weight, color1, color2, color3, memory, productImage2, productImage3) VALUES (
                :productName, :productDescription, :productType, :productBrand, :productRetailPrice, :productPrice, :productQuantity, :productImage1, :productStorage, :productBatteryCapacity, :productDisplay, :productRearCamera, :productFrontCamera, :productNetwork, :productWeight, :productColor1, :productColor2, :productColor3, :productMemory, :productImage2, :productImage3)";

                    if ($stmt = $pdo->prepare($sql)) {
                        //Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
                        $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
                        $stmt->bindParam(":productType", $param_productType, PDO::PARAM_STR);
                        $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
                        $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_STR);
                        $stmt->bindParam(":productPrice", $param_productPrice, PDO::PARAM_STR);
                        $stmt->bindParam(":productQuantity", $param_productQuantity, PDO::PARAM_INT);
                        $stmt->bindParam(":productImage1", $param_productImage1, PDO::PARAM_STR);
                        $stmt->bindParam(":productStorage", $param_productStorage, PDO::PARAM_STR);
                        $stmt->bindParam(":productBatteryCapacity", $param_productBatteryCapacity, PDO::PARAM_STR);
                        $stmt->bindParam(":productDisplay", $param_productDisplay, PDO::PARAM_STR);
                        $stmt->bindParam(":productRearCamera", $param_productRearCamera, PDO::PARAM_STR);
                        $stmt->bindParam(":productFrontCamera", $param_productFrontCamera, PDO::PARAM_STR);
                        $stmt->bindParam(":productNetwork", $param_productNetwork, PDO::PARAM_STR);
                        $stmt->bindParam(":productWeight", $param_productWeight, PDO::PARAM_STR);
                        $stmt->bindParam(":productColor1", $param_productColor1, PDO::PARAM_STR);
                        $stmt->bindParam(":productColor2", $param_productColor2, PDO::PARAM_STR);
                        $stmt->bindParam(":productColor3", $param_productColor3, PDO::PARAM_STR);
                        $stmt->bindParam(":productMemory", $param_productMemory, PDO::PARAM_STR);
                        $stmt->bindParam(":productImage2", $param_productImage2, PDO::PARAM_STR);
                        $stmt->bindParam(":productImage3", $param_productImage3, PDO::PARAM_STR);

                        // Set parameters
                        $param_productName = $productName;
                        $param_productDescription = $productDescription;
                        $param_productType = $productType;
                        $param_productBrand = $productBrand;
                        $param_productRetailPrice = $productRetailPrice;
                        $param_productPrice = $productPrice;
                        $param_productQuantity = $productQuantity;
                        $param_productImage1 = $productImage1;
                        $param_productStorage = $productStorage;
                        $param_productBatteryCapacity = $productBatteryCapacity;
                        $param_productDisplay = $productDisplay;
                        $param_productRearCamera = $productRearCamera;
                        $param_productFrontCamera = $productFrontCamera;
                        $param_productNetwork = $productNetwork;
                        $param_productWeight = $productWeight;
                        $param_productColor1 = $productColor1;
                        $param_productColor2 = $productColor2;
                        $param_productColor3 = $productColor3;
                        $param_productMemory = $productMemory;
                        $param_productImage2 = $productImage2;
                        $param_productImage3 = $productImage3;

                        // Attempt to execute
                        if ($stmt->execute()) {
                            $success = "Product has been added successfully!";
                        } else {
                            $general_error = "There was an error. Please try again!";
                        }

                        // Close the statement
                        unset($stmt);
                    }
                } else {
                    $productImage3_error = "Please upload image 3!";
                }
            } else {
                $productImage2_error = "Please upload image 2!";
            }
        } else {
            $productImage1_error = "Please upload image 1!";
        }
    }
}
?>

<!-- Header template -->
<?= headerTemplate('ADMIN | ADD_PRODUCTS'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Add Products</h5>
        </div>
    </div>
</div>

<!-- Add Products Form -->
<div id="individual_product">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-7">
                <form action="index.php?page=administrator/add_products" method="post" enctype="multipart/form-data" class="individual_product_form">
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

                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductName">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="productName" value="<?php echo $productName; ?>" class="form-control 
                        <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                                <span class=" errors text-danger"><?php echo $productName_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Type -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productType">Product Type <span class="text-danger">*</span></label>
                                <select name="productType" class="form-control <?php echo (!empty($productType_error)) ? 'is-invalid' : ''; ?>">
                                    <option value="" disabled>Choose Product Type</option>
                                    <!-- Prepare a SELECT statement to get all the product types from the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM product_types");
                                    $sql->execute();
                                    $database_product_type = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($database_product_type as $type) : ?>
                                        <option value="<?= $type['productType']; ?>"><?= $type['productType']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="errors text-danger"><?php echo $productType_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Quantity -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productQuantity">Product Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="productQuantity" min="1" value="<?php echo $productQuantity; ?>" class="form-control 
                        <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productQuantity_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Brand -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productBrand">Product Brand <span class="text-danger">*</span></label>
                                <select name="productBrand" class="form-control <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                                    <option value="" disabled>Choose Product Brand</option>
                                    <!-- Prepare a SELECT statement to get all the product brands from the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM product_brands");
                                    $sql->execute();
                                    $database_product_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($database_product_brands as $productBrand) : ?>
                                        <option value="<?= $productBrand['productBrand']; ?>"><?= $productBrand['productBrand']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="errors text-danger"><?php echo $productBrand_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Retail Price -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductRetailPrice">Product Retail Price <span class="text-danger">*</span></label>
                                <input type="text" name="productRetailPrice" value="<?php echo $productRetailPrice; ?>" class="form-control 
                        <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productRetailPrice_error; ?></span>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- Product price -->
                            <div class="form-group">
                                <label for="productPrice">Product Price <span class="text-danger">*</span></label>
                                <input type="text" name="productPrice" value="<?php echo $productPrice; ?>" class="form-control 
                        <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productPrice_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product image 1 -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productImage1">Product Image 1<span class="text-danger">*</span></label>
                                <input type="file" accept=".jpg, .jpeg, .png" name="productImage1" class="form-control 
                        <?php echo (!empty($productImage1_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productImage1_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Internal Storage -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductStorage">Product Storage Capacity <span class="text-danger">*</span></label>
                                <input type="text" name="productStorage" class="form-control 
                                <?php echo (!empty($productStorage_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productStorage_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Image2 -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productImage2">Product Image 2 <span class="text-danger">*</span></label>
                                <input type="file" name="productImage2" accept=".jpg, .jpeg, .png" class="form-control 
                                <?php echo (!empty($productImage2_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productImage2_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Image3 -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productImage3">Product Image 3 <span class="text-danger">*</span></label>
                                <input type="file" name="productImage3" accept=".jpg, .jpeg, .png" class="form-control 
                                <?php echo (!empty($productImage3_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productImage3_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Battery mAH -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Battery Capacity">Product Battery Capacity <span class="text-danger">*</span></label>
                                <input type="text" name="batteryCapacity" class="form-control 
                                <?php echo (!empty($productBatteryCapacity_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productBatteryCapacity_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Display -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductDisplay">Product Display <span class="text-danger">*</span></label>
                                <input type="text" name="productDisplay" class="form-control 
                                <?php echo (!empty($productDisplay_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productDisplay_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Front Camera -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductFrontCamera">Product Front Camera <span class="text-danger">*</span></label>
                                <input type="text" name="productFrontCamera" class="form-control 
                                <?php echo (!empty($productFrontCamera_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productFrontCamera_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Rear Camera -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductRearCamera">Product Rear Camera <span class="text-danger">*</span></label>
                                <input type="text" name="productRearCamera" class="form-control 
                                <?php echo (!empty($productRearCamera_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productRearCamera_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Weight -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductWeight">Product Weight <span class="text-danger">*</span></label>
                                <input type="text" name="productWeight" class="form-control 
                                <?php echo (!empty($productWeight_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productWeight_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Network -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ProductNetwork">Product Network <span class="text-danger">*</span></label>
                                <input type="text" name="productNetwork" class="form-control 
                                <?php echo (!empty($productNetwork_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productNetwork_error; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <!-- Product Color 1 -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="ProductColor1">Product Color 1 <span class="text-danger">*</span></label>
                                <input type="text" name="productColor1" class="form-control 
                                    <?php echo (!empty($productColor1_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productColor1_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Color 2 -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="productColor2">Product Color 2 <span class="text-danger">*</span></label>
                                <input type="text" name="productColor2" class="form-control 
                                    <?php echo (!empty($productColor2_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productColor2_error; ?></span>
                            </div>
                        </div>

                        <!-- Product Color 3 -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="ProductColor3">Product Color 3 <span class="text-danger">*</span></label>
                                <input type="text" name="productColor3" class="form-control 
                                    <?php echo (!empty($productColor3_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $productColor3_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Memory -->
                    <div class="form-group">
                        <label for="Memory">Product Memory(RAM) <span class="text-danger">*</span></label>
                        <input type="text" name="productMemory" class="form-control 
                        <?php echo (!empty($productMemory_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $productMemory_error; ?></span>
                    </div>

                    <!-- Product Description -->
                    <div class="form-group">
                        <label for="productDescription">Product Description <span class="text-danger">*</span></label>
                        <textarea name="productDescription" class="form-control w-100 <?php echo (!empty($productDescription_error)) ? 'is-invalid' : ''; ?>"><?php echo $productDescription; ?></textarea>
                        <span class="errors text-danger"><?php echo $productDescription_error; ?></span>
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add New Product" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer Template -->
<?= footerTemplate(); ?>