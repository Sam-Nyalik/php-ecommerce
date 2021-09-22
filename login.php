<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Google reCAPTCHA API key configuration
$site_key = "6LeyX04cAAAAAOZiUSPypBh5G-wwyC1jozGbU1qc";
$secret_key = "6LeyX04cAAAAAEhgmzA9eE_FRr-y6qzyqnXcoUnX";

// Define variables and assign them empty values
$email = $password = $recaptcha = "";
$email_error = $password_error = $recaptcha_error = "";

// Process form data when the submit button is clicked
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate Email Address
    if (empty(trim($_POST['email']))) {
        $email_error = "Field is required!";
    } else if (!preg_match("/^\S+@\S+\.\S+$/", trim($_POST["email"]))) {
        $email_error = "Wrong email format!";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Password
    if (empty(trim($_POST['password']))) {
        $password_error = "Field is required!";
    } else {
        $password = trim($_POST['password']);
    }

    // Check for errors before dealing with the database
    if (empty($email_error) && empty($password_error)) {
        // Validate the reCAPTCHA box
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Verify the reCAPTCHA response
            $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

            // Decode JSON data
            $response_data = json_decode($verify_response);

            // If the recaptcha response is valid
            if ($response_data->success) {
                // Prepare a SELECT statement
                $sql = "SELECT id, email, password FROM users WHERE email = :email";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    // Set Parameters
                    $param_email = $email;
                    // Attempt to execute
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() == 1) {
                            if ($row = $stmt->fetch()) {
                                $id = $row['id'];
                                $email = $row['email'];
                                $hashed_password = $row['password'];
                                // Verify if the password in the input matches the one in the database
                                if (password_verify($password, $hashed_password)) {
                                    // Password is correct
                                    session_start();

                                    // Store data in session variables
                                    $_SESSION['loggedIn'] = true;
                                    $_SESSION['id'] = $id;
                                    $_SESSION['email'] = $email;

                                    // Redirect user to the home page
                                    header("location: index.php?page=home");
                                } else {
                                    $password_error = "Invalid email or Password!";
                                }
                            }
                        } else {
                            // User does not exist
                            $email_error = "User does not exist!";
                        }
                    } else {
                        echo "There was an error. Please try again!";
                    }

                    // close the statement
                    unset($stmt);
                }
            } else {
                $recaptcha_error = "Invalid reCAPTCHA response!";
            }
        } else {
            $recaptcha_error = "reCAPTCHA field is required!";
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | LOGIN'); ?>

<!-- Home redirect -->
<div class="container">
    <div class="row my-5">
        <p><a class="text-secondary" href="index.php?page=home"><i class="bi bi-arrow-left-circle"></i> Home</a></p>
    </div>
</div>

<!-- User Login Forms -->
<div id="login" style="margin-bottom: 45px;">
    <div class="container">
        <div class="row">

            <!-- LOGIN -->
            <div class="col-md-6">
                <h5 class="text-center">User Login</h5>
                <form action="index.php?page=login" method="post" class="login-form">
                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="Email">Email Address</label>
                        <input type="email" name="email" autocomplete="off" autofocus class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="errors"><?php echo $email_error; ?></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" id="user_input" name="password" class="form-control 
                        <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <i class="bi bi-eye" onclick="passwordView()" style="cursor: pointer; float: right; margin-right: 10px; margin-top: -33px; position: relative"></i>
                        <span class="errors"><?php echo $password_error; ?></span>
                    </div>

                    <!-- Remember Me  -->
                    <div class="form-group">
                        <input type="checkbox" name="remember"> <span>Remember Me</span>
                    </div>

                    <!-- Forgot Password -->
                    <div class="form-group">
                        <a href="#" style="text-align: right;">
                            <h6 class="text-secondary">Forgot your password?</h6>
                        </a>
                    </div>

                    <!-- Google Captcha -->
                    <div class="form-group">
                        <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                        <span class="errors"><?php echo $recaptcha_error; ?></span>
                    </div>

                    <!-- Login Buttons -->
                    <div class="form-group my-3">
                        <input type="submit" id="submit" value="Login" class="btn btn-warning w-100">
                    </div>
                </form>
            </div>

            <!-- REGISTER -->
            <div class="col-md-6">
                <h5 class="text-center" style="margin-bottom: 40px;">Create your account</h5>
                <p>Create your customer account in just a few clicks! Register today through your email address and enjoy shopping with us!</p>
                <a href="index.php?page=register"><button class="btn w-100">Create Account Via Email</button></a>
            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Primary Footer Template -->
<?= primary_footerTemplate(); ?>

<!-- Footer -->
<?= footerTemplate(); ?>