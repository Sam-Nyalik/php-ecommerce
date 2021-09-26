<?php

// Start session
session_start();

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$region = $success = "";
$region_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate region
    if (empty(trim($_POST['region']))) {
        $region_error = "Field is required!";
    } else {
        $region = trim($_POST['region']);
    }

    // Check for errors before dealing with the database
    if (empty($region_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO region(name) VALUES(:region)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":region", $param_region, PDO::PARAM_STR);
            // Set parameters
            $param_region = $region;
            // Attempt to execute
            if ($stmt->execute()) {
                $success = "You have successfully added a new region!";
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
<?= headerTemplate('ADMIN | ALL_REGIONS'); ?>

<!-- Navbar -->
<?php include_once "includes/main_navbar.php" ?>

<!-- Section Title -->
<div class="section-title">
    <div class="container">
        <div class="row">
            <h5><span>Regions &</span> Cities</h5>
        </div>
    </div>
</div>

<!-- Profile Details -->
<div class="container">
    <div id="account_overview">
        <div class="row">
            <div class="col-md-8">
                <div class="overview_section">
                    <h5>Add Region</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Region and City Addition Form -->
<div id="login" style="margin-top: 45px">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <form action="index.php?page=administrator/add_region" method="post" class="login-form">
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

                    <!-- General Error Message -->
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
                    <!-- Region -->
                    <div class="form-group">
                        <label for="region">Region</label>
                        <input type="text" name="region" class="form-control 
                        <?php echo (!empty($region_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $region; ?>">
                        <span class="errors"><?php echo $region_error; ?></span>
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Region" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Cities -->
<div id="phone_products_btn">
    <div class="container">
        <div class="row text-center">
            <button class="btn"><a href="index.php?page=administrator/add_city">Add City</a></button>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>