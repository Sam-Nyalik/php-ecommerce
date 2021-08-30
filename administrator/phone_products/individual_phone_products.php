<?php
// Start session
session_start();

include_once "functions/functions.php";
$pdo = databaseConnect();

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
                    <form action="" method="post" class="individual_product_form">
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" name="productName" placeholder="Enter Product Name" value="<?php echo htmlentities($row['productName']) ?>" class="form-control">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?= footerTemplate(); ?>