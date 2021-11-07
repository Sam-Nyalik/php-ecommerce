<?php
// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Check if the user is logged in 
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$password = "";
$password_error = "";

// Process data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate Password
    if (empty(trim($_POST['password']))) {
        $password_error = "Field is required!";
    } else {
        // Check if the password put matches the one in the database
        $sql = "SELECT * FROM users WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set parameters
            $param_id = $_SESSION['id'];
            // Attempt to execute
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row['password'];
                    if (password_verify(trim($_POST['password']), $hashed_password)) {
                        $password = trim($_POST['password']);
                    } else {
                        $password_error = "Wrong pasword!";
                    }
                } else {
                    echo "Incorrect user details!";
                }
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($password_error)) {
        // Prepare a DELETE statement
        $sql = "DELETE FROM users WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            // Set parameters
            $param_id = $_SESSION['id'];
            // Attempt to execute
            if ($stmt->execute()) {
                // Unset & destroy all the session variables
                session_unset();
                session_destroy();
                // Redirect user to the login page
                header("location: index.php?page=user/login");
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
<?= headerTemplate('USER | DEACTIVATE_ACCOUNT'); ?>

<!-- Previous page redirect -->
<div class="container">
    <div class="row my-5">
        <p><a class="text-secondary" href="index.php?page=user/account/index"><i class="bi bi-arrow-left-circle"></i> back</a></p>
    </div>
</div>

<!-- Deactivate Account -->
<div id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Deactivate Account</h5>
                <p>Complete your deactivation request by entering the password associated with your account.</p>

                <form action="index.php?page=user/account/deactivate" method="post" class="login-form">
                    <div class="form-group">
                        <input type="password" name="password" id="user_input" placeholder="Password" class="form-control 
                        <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                        <i class="bi bi-eye" onclick="passwordView()" style="cursor: pointer; float: right; margin-right: 10px; margin-top: -33px; position: relative"></i>
                        <span class="errors"><?php echo $password_error; ?></span>
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" id="submit" value="Deactivate" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?= footerTemplate(); ?>