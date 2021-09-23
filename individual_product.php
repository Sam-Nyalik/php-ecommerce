<?php

include_once "functions/functions.php";
$pdo = databaseConnect();

// Ensure that the ID parameter has been set in the URL
if (isset($_GET["id"])) {
    // Prepare a SELECT statement to get the product with a specified id
    $sql = $pdo->prepare("SELECT * FROM all_products WHERE id = ?");
    $sql->execute([$_GET['id']]);
    //  Fetch the products and return as an associative array
    $individual_product = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Check if the product exists or not
    if (!$individual_product) {
        exit("Product does not exist!");
    }
} else {
    exit("There was an error!");
}

?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php" ?>

<!-- Header Template -->
<?= headerTemplate('INDIVIDUAL_PRODUCT'); ?>

<!-- Top Bar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce.</a></h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item">Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item">Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item">Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item">Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item">Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle active" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item active">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="index.php?page=laptop_products" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <a href="index.php?page=cart"><i class="bi bi-bag active" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Search bar -->
<?= searchBarTemplate(); ?>

<!-- Single Product and it's properties -->
<div id="single_product">
    <div class="container">
        <div class="row">
            <?php foreach ($individual_product as $single_product) : ?>
                <div class="col-md-6">
                    <img src="<?= $single_product['productImage']; ?>" class="img-fluid" alt="<?= $single_product['productName']; ?>">
                </div>
                <div class="col-md-6">
                    <h5><?= $single_product['productName']; ?></h5>
                    <?php if ($single_product['productRetailPrice'] > 0) : ?>
                        <small class="text-muted"><s style="font-size: 16px;">&dollar;<?= $single_product['productRetailPrice']; ?></s></small>
                    <?php endif; ?>
                    <h6 class="text-dark" style="font-weight: 600;">&dollar;<?= $single_product['productPrice']; ?></h6>
                    <h6 class="description">Description</h6>
                    <p class="text-muted"><?= $single_product['productDescription']; ?></p>

                    <form action="index.php?page=cart" method="post" class="add_to_cart_form">
                        <input type="number" name="product_quantity" required min="1" max="<?= $single_product['productQuantity']; ?>" placeholder="Product Quantity" class="form-control">
                        <input type="hidden" name="product_id" value="<?= $single_product['id']; ?>">
                        <input type="submit" value="Add To Cart" class="btn w-100 my-3">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<!-- Similar Product -->
<div id="similar_products">
    <div class="container">
        <div class="row">
            <div class="similar_product_title">
                <h5><span>Similar</span> Products</h5>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>