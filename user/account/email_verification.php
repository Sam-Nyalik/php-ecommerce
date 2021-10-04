<?php
// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the user is logged in
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
    header("location: index.php?page=user/account/index");
    exit;
}
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$email = "";
$email_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate Email Address
    if (empty(trim($_POST['email']))) {
        $email_error = "Field is required!";
    } else {
        // Check if the email address input exists
        $sql = "SELECT email FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = trim($_POST['email']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() >= 1) {
                    $email = trim($_POST['email']);

                    // Store the email address in a session variable
                    $_SESSION['email'] = $email;
                } else {
                    $general_error = "User with this email address does not exist!";
                }
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if(empty($email_error) && empty($general_error)){
        // Prepare a SELECT statement then store the email input in a session variable
        $sql = "SELECT id FROM users WHERE email = :email";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = $email;
            // Attempt to execute
            if($stmt->execute()){
                // Store the email input in a session variable
                if($stmt->rowCount() > 0){
                    $_SESSION['email'] = $email;
                    header("location: index.php?page=user/account/change_password");
                } else {
                    $general_error = "User does not exist!";
                }
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
<?= headerTemplate('USER | EMAIL_VERIFICATION'); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5 style="margin-bottom: 25px;"><span>User</span> Password Reset</h5>
            <p class="text-center">Please enter the email address associated with your account!</p>
        </div>
    </div>
</div>

<div id="login" style="margin-top: 10px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form action="index.php?page=user/account/email_verification" method="post" class="login-form">
                    <!-- General Error -->
                    <div class="form-group">
                        <span class="errors">
                            <ul>
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="email" id="user_input" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors"><?php echo $email_error; ?></span>
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Reset Password" id="submit" class="btn w-100">
                    </div>

                    <!-- Login Redirect -->
                    <div class="form-group my-3 text-center">
                        <a href="index.php?page=user/login" style="text-decoration: none;">
                            <h5 style="font-size: 16px; margin-top: 35px;">Return To Login</h5>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?=footerTemplate(); ?>