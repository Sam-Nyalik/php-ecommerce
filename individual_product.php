<?php

include_once "functions/functions.php";
$pdo = databaseConnect();

// Ensure that the ID parameter has been set in the URL
if (isset($_GET["id"])) {
    // Prepare a SELECT statement to get the product with a specified id
    $sql = $pdo->prepare("SELECT * FROM all_products WHERE id = ?");
    $total_product_quantity = 1;
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
        <div class="side_nav" id="bars_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bars"></div>
            <div class="bars"></div>
            <div class="bars"></div>
        </div>
        <ul class="bars_drop dropdown-menu" aria-labelledby="bars_dropdown">
            <a href="" class="dropdown-item"><img src="icons/restaurant.png" alt="food"> Food</a>
            <a href="" class="dropdown-item"><img src="icons/soft-drink.png" alt="Beverages"> Beverages</a>
            <a href="" class="dropdown-item"><img src="icons/shoes.png" alt="shoes"> Shoes</a>
            <a href="" class="dropdown-item"><img src="icons/clothes-hanger.png" alt="clothes"> Clothes</a>
            <a href="" class="dropdown-item"><img src="icons/work.png" alt="office"> Office</a>
            <a href="" class="dropdown-item"><img src="icons/furnitures.png" alt="furniture"> Furniture</a>
            <a href="" class="dropdown-item"><img src="icons/console.png" alt="games"> Gaming</a>
            <a href="" class="dropdown-item"><img src="icons/open-book.png" alt="Books"> Education</a>
        </ul>

        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce.</a></h3>
        <div class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
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
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item"><img src="icons/apple.png" alt="apple"> Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item"><img src="icons/samsung.png" alt="samsung"> Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item"><img src="icons/huawei.png" alt="huawei"> Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item"><img src="icons/dell.png" alt="dell"> Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item"><img src="icons/hp.png" alt="hp"> Hp</a>
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
                <a href="index.php?page=cart"><i class="bi bi-cart4 active" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
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
                    <img src="<?= $single_product['productImage1']; ?>" class="img-fluid" id="mainProductImage" alt="<?= $single_product['productName']; ?>">
                    <!-- Small Images -->
                    <div class="row my-3">
                        <div class="col-4">
                            <img src="<?= $single_product['productImage1']; ?>" class="img-fluid smallProductImage" alt="" style="height: 100px;">
                        </div>
                        <div class="col-4">
                            <img src="<?= $single_product['productImage2']; ?>" class="img-fluid smallProductImage" alt="" style="height: 100px;">
                        </div>
                        <div class="col-4">
                            <img src="<?= $single_product['productImage3']; ?>" class="img-fluid smallProductImage" alt="" style="height: 100px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5><?= $single_product['productName']; ?>,<span class="text-muted" style="font-size: 16px;"> <?= $single_product['storage']; ?> + <?= $single_product['memory']; ?> RAM</span></h5>
                    <h6 class="text-dark" style="font-weight: 300">Brand: <span style="color: #540b0e;"><?= $single_product['productBrand']; ?></span></h6>
                    <h6 class="text-dark" style="font-weight: 300">Network: <span style="color: #540b0e;"><?= $single_product['network']; ?></span></h6>
                    <hr>
                    <?php if ($single_product['productRetailPrice'] > 0) : ?>
                        <small class="text-muted"><s style="font-size: 18px;">Ksh. <?= $single_product['productRetailPrice']; ?></s></small>
                    <?php endif; ?>
                    <h6 class="text-dark" style="font-weight: 600; margin-bottom: 40px; font-size: 22px">Ksh. <?= $single_product['productPrice']; ?></h6>
                    <!-- <h6 class="description">Description</h6>
                    <p class="text-muted"><?= $single_product['productDescription']; ?></p> -->

                    <form action="index.php?page=cart" method="post" class="add_to_cart_form">
                        <select name="product_quantity" class="form-control">
                            <option value="Product Quantity" disabled>Product Quantity</option>
                            <?php foreach (range(1, $single_product['productQuantity']) as $total_product_number) : ?>
                                <option value="<?= $total_product_number; ?>"><?= $total_product_number; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="product_id" value="<?= $single_product['id']; ?>">
                        <input type="submit" value="Add To Cart" class="btn w-100 my-3">
                    </form>
                </div>
                <hr>
                <div class="row">
                  <div class="product_description">
                  <div class="col-md-12">
                        <h5>Product Description</h5>
                      <div class="row">
                          <div class="col-md-8">
                          <div class="description">
                            <h6><?=$single_product['productDescription'];?></h6>
                        </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Similar Product -->
<!-- <div id="similar_products">
    <div class="container">
        <div class="row">
            <div class="similar_product_title">
                <h5><span>Similar</span> Products</h5>
            </div>
        </div>
    </div>
</div> -->

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>


<script>

</script>