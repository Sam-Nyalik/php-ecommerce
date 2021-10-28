<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the user is logged in
include_once "user/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$firstName = $lastName = $phoneNumber = $gender = $address = $region = $city = $success = "";
$firstName_error = $lastName_error = $phoneNumber_error = $gender_error = $address_error = $region_error = $city_error = $general_error = "";

// Ensure that the session id isset
$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    if (empty(trim($_POST['firstName']))) {
        $firstName_error = "Field is required!";
    } else {
        $firstName = trim($_POST['firstName']);
    }

    // Validate last name
    if (empty(trim($_POST['lastName']))) {
        $lastName_error = "Field is required!";
    } else {
        $lastName = trim($_POST['lastName']);
    }

    // Validate phone number
    if (empty(trim($_POST['phoneNumber']))) {
        $phoneNumber_error = "Field is required!";
    } else {
        $phoneNumber = trim($_POST['phoneNumber']);
    }

    // Validate Gender
    $agreedToGender = false;

    if (isset($_POST['gender']) && !empty($_POST['gender'])) {
        // Create an array containing the input values that are allowed
        $allowedAnswers = array('Male', 'Female');

        // Create a variable with the value that the user sends
        $gender = $_POST['gender'];

        // Make sure that the value is in our array of values
        if (in_array($gender, $allowedAnswers)) {
            // Check if the user chose male
            if (strcasecmp($gender, 'Male') == 0) {
                $agreedToGender = true;
            }
        }
    }

    // Validate Address
    if (empty(trim($_POST['address']))) {
        $address_error = "Field is required!";
    } else {
        $address = trim($_POST['address']);
    }


    // Check for errors before dealing with the database
    if (empty($firstName_error) && empty($lastName_error) && empty($phoneNumber_error) && empty($address_error)) {
        // Prepare an UPDATE statement
        $sql = "UPDATE users SET firstName = :firstName, lastName = :lastName, phoneNumber = :phoneNumber, gender = :gender, address = :address WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":firstName", $param_firstName, PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $param_lastName, PDO::PARAM_STR);
            $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_INT);
            $stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
            $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_phoneNumber = $phoneNumber;
            $param_gender = $gender;
            $param_address = $address;
            $param_id = $id;

            // Attempt to execute
            if ($stmt->execute()) {
                $success = "Your profile has been updated successfully!";
            } else {
                $general_error = "There was an error. Please try again!";
            }

            // close the statement
            unset($stmt);
        }
    }
}


?>

<!-- Header Template -->
<?= headerTemplate('USER | EDIT_PROFILE'); ?>

<!-- Top bar -->
<?php include_once "inc/top-bar.php"; ?>

<!-- Navbar -->
<?php include_once "inc/navbar.inc.php"; ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Edit</span> Account</h5>
        </div>
    </div>
</div>

<!-- Profile Details -->
<div class="container">
    <div id="account_overview">
        <div class="row">
            <div class="col-md-8">
                <div class="overview_section">
                    <h5>Details</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="login" style="margin-top: -50px; margin-bottom: 45px">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- Prepare a SELECT statement to fetch user info from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                $sql->execute();
                $database_user_profile = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_user_profile as $user_profile) : ?>
                    <form action="index.php?page=user/account/edit" method="post" class="login-form">
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

                        <div class="form-group">
                            <span class="text-danger">
                                <ul>
                                    <li><?php
                                        if ($general_error) {
                                            echo $general_error;
                                        }
                                        ?></li>
                                </ul>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- First Name -->
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" name="firstName" value="<?= $user_profile['firstName']; ?>" class="form-control 
                                    <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors"><?php echo $firstName_error; ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" name="lastName" value="<?= $user_profile['lastName']; ?>" class="form-control 
                                    <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors"><?php echo $lastName_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Email Address -->
                                <div class="form-group">
                                    <label for="EmailAddress">Email Address</label>
                                    <input type="email" readonly value="<?= $user_profile['email']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Phone Number-->
                                <div class="form-group">
                                    <label for="PhoneNumber">Phone Number</label>
                                    <input type="text" name="phoneNumber" value="<?= $user_profile['phoneNumber']; ?>" class="form-control 
                                    <?php echo (!empty($phoneNumber_error)) ? 'is-invalid' : ''; ?>">
                                    <span class="errors"><?php echo $phoneNumber_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Gender -->
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="<?= $user_profile['gender']; ?>"><?= $user_profile['gender']; ?></option>
                                        <option name="Male" value="Male" <?php if (isset($_POST['gender']) && $_POST['gender'] == "Male") { ?> checked <?php } ?>>Male</option>
                                        <option name="Female" value="Female" <?php if (isset($_POST['gender']) && $_POST['gender'] == "Female") { ?> checked <?php } ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Address -->
                                <div class="form-group">
                                    <label for="address">Physical Address</label>
                                    <input type="text" name="address" placeholder="Enter your address" class="form-control 
                                    <?php echo (!empty($address_error)) ? 'is-invalid' : ''; ?>" value="<?= $user_profile['address']; ?>">
                                    <span class="errors"><?php echo $address_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-6">
                                Region 
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <select name="region" id="" class="form-control">
                                        <option value="" disabled>Select Region</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 City 
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <select name="city" id="" class="form-control">
                                        <option value="" disabled>Select Region</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <!-- Submit btn -->
                        <div class="form-group my-3">
                            <input type="submit" value="Save" class="btn w-100">
                        </div>
                    </form>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Primary Footer-->
<?= primary_footerTemplate(); ?>

<!-- Footer -->
<?= footerTemplate(); ?>