<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$firstName = $lastName = $email = $password = $confirmPassword = $phoneNumber = $recaptcha = "";
$firstName_error = $lastName_error = $email_error = $password_error = $confirmPassword_error = $phoneNumber_error = $recaptcha_error = "";

// Google reCAPTCHA API key configuration
$site_key = "6LeyX04cAAAAAOZiUSPypBh5G-wwyC1jozGbU1qc";
$secret_key = "6LeyX04cAAAAAEhgmzA9eE_FRr-y6qzyqnXcoUnX";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate firstName
    if (empty(trim($_POST['firstName']))) {
        $firstName_error = "Field is required!";
    } elseif (!preg_match("/^[A-Za-z]+$/", trim($_POST['firstName']))) {
        $firstName_error = "Only letters are allowed!";
    } else {
        $firstName = trim($_POST["firstName"]);
    }

    // Validate lastName
    if (empty(trim($_POST["lastName"]))) {
        $lastName_error = "Field is required!";
    } elseif (!preg_match("/^[A-Za-z]+$/", trim($_POST['lastName']))) {
        $lastName_error = "Only letters are allowed!";
    } else {
        $lastName = trim($_POST['lastName']);
    }

    // Validate Email Address
    if (empty(trim($_POST['email']))) {
        $email_error = "Field is required!";
    } elseif (!preg_match("/^\S+@\S+\.\S+$/", trim($_POST['email']))) {
        $email_error = "Invalid email format!";
    } else {
        // Prepare a SELECT statement to check whether the email address exists
        $sql = "SELECT * FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variable to the prepared statement as a parameter
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set Parameters
            $param_email = trim($_POST['email']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $email_error = "Email is already taken!";
                } else {
                    $email = trim($_POST['email']);
                }
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Validate Password
    if (empty(trim($_POST['password']))) {
        $password_error = "Field is required!";
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $password_error = "Passwords must have more than 8 characters!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate Confirm Password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Field is required!";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        // Check if the password and confirmed passwords match
        if (!empty($password_error) && ($password != $confirmPassword)) {
            $confirmPassword_error = "Passwords do not match!";
        }
    }

    // Validate Phone Number
    if (empty(trim($_POST['phoneNumber']))) {
        $phoneNumber_error = "Field is required!";
    } else {
        $phoneNumber = trim($_POST['phoneNumber']);
    }

    // Check for errors before dealing with the database
    if (empty($firstName_error) && empty($lastName_error) && empty($email_error) && empty($password_error) && empty($confirmPassword_error) && empty($phoneNumber_error)) {
        // Validate the Google reCaptcha Box
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Verify the recaptcha response
            $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

            // Decode JSON data
            $response_data = json_decode($verify_response);

            // If the recaptcha response is valid
            if ($response_data->success) {
                // Prepare a INSERT statement into the database
                $sql = "INSERT INTO users(firstName, lastName, email, phoneNumber, password) VALUES (
                    :firstName, :lastName, :email, :phoneNumber, :password)";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":firstName", $param_firstName, PDO::PARAM_STR);
                    $stmt->bindParam(":lastName", $param_lastName, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_INT);
                    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                    // Set Parameters
                    $param_firstName = $firstName;
                    $param_lastName = $lastName;
                    $param_email = $email;
                    $param_phoneNumber = $phoneNumber;
                    $param_password = password_hash($password, PASSWORD_DEFAULT);

                    // Attempt to execute
                    if ($stmt->execute()) {
                        // Redirect the user to the login page
                        header("location: index.php?page=login");
                        exit;
                    } else {
                        echo "There was an error. Please try again!";
                    }

                    // Close the statement
                    unset($stmt);
                }
            } else {
                $recaptcha_error = "Invalid ReCAPTCHA response!";
            }
        } else {
            $recaptcha_error = "reCAPTCHA field is required!";
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTER'); ?>

<!-- Login redirect -->
<div class="container">
    <div class="row my-5">
        <p><a class="text-secondary" href="index.php?page=login"><i class="bi bi-arrow-left-circle"></i> Login</a></p>
    </div>
</div>

<!-- User Register -->
<div id="login" style="margin-bottom: 45px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h5>Create Account</h5>
                <form action="index.php?page=register" method="post" class="login-form">
                    <div class="row">
                        <!-- First Name -->
                        <div class="form-group col-6">
                            <label for="FirstName">First Name*</label>
                            <input type="text" name="firstName" class="form-control 
                            <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstName; ?>">
                            <span class="errors"><?php echo $firstName_error; ?></span>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group col-6">
                            <label for="LastName">Last Name*</label>
                            <input type="text" name="lastName" class="form-control 
                            <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastName; ?>">
                            <span class="errors"><?php echo $lastName_error; ?></span>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="emailAddress">Email Address*</label>
                        <input type="email" name="email" autocomplete="off" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="errors"><?php echo $email_error; ?></span>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="form-group col-6">
                            <label for="Password">Password*</label>
                            <input type="password" name="password" id="user_input" class="form-control 
                            <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <i class="bi bi-eye" onclick="passwordView()" style="cursor: pointer; float: right; margin-right: 10px; margin-top: -33px; position: relative"></i>
                            <span class="errors"><?php echo $password_error; ?></span>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group col-6">
                            <label for="ConfirmPassword">Confirm Password*</label>
                            <input type="password" name="confirmPassword" id="passConfirm" class="form-control 
                            <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirmPassword; ?>">
                            <i class="bi bi-eye" onclick="confirmPass()" style="cursor: pointer; float: right; margin-right: 10px; margin-top: -33px; position: relative"></i>
                            <span class="errors"><?php echo $confirmPassword_error; ?></span>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group col-md-6">
                        <label for="phoneNumber">Phone Number*</label>
                        <input type="text" placeholder="+254..." name="phoneNumber" class="form-control 
                        <?php echo (!empty($phoneNumber_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $phoneNumber; ?>">
                        <span class="errors"><?php echo $phoneNumber_error; ?></span>
                    </div>

                    <!-- ReCAPTCHA Bot -->
                    <div class="form-group">
                        <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                        <span class="errors"><?php echo $recaptcha_error; ?></span>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group my-3">
                        <input type="submit" id="submit" value="Create Account" class="btn w-100">
                    </div>

                    <div class="form-group text-center my-4">
                        <p class="text-secondary">Already have an account?</p>
                        <h6 style="text-transform: uppercase;"><a href="index.php?page=login" style="text-decoration: none; color: #335c67">Login</a></h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer -->
<?= footerTemplate(); ?>