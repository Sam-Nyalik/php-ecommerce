<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Ensure user is logged in
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
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

// Total number of items in the cart
$total_items_in_cart = isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0;

// Define variables and assign them empty values
$firstName = $lastName = $email = $phoneNumber = $address = $grand_price = "";
$firstName_error = $lastName_error = $email_error = $phoneNumber_error = $address_error = $grand_price_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate First Name
    if (empty(trim($_POST['firstName']))) {
        $firstName_error = "Field is required!";
    } else {
        $firstName = trim($_POST['firstName']);
    }

    // Validate Last Name
    if (empty(trim($_POST['lastName']))) {
        $lastName_error = "Field is required!";
    } else {
        $lastName = trim($_POST['lastName']);
    }

    // Validate Phone Number
    if (empty(trim($_POST['phoneNumber']))) {
        $phoneNumber_error = "Field is required!";
    } else {
        $phoneNumber = trim($_POST['phoneNumber']);
    }

    // Validate Email
    if (empty($_POST['email'])) {
        $email_error = "Field is required!";
    } else {
        $email = $_POST['email'];
    }

    // Validate Address
    if (empty(trim($_POST['address']))) {
        $address_error = "Field is required!";
    } else {
        $address = trim($_POST['address']);
    }

    // Check for errors before dealing with the database
    if (empty($firstName_error) && empty($lastName_error) && empty($email_error) && empty($phoneNumber_error) && empty($address_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO orders(order_id, firstName, lastName, emailAddress, phoneNumber, user_id, product_id, product_grand_price, user_status) VALUES (
            :order_id, :firstName, :lastName, :email, :phoneNumber, :user_id, :product_id, :grandPrice, :user_status)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":order_id", $param_order_id, PDO::PARAM_INT);
            $stmt->bindParam(":firstName", $param_firstName, PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $param_lastName, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $param_user_id, PDO::PARAM_INT);
            $stmt->bindParam(":product_id", $param_product_id, PDO::PARAM_INT);
            $stmt->bindParam(":grandPrice", $param_grandPrice, PDO::PARAM_INT);
            $stmt->bindParam(":user_status", $param_user_status, PDO::PARAM_INT);

            // Set parameters
            $param_order_id = rand();
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_email = $email;
            $param_phoneNumber = $phoneNumber;
            $param_user_id = $id;
            $param_product_id = $_SESSION['product_id'];
            $param_grandPrice = $subtotal;
            $param_user_status = 1;

            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect user to the order description page
                header("location: index.php?page=order_description");
                exit;
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | CHECKOUT'); ?>

<!-- Top Bar -->
<?php include_once "inc/top-bar.php"; ?>

<div class="container" style="margin-top: 45px;">
    <div class="row">
        <p><a class="text-secondary" href="index.php?page=home"><i class="bi bi-arrow-left-circle"></i> Home</a></p>
    </div>
</div>

<!-- Checkout -->
<div id="login" style="margin-bottom: 45px;">
    <div class="container">
        <div class="row">
            <h5 class="text-uppercase text-muted">Checkout</h5>
            <div class="col-md-8">
                <div class="address_details" style="border: 1px solid #333; padding: 20px 15px;">
                    <h5>Address Details</h5>
                    <hr>
                    <!-- Prepare a SELECT statement to fetch user's data -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                    $sql->execute();
                    $database_user_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_user_info as $user_info) : ?>
                        <form action="index.php?page=checkout" method="post" class="login-form">
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="FirstName">First Name*</label>
                                        <input type="text" name="firstName" value="<?= $user_info['firstName']; ?>" class="form-control 
                                     <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>">
                                        <span class="errors"><?php echo $firstName_error; ?></span>
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="LastName">Last Name*</label>
                                        <input type="text" name="lastName" value="<?= $user_info['lastName']; ?>" class="form-control 
                                     <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>">
                                        <span class="errors"><?php echo $lastName_error; ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="form-group">
                                <label for="EmailAddress">Email Address</label>
                                <input type="email" name="email" value="<?= $user_info['email']; ?>" readonly class="form-control">
                            </div>

                            <!-- Mobile Phone Number -->
                            <div class="row">
                                <div class="form-group">
                                    <label for="mobileNumber">Mobile Phone Number*</label>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" value="+254" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="form-group">
                                        <input type="text" name="phoneNumber" value="<?= $user_info['phoneNumber']; ?>" class="form-control 
                                        <?php echo (!empty($phoneNumber_error)) ? 'is-invalid' : ''; ?>">
                                        <span class="errors"><?php echo $phoneNumber_error; ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Address -->
                            <div class="form-group">
                                <label for="DeliveryAddress">Delivery Address* <small class="text-danger" style="text-transform: lowercase;">(Please ensure this is correct)</small></label>
                                <textarea name="address" class="form-control"><?=$user_info['address'];?></textarea>
                                <span class="errors"><?php echo $address_error; ?></span>
                            </div>

                            <div class="payment_options my-5">
                                <h5>Payment Options</h5>
                                <hr>
                                <h6 class="text-center text-muted">We only accept cash on delivery</h6>
                            </div>

                            <!-- Submit Btn -->
                            <div class="form-group my-4">
                                <input type="submit" value="Order Now" class="btn w-100">
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="order_summary_title">
                    <h5 class="text-muted">Order Summary</h5>
                </div>
                <div class="order_summary">
                    <div class="number_of_items">
                        <h5><span class="text-dark">Your Order:</span> <?php
                                                                        if ($total_items_in_cart > 1) {
                                                                            echo $total_items_in_cart ?> Items
                            <?php   } else {
                                                                            echo $total_items_in_cart ?> Item
                            <?php  }
                            ?></h5>
                    </div>
                    <hr>
                    <?php if (empty($products)) :  ?>
                        <!-- // Redirect user to the cart page if there is no order -->
                        <?php header("location: index.php?page=cart");
                        exit; ?>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <div>
                                <h5><?= $product['productName']; ?></h5>
                                <h6 class="text-secondary">Quantity: <span class="text-muted"></span></h6>
                                <h6 class="text-secondary">Price of each: <span class="text-muted">Ksh. <?= $product['productPrice']; ?></span></h6>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <h3 class="text-dark" name="grand_price">Grand Total: <span class="text-muted">Ksh. <?= $subtotal; ?></span></h3>
                    <hr>
                    <a href="index.php?page=cart"><button class="btn w-100">Modify Cart</button></a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?= footerTemplate(); ?>