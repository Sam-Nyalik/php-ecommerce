<?php
// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productName = $productDescription = $productBrand = $productRetailPrice = $productPrice = $productQuantity = $productMemory = $productStorage = $productBatteryCapacity = $productDisplay = $productRearCamera = $productFrontCamera = $productNetwork = $productWeight = $productImage1 = $productImage2 = $productImage3 = "";
$productName_error = $productDescription_error = $productBrand_error = $productRetailPrice_error = $productPrice_error = $productQuantity_error = $productMemory_error = $productStorage_error = $productBatteryCapacity_error = $productDisplay_error = $productRearCamera_error = $productFrontCamera_error = $productNetwork_error = $productWeight_error = $productImage1_error = $productImage2_error = $productImage3_error = "";
// Fetch the product from the database
$phoneId = false;
if (isset($_GET['id'])) {
    $phoneId = $_GET['id'];
}

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product name
    if (empty(trim($_POST["productName"]))) {
        $productName_error = "Product name Field is required!";
    } else {
        $productName = trim($_POST["productName"]);
    }

    // Validate product description
    if (empty(trim($_POST["productDescription"]))) {
        $productDescription_error = "Product description field is required!";
    } else {
        $productDescription = trim($_POST["productDescription"]);
    }

    // Validate product brand
    if (empty($_POST["productBrand"])) {
        $productBrand_error = "Product brand field is required!";
    } else {
        $productBrand = $_POST["productBrand"];
    }

    // Validate product retail price
    if (empty(trim($_POST["productRetailPrice"]))) {
        $productRetailPrice_error = "Product retail price field is required!";
    } else {
        $productRetailPrice = trim($_POST["productRetailPrice"]);
    }

    // Validate product price
    if (empty(trim($_POST["productPrice"]))) {
        $productPrice_error = "Product price field is required!";
    } else {
        $productPrice = trim($_POST["productPrice"]);
    }

    // Validate product quantity
    if (empty(trim($_POST["productQuantity"]))) {
        $productQuantity_error = "Product quantity field is required!";
    } else {
        $productQuantity = trim($_POST["productQuantity"]);
    }

    // Validate product memory
    if (empty(trim($_POST['productMemory']))) {
        $productMemory_error = "Field is required!";
    } else {
        $productMemory = trim($_POST["productMemory"]);
    }

    // Validate product storage
    if (empty(trim($_POST['productStorage']))) {
        $productStorage_error = "Field is required!";
    } else {
        $productStorage = trim($_POST['productStorage']);
    }

    // Validate product capacity
    if (empty(trim($_POST['productBatteryCapacity']))) {
        $productBatteryCapacity_error = "Field is required!";
    } else {
        $productBatteryCapacity = trim($_POST['productBatteryCapacity']);
    }

    // Validate product display
    if (empty(trim($_POST['productDisplay']))) {
        $productDisplay_error = "Field is required!";
    } else {
        $productDisplay = trim($_POST['productDisplay']);
    }

    // Validate product rear camera
    if (empty(trim($_POST['productRearCamera']))) {
        $productRearCamera_error = "Field is required!";
    } else {
        $productRearCamera = trim($_POST["productRearCamera"]);
    }

    // Validate product front camera
    if (empty(trim($_POST['productFrontCamera']))) {
        $productFrontCamera_error = "Field is required!";
    } else {
        $productFrontCamera = trim($_POST["productFrontCamera"]);
    }

    // Validate product weight
    if (empty(trim($_POST['productWeight']))) {
        $productWeight_error = "Field is required!";
    } else {
        $productWeight = trim($_POST['productWeight']);
    }

    // Validate product network
    if (empty(trim($_POST['productNetwork']))) {
        $productNetwork_error = "Field is required!";
    } else {
        $productNetwork = trim($_POST['productNetwork']);
    }


    // Check for errors before dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productPrice_error) && empty($productQuantity_error) && empty($productMemory_error) && empty($productStorage_error) && empty($productBatteryCapacity_error) && empty($productDisplay_error) && empty($productRearCamera_error) && empty($productFrontCamera_error) && empty($productNetwork_error) && empty($productWeight_error)) {
        // Deal  with the 1st product image
        if (!empty($_FILES['productImage1']['name'])) {
            move_uploaded_file($_FILES['productImage1']['tmp_name'], "administrator/allProductImages/" . $_FILES['productImage1']['name']);
            $productImage1 = "administrator/allProductImages/" . $_FILES['productImage1']['name'];

            // Deal with the 2nd product image
            if (!empty($_FILES['productImage2']['name'])) {
                move_uploaded_file($_FILES['productImage2']['tmp_name'], "administrator/allProductImages/" . $_FILES['productImage2']['name']);
                $productImage2 = "administrator/allProductImages/" . $_FILES['productImage2']['name'];

                // Deal with the 3rd product image
                if (!empty($_FILES['productImage3']['name'])) {
                    move_uploaded_file($_FILES['productImage3']['tmp_name'], "administrator/allProductImages/" . $_FILES['productImage3']['name']);
                    $productImage3 = "administrator/allProductImages/" . $_FILES['productImage3']['name'];

                    // Prepare an update statement
                    $sql = "UPDATE all_products SET productName = :productName, productDescription = :productDescription, productBrand = :productBrand, productRetailPrice = :productRetailPrice, productPrice = :productPrice, productQuantity = :productQuantity, productImage1 = :productImage1, storage = :productStorage, battery = :productBatteryCapacity, display = :productDisplay, rearCamera = :productRearCamera, frontCamera = :productFrontCamera, network = :productNetwork, weight = :productWeight, memory = :productMemory, productImage2 = :productImage2, productImage3 = :productImage3 WHERE productType = 'Mobile Phone' AND id = :id";

                    if ($stmt = $pdo->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
                        $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
                        $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
                        $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_STR);
                        $stmt->bindParam(":productPrice", $param_productPrice, PDO::PARAM_STR);
                        $stmt->bindParam(":productQuantity", $param_productQuantity, PDO::PARAM_INT);
                        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
                        $stmt->bindParam(":productImage1", $param_productImage1, PDO::PARAM_STR);
                        $stmt->bindParam(":productStorage", $param_productStorage, PDO::PARAM_STR);
                        $stmt->bindParam(":productBatteryCapacity", $param_productBatteryCapacity, PDO::PARAM_STR);
                        $stmt->bindParam(":productDisplay", $param_productDisplay, PDO::PARAM_STR);
                        $stmt->bindParam(":productRearCamera", $param_productRearCamera, PDO::PARAM_STR);
                        $stmt->bindParam(":productFrontCamera", $param_productFrontCamera, PDO::PARAM_STR);
                        $stmt->bindParam(":productNetwork", $param_productNetwork, PDO::PARAM_STR);
                        $stmt->bindParam(":productWeight", $param_productWeight, PDO::PARAM_STR);
                        $stmt->bindParam(":productMemory", $param_productMemory, PDO::PARAM_STR);
                        $stmt->bindParam(":productImage2", $param_productImage2, PDO::PARAM_STR);
                        $stmt->bindParam(":productImage3", $param_productImage3, PDO::PARAM_STR);

                        // Set parameters
                        $param_productName = $productName;
                        $param_productDescription = $productDescription;
                        $param_productBrand = $productBrand;
                        $param_productRetailPrice = $productRetailPrice;
                        $param_productPrice = $productPrice;
                        $param_productQuantity = $productQuantity;
                        $param_id = $phoneId;
                        $param_productImage1 = $productImage1;
                        $param_productStorage = $productStorage;
                        $param_productBatteryCapacity = $productBatteryCapacity;
                        $param_productDisplay = $productDisplay;
                        $param_productRearCamera = $productRearCamera;
                        $param_productFrontCamera = $productFrontCamera;
                        $param_productNetwork = $productNetwork;
                        $param_productWeight = $productWeight;
                        $param_productMemory = $productMemory;
                        $param_productImage2 = $productImage2;
                        $param_productImage3 = $productImage3;

                        // Attempt to execute
                        if ($stmt->execute()) {
                            echo "<script>alert('Phone product has been updated successfully!');</script>";
                        } else {
                            echo "There was an error. Please try again!";
                        }

                        // Close the statement
                        unset($stmt);
                    }
                } else {
                    $productImage3 = $_POST["oldProductImage3"];
                }
            } else {
                $productImage2 = $_POST["oldProductImage2"];
            }
        } else {
            $productImage1 = $_POST["oldProductImage1"];
        }
    }
}

?>

<?= headerTemplate('ADMIN | SINGLE_PHONE_PRODUCT'); ?>

<?php include_once "administrator/includes/main_navbar.php"; ?>

<!-- <div id="breadcrumb">
    <div class="container">
        <div class="row">
            <h5><a href="">Back</a></h5>
        </div>
    </div>
</div> -->
<?php
// Fetch the product from the database
$id = false;
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
}
$sql = $pdo->prepare("SELECT * FROM all_products WHERE productType = 'Mobile Phone' AND id = '$id'");
$sql->execute();
$database_individual_phone_products = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach ($database_individual_phone_products as $individual_product) : ?>
    <!-- Section title -->
    <div class="section-title" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <h5>Edit <?= $individual_product['productName']; ?></h5>
            </div>
        </div>
    </div>

    <div id="individual_product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= $individual_product['productImage1']; ?>" class="img-fluid" style="height: 500px; width: 100%" alt="<?= $individual_product['productName']; ?>">

                    <div class="row my-3">
                        <h3 style="font-size: 18px; text-transform: capitalize;">Other Product Images</h3>
                        <div class="col-3">
                            <img src="<?= $individual_product['productImage2']; ?>" alt="" class="img-fluid">
                        </div>

                        <div class="col-3">
                            <img src="<?= $individual_product['productImage3']; ?>" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="#" method="post" class="individual_product_form" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Product Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input type="text" name="productName" placeholder="Enter Product Name" value="<?= $individual_product['productName']; ?>" class="form-control 
                            <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productName_error; ?></span>
                                </div>

                            </div>

                            <!-- Product Memory -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productMemory">Product Memory</label>
                                    <input type="text" name="productMemory" placeholder="Enter Product memory" value="<?= $individual_product['memory']; ?>" class="form-control 
                                    <?php echo (!empty($productMemory_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productMemory_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Brand -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productBrand">Product Brand</label>
                                    <select name="productBrand" class="form-control 
                            <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                                        <option value="" disabled>Select Product Brand
                                            <?php
                                            $sql = $pdo->prepare("SELECT * FROM product_brands");
                                            $sql->execute();
                                            $database_phone_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                        <option value="<?= $individual_product['productBrand']; ?>" disabled><?= $individual_product['productBrand']; ?></option>
                                        <?php foreach ($database_phone_brands as $brand) : ?>
                                            <option value="<?= $brand['productBrand']; ?>">
                                                <?= $brand['productBrand']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        </option>
                                    </select>
                                    <span class="errors text-danger"><?php echo $productBrand_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Retail Price -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productRetailPrice">Product Retail Price</label>
                                    <input type="text" name="productRetailPrice" placeholder="Enter Product Retail Price" value="<?= $individual_product['productRetailPrice']; ?>" class="form-control 
                            <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productRetailPrice_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Price -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productPrice">Product Price</label>
                                    <input type="text" name="productPrice" placeholder="Enter Product Price" value="<?= $individual_product['productPrice']; ?>" class="form-control 
                            <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productPrice_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Quantity -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productQuantity">Product Quantity</label>
                                    <input type="number" name="productQuantity" placeholder="Enter Product Quantity" value="<?= $individual_product['productQuantity']; ?>" class="form-control 
                            <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productQuantity_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Storage -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productStorage">Product Storage</label>
                                    <input type="text" name="productStorage" placeholder="Enter Product Storage" value="<?= $individual_product['storage']; ?>" class="form-control 
                                    <?php echo (!empty($productStorage_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productStorage_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Battery Capacity -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ProductBatteryCapacity">Product Battery Capacity</label>
                                    <input type="text" name="productBatteryCapacity" placeholder="Enter Product capacity" value="<?= $individual_product['battery']; ?>" class="form-control 
                                    <?php echo (!empty($productBatteryCapacity_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productBatteryCapacity_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Display -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productDisplay">Product Display</label>
                                    <input type="text" name="productDisplay" placeholder="Enter Product Display" value="<?= $individual_product['display']; ?>" class="form-control 
                                    <?php echo (!empty($productDisplay_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productDisplay_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Rear Camera -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productRearCamera">Product Rear Camera</label>
                                    <input type="text" name="productRearCamera" placeholder="Enter Product Rear Camera Specs" value="<?= $individual_product['rearCamera']; ?>" class="form-control 
                                    <?php echo (!empty($productRearCamera_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productRearCamera_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Front Camera -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ProductFrontCamera">Product Front Camera</label>
                                    <input type="text" name="productFrontCamera" placeholder="Enter Product Front Camera Specs" value="<?= $individual_product['frontCamera']; ?>" class="form-control 
                                    <?php echo (!empty($productFrontCamera_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productFrontCamera_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Network -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productNetwork">Product Network</label>
                                    <input type="text" name="productNetwork" placeholder="Enter Product network Specs" value="<?= $individual_product['network']; ?>" class="form-control 
                                    <?php echo (!empty($productNetwork_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productNetwork_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Weight -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ProductWeight">Product Weight</label>
                                    <input type="text" name="productWeight" placeholder="Enter Product Weight" value="<?= $individual_product['weight']; ?>" class="form-control 
                                    <?php echo (!empty($productWeight_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors text-danger"><?php echo $productWeight_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Image 1 -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ProductImage1">Product Image 1</label>
                                    <input type="file" name="productImage1" class="form-control 
                                    <?php echo (!empty($productImage1_error)) ? 'is-invalid' : ''; ?>" />
                                    <span class="productImage_description" name="oldProductImage1" value="<?php echo $individual_product['productImage1']; ?>"><?php echo $individual_product['productImage1']; ?></span>
                                    <span class="errors text-danger"><?php echo $productImage1_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Image 2 -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ProductImage2">Product Image 2</label>
                                    <input type="file" name="productImage2" class="form-control 
                                    <?php echo (!empty($productImage2_error)) ? 'is-invalid' : ''; ?>" />
                                    <span class="productImage_description" name="oldProductImage2" value="<?php echo $individual_product['productImage2']; ?>"><?php echo $individual_product['productImage2']; ?></span>
                                    <span class="errors text-danger"><?php echo $productImage2_error; ?></span>
                                </div>
                            </div>

                            <!-- Product Image 3 -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productImage3">Product Image 3</label>
                                    <input type="file" name="productImage3" class="form-control 
                                    <?php echo (!empty($productImage3_error)) ? 'is-invalid' : ''; ?>" />
                                    <span class="productImage_description" name="oldProductImage3" value="<?php echo $individual_product['productImage3']; ?>"><?php echo $individual_product['productImage3']; ?></span>
                                    <span class="errors text-danger"><?php echo $productImage3_error; ?></span>
                                </div>
                            </div>
                        </div>


                        <!-- Product Description -->
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
                            <textarea name="productDescription" placeholder="enter Product Description" class="w-100 
                            <?php echo (!empty($productDescription_error)) ? 'is-invalid' : ''; ?>"><?= $individual_product['productDescription']; ?></textarea>
                            <span class="errors text-danger"><?php echo $productDescription_error; ?></span>
                        </div>

                        <!-- Update button -->
                        <div class="form-group my-3">
                            <input type="submit" value="Update Product" class="btn w-100">
                        </div>

                        <!-- Delete button -->
                        <div class="form-group my-3">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?= footerTemplate(); ?>