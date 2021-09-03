<?php

// Start a session
session_start();

// Check if the administrator is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$newPassword = $newPasswordConfirm = "";
$newPassword_error = $newPasswordConfirm_error = "";

$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate New Password
    if (empty(trim($_POST["newPassword"]))) {
        $newPassword_error = "New Password Field is required!";
    } else if (strlen(trim($_POST["newPassword"])) < 8) {
        $newPassword_error = "New Password must have more than 8 characters!";
    } else {
        $newPassword = trim($_POST["newPassword"]);
    }

    // Validate new password confirm
    if (empty(trim($_POST["newPasswordConfirm"]))) {
        $newPasswordConfirm_error = "New Password confirm field is required!";
    } else {
        $newPasswordConfirm = trim($_POST["newPasswordConfirm"]);

        // Check if the passwords match
        if (empty($newPassword_error) && ($newPassword !== $newPasswordConfirm)) {
            $newPasswordConfirm_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if (empty($newPassword_error) && empty($newPasswordConfirm_error)) {
        // Prepare an UPDATE statement
        $sql = "UPDATE admin SET password = :newPassword WHERE id = '$id'";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":newPassword", $param_newPassword, PDO::PARAM_STR);
            // Set parameters
            $param_newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect back to the login page
                header("location: index.php?page=administrator/logout");
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Close the connection
    unset($pdo);
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

<div class="container">
    <div id="profile">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/change_password" method="post" class="profile_form">
                    <h5 class="text-light">Fill in the form below:</h5>
                    <!-- General Errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- New Password Error -->
                                <li><?php
                                    if ($newPassword_error) {
                                        echo $newPassword_error;
                                    }
                                    ?></li>

                                <!-- New Password confirm Error -->
                                <li><?php
                                    if ($newPasswordConfirm_error) {
                                        echo $newPasswordConfirm_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="NewPassword">New Password</label>
                        <input type="password" autocomplete="off" autofocus name="newPassword" placeholder="New Password" class="form-control 
                    <?php echo (!empty($newPassword_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label for="NewPasswordConfirm">Confirm New Password</label>
                        <input type="password" name="newPasswordConfirm" placeholder="Confirm New Password" class="form-control 
                    <?php echo (!empty($newPasswordConfirm_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit button -->
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