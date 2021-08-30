<?php
// Start session
session_start();

include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();


?>

<?= headerTemplate('ADMIN | ALL_PHONE_PRODUCTS') ?>

<!-- Main Dashboard Script -->
<?php include_once "./administrator/includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>All Phone Products</h5>
        </div>
    </div>
</div>

<div id="recently-added-products">
    <div class="container">
        <div class="row text-center">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM phone_products JOIN phone_products_images ON phone_products.id = phone_products_images.id");
            $stmt->execute();
            $all_phone_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($all_phone_products as $phone_products) : ?>
                <div class="col-md-3 col-sm-6 my-3 my-md-0">
                    <a href="index.php?page=administrator/phone_products/individual_phone_products&id=<?= $phone_products['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $phone_products['image']; ?>" class="img-fluid card-img-top" alt="<?= $phone_products['productName']; ?>" srcset="">
                            </div>
                            <div class="card-body">
                                <h5><?= $phone_products['productName']; ?></h5>
                                <h6><span class="text-dark">Brand: </span><?= $phone_products['productBrand']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add More Products -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/phone_products/add_phone_product">Add Phone Product</a></button>
        </div>
    </div>
</div>

<?= footerTemplate(); ?>