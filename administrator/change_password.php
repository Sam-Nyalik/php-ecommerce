<?php

// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the administrator is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$current_password = $new_password = $confirm_new_password = $success = "";
$current_password_error = $new_password_error = $confirm_new_password_error = $general_error = "";

$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate Current Password and ensure it matches with the one in the database
    if (empty(trim($_POST['current_password']))) {
        $current_password_error = "Field is required!";
    } else {
        $sql = "SELECT password FROM users WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set parameters
            $param_id = $id;
            // Attempt to execute
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row['password'];

                    if (password_verify($_POST['current_password'], $hashed_password)) {
                        $current_password = trim($_POST['current_password']);
                    } else {
                        $current_password_error = "Current Passwords do not match!";
                    }
                }
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Validate New Password
    if (empty(trim($_POST['new_password']))) {
        $new_password_error = "Field is required!";
    } else if (strlen(trim($_POST['new_password'])) < 8) {
        $new_password_error = "Password must have at least 8 characters!";
    } else {
        $new_password = trim($_POST['new_password']);
    }

    // Validate New Password Confirm
    if (empty(trim($_POST['confirm_new_password']))) {
        $confirm_new_password_error = "Field is required!";
    } else {
        $confirm_new_password = trim($_POST['confirm_new_password']);

        if (empty($new_password_error) && ($new_password !== $confirm_new_password)) {
            $confirm_new_password_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if (empty($current_password_error) && empty($new_password_error) && empty($confirm_new_password_error)) {
        // Prepare an UPDATE statement on the password row
        $sql = "UPDATE admin SET password = :new_password WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":new_password", $param_new_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set parameters
            $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $id;
            // Attempt to execute
            if ($stmt->execute()) {
                $success = "Your password has been updated successfully!";
            } else {
                $general_error = "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | CHANGE PASSWORD') ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Reset Password</h5>
        </div>
    </div>
</div>

<div id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/change_password" method="post" class="login-form">
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

                    <!-- Success Message -->
                    <div class="form-group">
                        <span class="text-success">
                            <ul>
                                <li><?php
                                    if ($success) {
                                        echo $success;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="CurrentPassword">Current Password</label>
                        <input type="password" name="current_password" class="form-control 
                        <?php echo (!empty($current_password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors"><?php echo $current_password_error; ?></span>
                    </div>

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
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>