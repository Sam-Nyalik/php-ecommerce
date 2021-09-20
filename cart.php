<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Check for form data after the user clicks the add to cart button
if (isset($_POST['product_id'], $_POST['product_quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['product_quantity'])) {
    // Set POST variables for easy identification, & they should be numeric
    $product_id = (int)$_POST['product_id'];
    $product_quantity = (int)$_POST['product_quantity'];

    // Prepare a SELECT statement to check if the product exists in our database
    $sql = $pdo->prepare("SELECT * FROM all_products WHERE id = ?");
    $sql->execute([$_POST['product_id']]);
    // Fetch the product from the database and return it as an associative array
    $database_cart_product = $sql->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists in the database or not
    if ($database_cart_product && $product_quantity > 0) {
        // Product Exists, we can now create and update the cart session variable, $_SESSION['cart]
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in the cart, so we update the quantity
                $_SESSION['cart'][$product_id] += $product_quantity;
            } else {
                // Product is not in the cart, so we'll add it
                $_SESSION['cart'][$product_id] = $product_quantity;
            }
        } else {
            //  There are no products in the cart, therefore we'll add the first product to the cart
            $_SESSION['cart'] = array($product_id => $product_quantity);
        }
    }

    // Prevent form resubmission
    header("location: index.php?page=cart");
    exit;
}

// Remove product from the cart, check for the product id(remove) in the url, ensure it's a number & check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities when the update button is clicked
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in the cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'product_quantity') !== false && is_numeric($v)) {
            $id = str_replace('product_quantity-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update the new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }

    // Prevent form resubmission
    header("location: index.php?page=cart");
    exit;
}

// Send the user to the checkout page after the checkout button is clicked
if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header("location: index.php?page=checkout");
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// If products are inside the cart
if ($products_in_cart) {
    // Select products from the database
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    // Prepare a SELECT statement
    $sql = $pdo->prepare('SELECT * FROM all_products WHERE id IN (' . $array_to_question_marks . ')');
    $sql->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return them as an associative array
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['productPrice'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<!-- Header Template -->
<?= headerTemplate('SHOPPING_CART'); ?>

<!-- Top Bar -->
<?= top_barTemplate(); ?>

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
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="index.php?page=laptop_products" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <a href="index.php?page=cart"><i class="bi bi-bag active" style="margin-right: 30px;"><span class="text-dark">(0)</span></i></a>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Search bar -->
<?= searchBarTemplate(); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Shopping</span> Cart</h5>
        </div>
    </div>
</div>

<!-- Shopping Cart Form -->
<div id="shopping_cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="index.php?page=cart" method="POST" class="shopping_cart_form">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($products)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center" style="padding: 30px 0;">Your shopping cart is empty</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($products as $product) : ?>
                                        <tr>
                                            <!-- Item Column-->
                                            <td>
                                                <a href="index.php?page=individual_product&id=<?= $product['id']; ?>">
                                                    <img src="<?= $product['productImage']; ?>" class="" height="200" width="200" alt="" srcset="">
                                                </a>
                                            </td>
                                            <td>
                                                <h5><a href="index.php?page=individual_product&id=<?= $product['id']; ?>"><?= $product['productName']; ?></a></h5>
                                                <p><span>Brand: </span> <?=$product['productBrand'];?></p>
                                                
                                                <a href="index.php?page=cart&remove=<?= $product['id']; ?>" class="btn">Remove</a>
                                            </td>

                                            <!-- Price Column -->
                                            <td>
                                                &dollar;<?= $product['productPrice']; ?>
                                            </td>

                                            <!-- Quantity Column -->
                                            <td>
                                                <input type="number" name="product_quantity-<?=$product['id'];?>" value="<?=$products_in_cart[$product['id']];?>" min="1" class="form-control" max="<?=$product['productQuantity'];?>" class="form-control">
                                            </td>

                                            <!-- Price Column -->
                                            <td>
                                                &dollar;<?=$product['productPrice'] * $products_in_cart[$product['id']];?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>