<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "./functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$fullName = $email = $gender = $password = $confirmPassword = $profileImage = "";
$fullName_error = $email_error = $gender_error = $password_error = $confirmPassword_error = $profileImage_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fullName
    if (empty(trim($_POST["fullName"]))) {
        $fullName_error = "Full Name field is required!";
    } else {
        $fullName = trim($_POST["fullName"]);
    }

    // Validate emailAddress
    if (empty(trim($_POST["email"]))) {
        $email_error = "Email Field is required!";
    } else {
        // Check if the email address already exists
        // Prepare a SELECT statement
        $sql = "SELECT id FROM admin WHERE emailAddress = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute
            if ($stmt->execute()) {
                // Check if email already exists
                if ($stmt->rowCount() == 1) {
                    $email_error = "This email address already exists!";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                $email_error = "Something went wrong!";
            }

            // Close the prepared statement
            unset($stmt);
        }
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $gender_error = "Gender field is required!";
    } else {
        $gender = $_POST["gender"];
    }

    // Validate Password & check if it has more than 8 characters
    if (empty(trim($_POST["password"]))) {
        $password_error = "Password field is required!";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_error = "Password must have at least 8 characters!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password and check if it matches with the password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Confirm password field is required!";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        if (empty($password_error) && ($password !== $confirmPassword)) {
            $confirmPassword_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if (empty($fullName_error) && empty($email_error) && empty($gender_error) && empty($password_error) && empty($confirmPassword_error)) {
        if (!empty($_FILES['profileImage']['name'])) {
            move_uploaded_file($_FILES['profileImage']['tmp_name'], "administrator/profileImages/" . $_FILES['profileImage']['name']);
            $profileImage = "administrator/profileImages/" . $_FILES['profileImage']['name'];

            // Prepare an INSERT statement
            $sql = "INSERT INTO admin(fullName, emailAddress, gender, password, profileImage) VALUES(:fullName, :email, :gender, :password, :profileImage)";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":fullName", $param_fullName, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":profileImage", $param_profileImage, PDO::PARAM_STR);
                // Set parameters
                $param_fullName = $fullName;
                $param_email = $email;
                $param_gender = $gender;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_profileImage = $profileImage;
                // Attempt to execute
                if ($stmt->execute()) {
                    header("location: index.php?page=administrator/login");
                } else {
                    echo "There was an error. Please try again!";
                }

                // Unset the prepared statement
                unset($stmt);
            }
        } else {
            $profileImage_error = "Profile Image is required!";
        }
    }

    // Close the connection
    unset($pdo);
}

?>

<?= headerTemplate('ADMIN | REGISTER'); ?>

<div id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/register" method="post" class="login-form" enctype="multipart/form-data">
                    <!-- General errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- FullName Error -->
                                <li> <?php if ($fullName_error) {
                                            echo $fullName_error;
                                        } ?></li>

                                <!-- Email Address error -->
                                <li> <?php if ($email_error) {
                                            echo $email_error;
                                        } ?></li>

                                <!-- Gender Error -->
                                <li> <?php if ($gender_error) {
                                            echo $gender_error;
                                        } ?></li>

                                <!-- Profile Image Error -->
                                <li><?php
                                    if ($profileImage_error) {
                                        echo $profileImage_error;
                                    }
                                    ?></li>

                                <!-- Password Error -->
                                <li> <?php if ($password_error) {
                                            echo $password_error;
                                        } ?></li>

                                <!-- Confirm Password Error -->
                                <li> <?php if ($confirmPassword_error) {
                                            echo $confirmPassword_error;
                                        } ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- FullName -->
                    <div class="form-group">
                        <input type="text" name="fullName" placeholder="Full Name" class="form-control 
                        <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullName; ?>">
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label for="gender">Gender</label> <br>
                        <input type="radio" name="gender" value="Male" <?php if (isset($gender) && $gender == "Male") echo "checked"; ?>> Male
                        <input type="radio" name="gender" value="Female" <?php if (isset($gender) && $gender == "Female") echo "checked"; ?>> Female
                        <input type="radio" name="gender" value="Other" <?php if (isset($gender) && $gender == "Other") echo "checked"; ?>> Other
                    </div>

                    <!-- Profile Image -->
                    <div class="form-group">
                        <label for="profileImage">Profile Image</label>
                        <input type="file" name="profileImage" accept=".jpeg, .jpg, .png" class="form-control 
                        <?php echo (!empty($profileImage_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control 
                        <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control 
                        <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Register" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>