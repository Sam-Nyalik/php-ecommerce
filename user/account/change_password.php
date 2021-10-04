<?php

// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

$email = false;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

// Define variables and assign them empty values
$new_password = $confirm_new_password = $success = "";
$new_password_error = $confirm_new_password_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate new password
    if (empty(trim($_POST['new_password']))) {
        $new_password_error = "Field is required!";
    } else if (strlen(trim($_POST['new_password'])) < 8) {
        $new_password_error = "Passwords must have at least 8 characters!";
    } else {
        $new_password = trim($_POST['new_password']);
    }

    // Validate confirm new password
    if (empty(trim($_POST['confirm_new_password']))) {
        $confirm_new_password_error = "Field is required!";
    } else {
        $confirm_new_password = trim($_POST['confirm_new_password']);

        if (empty($new_password_error) && ($new_password !== $confirm_new_password)) {
            $confirm_new_password_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if (empty($new_password_error) && empty($confirm_new_password_error)) {
        // Prepare an UPDATE statement
        $sql = "UPDATE users SET password = :new_password WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":new_password", $param_new_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email = $_SESSION['email'];
            // Attempt to execute
            if ($stmt->execute()) {
                header("location: index.php?page=user/login");
            } else {
                echo "There was an error. Please try again!";
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | CHANGE_PASSWORD'); ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5 style="margin-bottom: 25px;"><span>User</span> Password Change</h5>
            <p class="text-center">Please fill in the form below!</p>
        </div>
    </div>
</div>

<div id="login" style="margin-top: 10px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form action="index.php?page=user/account/change_password" method="post" class="login-form">
                    <!-- New Password -->
                    <div class="form-group">
                        <label for="NewPassword">New Password</label>
                        <input type="password" name="new_password" class="form-control 
                        <?php echo (!empty($new_password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors"><?php echo $new_password_error; ?></span>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label for="ConfirmNewPassword">Confirm New Password</label>
                        <input type="password" name="confirm_new_password" class="form-control 
                        <?php echo (!empty($confirm_new_password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors"><?php echo $confirm_new_password_error; ?></span>
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Change Password" class="btn w-100">
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