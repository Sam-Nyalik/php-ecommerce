<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productBrand = "";
$productBrand_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user input
    if (empty(trim($_POST["productBrand"]))) {
        $productBrand_error = "Field is required!";
    } else {
        // Check if the user input already exists in the database
        $sql = "SELECT * FROM product_brands WHERE productBrand = :productBrand";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
            // Set Parameters
            $param_productBrand = trim($_POST['productBrand']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() >= 1) {
                    $productBrand_error = "This product brand already exists!";
                } else {
                    $productBrand = trim($_POST['productBrand']);
                }
            }

            // Close the prepared statement
            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if(empty($productBrand_error)){
        // Prepare an UPDATE statement
        $sql = "UPDATE product_brands SET productBrand = :productBrand WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set Parameters
            $param_productBrand = $productBrand;
            $param_id = $_GET['id'];
            // Attempt to execute
            if($stmt->execute()){
                header("location: index.php?page=administrator/all_product_brands");
                exit;
            } else {
                echo "There was an error. Please try again!";
            }
        }
    }
}

?>

<!-- Header template -->
<?= headerTemplate('ADMIN | SINGLE_PRODUCT_BRAND'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<!-- fetch Product Brand Name from the database -->
<?php
$sql = $pdo->prepare("SELECT productBrand FROM product_brands WHERE id = '" . $_GET['id'] . "'");
$sql->execute();
$database_product_brand = $sql->fetchAll(PDO::FETCH_ASSOC)
?>
<?php foreach ($database_product_brand as $product_brand) : ?>
    <div class="section-title" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <h5><span><?= $product_brand['productBrand']; ?></span> Product Brand</h5>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="add_product_type">
            <div class="row">
                <div class="col-md-5">
                    <form action="#" method="post" class="add_product_type_form">
                        <div class="form-group">
                            <label for="ProductBrand">Product Brand</label>
                            <input type="text" name="productBrand" value="<?= $product_brand['productBrand']; ?>" class="form-control 
                        <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                            <span class="errors text-danger"><?php echo $productBrand_error; ?></span>
                        </div>

                        <div class="form-group my-3">
                            <input type="submit" value="Update Product Brand Name" class="btn w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>