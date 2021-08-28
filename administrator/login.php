<?php

// Start a session
session_start();

include_once "functions/functions.php";
$pdo = databaseConnect();

// Check if the administrator is already logged in, if yes redirect to the dashboard page
if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
    header("location: index.php?page=administrator/dashboard");
    exit;
}

// Define variables and assign them empty values
$email = $password = "";
$email_error = $password_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_error = "Email field is required!";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Password field is required!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for errors before dealing with the database
    if (empty($email_error) && empty($password_error)) {
        // Prepare a SELECT statement
        $sql = "SELECT id, emailAddress, password FROM admin WHERE emailAddress = :email ";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = $email;
            // Attempt to execute
            if ($stmt->execute()) {
                // Check if the email address exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row['id'];
                        $email = $row['emailAddress'];
                        $hashed_password = $row['password'];

                        // Verify the user input password and the password in the database
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['loggedIn'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['email'] = $email;

                            // Redirect the admin to the dashboard
                            header("location: index.php?page=administrator/dashboard");
                            exit;
                        } else {
                            $password_error = "Wrong Password!";
                        }
                    }
                } else {
                    $email_error = "User does not exist!";
                }
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
<?= headerTemplate('ADMIN | LOGIN'); ?>

<div class="vl"></div>

<!-- Section title -->
<div class="section-title" style="margin-top: 60px;">
    <div class="container">
        <div class="row">
            <h5>Admin Login</h5>
        </div>
    </div>
</div>

<!-- Login Form -->
<div id="login">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-5">
                <p><a class="text-secondary" href="index.php?page=home"><i class="bi bi-arrow-left-circle"></i> Home</a></p>
                <h4>Welcome Admin,</h4>
                <h6>Sign in to continue!</h6>
                <!-- Form -->
                <form action="index.php?page=administrator/login" method="post" class="login-form">
                    <!-- General Error -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- Email Error -->
                                <li><?php
                                    if ($email_error) {
                                        echo $email_error;
                                    }
                                    ?></li>

                                <!-- Password Error -->
                                <li><?php
                                    if ($password_error) {
                                        echo $password_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- Email Address -->
                    <div class="form-group">
                        <input type="email" autofocus autocomplete="off" name="email" placeholder="Email Address" value="<?php echo $email; ?>" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input type="password" name="password" id="pwd" placeholder="Password" class="form-control 
                        <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="form-group">
                        <input type="checkbox" class="checkbox" onclick="passwordView()"> <span style="font-size: 14px;">Show Password</span>
                    </div>

                    <div class="form-group my-3">
                        <input type="submit" class="btn" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "./functions/functions.php"; ?>
<?= footerTemplate(); ?>