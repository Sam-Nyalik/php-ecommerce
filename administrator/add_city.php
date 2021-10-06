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
$city = $success = "";
$city_error = $general_error = "";

// Fetch data from the region's table
$sql = $pdo->prepare("SELECT * FROM region");
$sql->execute();
$database_region_info = $sql->fetchAll(PDO::FETCH_ASSOC);
$region_id = $database_region_info['id'];

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate city
    if (empty(trim($_POST['city']))) {
        $city_error = "Field is required!";
    } else {
        $city = trim($_POST['city']);
    }

    // Check for errors before dealing with the database
    if (empty($city_error)) {
        // Prepare an INSERT statement
        $query = "INSERT INTO city(region_id, name) VALUES(:region_id, :city)";
        if ($stmt = $pdo->prepare($query)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":region_id", $param_regionId, PDO::PARAM_INT);
            $stmt->bindParam(":city", $param_city, PDO::PARAM_STR);
            // Set parameters
            $param_regionId = $region_id;
            $param_city = $city;
            // Attempt to execute
            if ($stmt->execute()) {
                $success = "You have successfully added a new city";
            } else {
                $general_error = "There was an error. Please try again!";
            }

            // Close the connection
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
                    <h5>Add City</h5>
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
                <form action="index.php?page=administrator/add_city" method="post" class="login-form">
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
                    <!-- City -->
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control 
                        <?php echo (!empty($city_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                        <span class="errors"><?php echo $city_error; ?></span>
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add City" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>