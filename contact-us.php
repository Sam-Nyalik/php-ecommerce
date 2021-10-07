<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$firstName = $lastName = $email = $subject = $message = $recaptcha = $success = "";
$firstName_error = $lastName_error = $email_error = $subject_error = $message_error = $recaptcha_error = $general_error = "";

// Google reCAPTCHA API key configuration

// Go to goggle's reCAPTCHA, and request for a site key
$site_key = "";

// Go to goggle's reCAPTCHA, and request for a secret key
$secret_key = "";

$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate firstName
    if (empty(trim($_POST["firstName"]))) {
        $firstName_error = "First Name field is required!";
    } elseif (!preg_match("/^[a-zA-Z]+$/", trim($_POST["firstName"]))) {
        $firstName_error = "First name requires only letters!";
    } else {
        $firstName = trim($_POST["firstName"]);
    }

    // Validate LastName
    if (empty(trim($_POST["lastName"]))) {
        $lastName_error = "Last Name field is required!";
    } elseif (!preg_match("/^[a-zA-Z]+$/", trim($_POST["lastName"]))) {
        $lastName_error = "Last name requires only letters!";
    } else {
        $lastName = trim($_POST["lastName"]);
    }

    // Validate Email Address
    if (empty(trim($_POST["email"]))) {
        $email_error = "Email Address field is required!";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_error = "Subject Field is required!";
    } else {
        $subject = trim($_POST["subject"]);
    }

    // Validate Message
    if (empty(trim($_POST["message"]))) {
        $message_error = "Message Field is required!";
    } else {
        $message = trim($_POST["message"]);
    }

    // Check for errors before dealing with the database
    if (empty($firstName_error) && empty($lastName_error) && empty($email_error) && empty($subject_error) && empty($message_error)) {
        // Validate the reCAPTCHA box
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Verify the reCAPTCHA response
            $response_verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

            // Decode JSON data
            $response_data = json_decode($response_verify);

            // If the reCAPTCHA response is valid
            if ($response_data->success) {
                //Prepare an INSERT statement
                $sql = "INSERT INTO contact_queries(firstName, lastName, email, subject, message) VALUES(
                    :firstName, :lastName, :email, :subject, :message)";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":firstName", $param_firstName, PDO::PARAM_STR);
                    $stmt->bindParam(":lastName", $param_lastName, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt->bindParam(":subject", $param_subject, PDO::PARAM_STR);
                    $stmt->bindParam(":message", $param_message, PDO::PARAM_STR);

                    // Set parameters
                    $param_firstName = $firstName;
                    $param_lastName = $lastName;
                    $param_email = $email;
                    $param_subject = $subject;
                    $param_message = $message;

                    // Attempt to execute
                    if ($stmt->execute()) {
                        $success = "Your contact query has been received successfully!";
                    } else {
                        echo "There was an error. Please try again!";
                    }

                    // Close the statement
                    unset($stmt);
                }
            } else {
                $recaptcha_error = "reCAPTCHA verification failed. Please try again!";
            }
        } else {
            $recaptcha_error = "The reCAPTCHA verification field is required!";
        }
    } else {
        $general_error = "All fields are required!";
    }

    // Close the connection
    unset($pdo);
}

?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php" ?>

<!-- Header template -->
<?= headerTemplate('CONTACT US'); ?>

<!-- Topbar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Main Navbar -->
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
                    <a href="index.php?page=contact-us" class="nav-link active">Contact</a>
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

<!-- Contact Header -->
<div id="contact_header">
    <div class="container">
        <div class="row text-center">
            <div class="contact_header_description">
                <h3>How Can We Help?</h3>
                <h5>Shoot us a message!</h5>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us -->
<div id="contact_us">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="index.php?page=contact-us" method="post" class="contact_us_form">
                    <!-- General Success -->
                    <div class="form-group">
                        <span class="text-success">
                            <ul>
                                <!-- Success Message -->
                                <li><?php
                                    if ($success) {
                                        echo $success;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- General Errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- FirstName Error -->
                                <li><?php
                                    if ($firstName_error) {
                                        echo $firstName_error;
                                    }
                                    ?></li>

                                <!-- LastName Error -->
                                <li><?php
                                    if ($lastName_error) {
                                        echo $lastName_error;
                                    }
                                    ?></li>

                                <!-- Email Error -->
                                <li><?php
                                    if ($email_error) {
                                        echo $email_error;
                                    }
                                    ?></li>

                                <!-- Subject Error -->
                                <li><?php
                                    if ($subject_error) {
                                        echo $subject_error;
                                    }
                                    ?></li>

                                <!-- Message Error -->
                                <li><?php
                                    if ($message_error) {
                                        echo $message_error;
                                    }
                                    ?></li>

                                <!-- Recaptcha Error -->
                                <li><?php
                                    if ($recaptcha_error) {
                                        echo $recaptcha_error;
                                    }
                                    ?></li>

                                <!-- General Error -->
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- FirstName -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <!-- Prepare a SELECT statement to fetch the logged in user's info from the database -->
                                <?php
                                if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                                    $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                                    $sql->execute();
                                    $database_firstName = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                    <?php foreach ($database_firstName as $firstName) : ?>
                                        <input type="text" name="firstName" class="form-control 
                                <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>" value="<?= $firstName['firstName']; ?>">
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <input type="text" name="firstName" class="form-control 
                                <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo !empty($_POST['firstName']) ? $_POST['firstName'] : ''; ?>">
                                <?php } ?>
                            </div>
                        </div>

                        <!-- LastName -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <?php
                                if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                                    $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                                    $sql->execute();
                                    $database_lastName = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                    <?php foreach ($database_lastName as $lastName) : ?>
                                        <input type="text" name="lastName" class="form-control 
                                <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>" value="<?= $lastName['lastName']; ?>">
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <input type="text" name="lastName" class="form-control 
                                <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo !empty($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="EmailAddress">Email Address</label>
                        <?php
                        if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                            $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                            $sql->execute();
                            $database_email = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <?php foreach ($database_email as $email) : ?>
                                <input type="email" name="email" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?= $email['email']; ?>">
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <input type="email" name="email" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo !empty($_POST['email']) ? $_POST['email'] : ''; ?>">
                        <?php } ?>
                    </div>

                    <!-- Subject -->
                    <div class="form-group">
                        <label for="subject">subject</label>
                        <input type="text" name="subject" class="form-control 
                        <?php echo (!empty($subject_error)) ? 'is-invalid' : ''; ?>" value="<?php echo !empty($_POST['subject']) ? $_POST['subject'] : ''; ?>">
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="user_input" class="form-control 
                        <?php echo (!empty($message_error)) ? 'is-invalid' : ''; ?>"></textarea>
                    </div>

                    <!-- Google Captcha -->
                    <div class="form-group">
                        <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $site_key ?>"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group my-3">
                        <input type="submit" id="submit" value="Send Message" class="btn w-100">
                    </div>
                </form>
            </div>

            <!-- Google Maps -->
            <div class="col-md-5">
                <div id="google_map"></div>
                <div class="contact_description">
                    <h5><span>Reach us on the hotline:</span> +2547123456</h5>
                    <h5><span>Opening Hours: </span></h5>
                    <ul>
                        <li>Monday - Friday: 8am - 6pm</li>
                        <li>Saturday: 10am - 4pm</li>
                        <li>Sunday: 10am - 1pm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>