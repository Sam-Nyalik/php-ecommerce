<?php
// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productName = "";
$productName_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product name
    if (empty(trim($_POST["productName"]))) {
        $productName_error = "Product name Field is required!";
    } else {
        $productName = trim($_POST["productName"]);
    }
}

?>

<?= headerTemplate('ADMIN | INDIVIDUAL_PHONE_PRODUCT'); ?>

<?php include_once "administrator/includes/main_navbar.php"; ?>

<?php
// Fetch the product from the database
$id = false;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$sql = $pdo->query("SELECT * FROM phone_products JOIN phone_products_images ON phone_products.id = phone_products_images.id WHERE phone_products.id = '$id'");
while ($row = $sql->fetch()) {
?>
    <!-- Section title -->
    <div class="section-title" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <h5><?php echo htmlentities($row['productName']); ?></h5>
            </div>
        </div>
    </div>

    <div id="individual_product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo htmlentities($row['image']); ?>" class="img-fluid" alt="">
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
                                </ul>
                            </span>
                        </div>
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" name="productName" placeholder="Enter Product Name" value="<?php echo htmlentities($row['productName']) ?>" class="form-control 
                            <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Product description -->
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
                            <textarea name="productDescription" placeholder="enter Product Description" class="w-100"><?php echo htmlentities($row['productDescription']) ?></textarea>
                        </div>

                        <!-- Product Brand -->
                        <div class="form-group">
                            <label for="productBrand">Product Brand</label>
                            <select name="productBrand" class="form-control">
                                <option value=""><?php echo htmlentities($row['productBrand']) ?>
                                    <?php
                                    $sql = $pdo->query("SELECT * FROM phone_brands");
                                    while ($brand = $sql->fetch()) {
                                    ?>
                                <option value="<?php echo htmlentities($brand['brandName']) ?>">
                                    <?php echo htmlentities($brand['brandName']) ?>
                                </option>
                            <?php } ?>
                            </option>
                            </select>
                        </div>

                        <!-- Product Retail Price -->
                        <div class="form-group">
                            <label for="productRetailPrice">Product Retail Price</label>
                            <input type="number" name="productRetailPrice" placeholder="Enter Product Retail Price" value="<?php echo htmlentities($row['productRetailPrice']) ?>" class="form-control">
                        </div>

                        <!-- Product Price -->
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="number" name="productPrice" placeholder="Enter Product Price" value="<?php echo htmlentities($row['productPrice']) ?>" class="form-control">
                        </div>

                        <!-- Product Quantity -->
                        <div class="form-group">
                            <label for="productQuantity">Product Quantity</label>
                            <input type="number" name="productQuantity" placeholder="Enter Product Quantity" value="<?php echo htmlentities($row['productQuantity']) ?>" class="form-control">
                        </div>

                    <?php } ?>

                    <!-- update button -->
                    <div class="form-group my-3">
                        <input type="submit" value="Update Product" class="btn w-100">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?= footerTemplate(); ?>