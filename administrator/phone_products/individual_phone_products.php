<?php
// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productName = $productDescription = $productBrand = $productRetailPrice = $productPrice = $productQuantity =  "";
$productName_error = $productDescription_error = $productBrand_error = $productRetailPrice_error = $productPrice_error = $productQuantity_error = "";
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

    // Check for errors before dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productPrice_error) && empty($productQuantity_error)) {
        // Prepare an update statement

        $sql = "UPDATE all_products SET productName = :productName, productDescription = :productDescription, productBrand = :productBrand, productRetailPrice = :productRetailPrice, productPrice = :productPrice, productQuantity = :productQuantity WHERE productType = 'Mobile Phone' AND id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
            $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
            $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
            $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_INT);
            $stmt->bindParam(":productPrice", $param_productPrice, PDO::PARAM_INT);
            $stmt->bindParam(":productQuantity", $param_productQuantity, PDO::PARAM_INT);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set parameters
            $param_productName = $productName;
            $param_productDescription = $productDescription;
            $param_productBrand = $productBrand;
            $param_productRetailPrice = $productRetailPrice;
            $param_productPrice = $productPrice;
            $param_productQuantity = $productQuantity;
            $param_id = $phoneId;
            // Attempt to execute
            if ($stmt->execute()) {
                echo "<script>alert('Phone product has been updated successfully!');</script>";
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }
}

?>

<?= headerTemplate('ADMIN | INDIVIDUAL_PHONE_PRODUCT'); ?>

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
                    <img src="<?= $individual_product['productImage']; ?>" class="img-fluid" alt="<?= $individual_product['productName']; ?>">
                </div>
                <div class="col-md-6">
                    <form action="#" method="post" class="individual_product_form">
                        <!-- General Errors -->
                        <div class="form-group">
                            <span class="text-danger">
                                <ul>
                                    <!-- ProductName Error -->
                                    <li><?php
                                        if ($productName_error) {
                                            echo $productName_error;
                                        }
                                        ?></li>

                                    <!-- ProductDescription Error -->
                                    <li><?php
                                        if ($productDescription_error) {
                                            echo $productDescription_error;
                                        }
                                        ?></li>

                                    <!-- ProductBrand Error -->
                                    <li><?php
                                        if ($productBrand_error) {
                                            echo $productBrand_error;
                                        }
                                        ?></li>

                                    <!-- Product retail price Error -->
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
                                </ul>
                            </span>
                        </div>
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" name="productName" placeholder="Enter Product Name" value="<?= $individual_product['productName']; ?>" class="form-control 
                            <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Product description -->
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
                            <textarea name="productDescription" placeholder="enter Product Description" class="w-100 
                            <?php echo (!empty($productDescription_error)) ? 'is-invalid' : ''; ?>"><?= $individual_product['productDescription']; ?></textarea>
                        </div>

                        <!-- Product Brand -->
                        <div class="form-group">
                            <label for="productBrand">Product Brand</label>
                            <select name="productBrand" class="form-control 
                            <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled>Select Product Brand
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM phone_brands");
                                    $sql->execute();
                                    $database_phone_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($database_phone_brands as $brand) : ?>
                                <option value="<?php echo htmlentities($brand['brandName']) ?>">
                                    <?= $brand['brandName']; ?>
                                </option>
                            <?php endforeach; ?>
                            </option>
                            </select>
                        </div>

                        <!-- Product Retail Price -->
                        <div class="form-group">
                            <label for="productRetailPrice">Product Retail Price</label>
                            <input type="number" name="productRetailPrice" placeholder="Enter Product Retail Price" value="<?= $individual_product['productRetailPrice']; ?>" class="form-control 
                            <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Product Price -->
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="number" name="productPrice" placeholder="Enter Product Price" value="<?= $individual_product['productPrice']; ?>" class="form-control 
                            <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Product Quantity -->
                        <div class="form-group">
                            <label for="productQuantity">Product Quantity</label>
                            <input type="number" name="productQuantity" placeholder="Enter Product Quantity" value="<?= $individual_product['productQuantity']; ?>" class="form-control 
                            <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                    <?php endforeach; ?>

                    <!-- Update button -->
                    <div class="form-group my-3">
                        <input type="submit" value="Update Product" class="btn w-100">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?= footerTemplate(); ?>