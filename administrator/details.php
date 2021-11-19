<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$companyName = $contactPerson = $companyAddress = $companyEmail = $companyPhoneNumber = "";
$companyName_error = $contactPerson_error = $companyAddress_error = $companyEmail_error = $companyPhoneNumber_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate company name
    if (empty(trim($_POST['companyName']))) {
        $companyName_error = "Field is required!";
    } else {
        $companyName = trim($_POST['companyName']);
    }

    // Validate contact person
    if (empty(trim($_POST['contactPerson']))) {
        $contactPerson_error = "Field is required!";
    } else {
        $contactPerson = trim($_POST['contactPerson']);
    }

    // Validate company email
    if (empty(trim($_POST['companyEmail']))) {
        $companyEmail_error = "Field is required!";
    } else {
        $companyEmail = trim($_POST['companyEmail']);
    }

    // Validate company phone number
    if (empty(trim($_POST['companyPhoneNumber']))) {
        $companyPhoneNumber_error = "Field is required!";
    } else {
        $companyPhoneNumber = trim($_POST['companyPhoneNumber']);
    }

    // Validate company address
    if (empty(trim($_POST['companyAddress']))) {
        $companyAddress_error = "Field is required!";
    } else {
        $companyAddress = trim($_POST['companyAddress']);
    }

    // Check for errors before dealing with the database
    if (empty($companyName_error) && empty($contactPerson_error) && empty($companyEmail_error) && empty($companyPhoneNumber_error) && empty($companyAddress_error)) {
        // Prepare an INSERT statement
        $sql = "UPDATE company_details SET companyName = :companyName, contactPerson = :contactPerson, address = :companyAddress, email = :companyEmail, phoneNumber = :companyPhoneNumber WHERE id = 1";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":companyName", $param_companyName, PDO::PARAM_STR);
            $stmt->bindParam(":contactPerson", $param_contactPerson, PDO::PARAM_STR);
            $stmt->bindParam(":companyAddress", $param_companyAddrress, PDO::PARAM_STR);
            $stmt->bindParam(":companyEmail", $param_companyEmail, PDO::PARAM_STR);
            $stmt->bindParam(":companyPhoneNumber", $param_companyPhoneNumber, PDO::PARAM_STR);

            // Set Parameters
            $param_companyName = $companyName;
            $param_contactPerson = $contactPerson;
            $param_companyAddrress = $companyAddress;
            $param_companyEmail = $companyEmail;
            $param_companyPhoneNumber = $companyPhoneNumber;

            // Attempt to execute
            if ($stmt->execute()) {
                echo "<script>alert('Company Details have been updated successfull!');</script>";
            } else {
                echo "There was an error. Please try again!";
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | SETTINGS'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Company Details</h5>
        </div>
    </div>
</div>

<!-- Add company Details -->
<div id="individual_product">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-7">
                <!-- Prepare a SELECT statement to fetch details from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM company_details WHERE id = 1");
                $sql->execute();
                $database_company_details = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <form action="index.php?page=administrator/details" method="post" class="individual_product_form">
                    <?php foreach ($database_company_details as $company_details) : ?>
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="CompanyName">Company Name</label>
                                    <input type="text" name="companyName" class="form-control 
                                <?php echo (!empty($companyName_error)) ? 'is-invalid' : ''; ?>" value="<?= $company_details['companyName']; ?>">
                                    <span class="errors text-danger"><?php echo $companyName_error; ?></span>
                                </div>
                            </div>

                            <!-- Contact Person -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ContactPerson">Contact Person</label>
                                    <input type="text" name="contactPerson" class="form-control 
                                <?php echo (!empty($contactPerson_error)) ? 'is-invalid' : ''; ?>" value="<?= $company_details['contactPerson']; ?>">
                                    <span class="errors text-danger"><?php echo $contactPerson_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="companyEmail">Company Email</label>
                                    <input type="email" name="companyEmail" class="form-control 
                                <?php echo (!empty($companyEmail_error)) ? 'is-invalid' : ''; ?>" value="<?= $company_details['email']; ?>">
                                    <span class="errors text-danger"><?php echo $companyEmail_error; ?></span>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="companyPhoneNumber">Phone Number</label>
                                    <input type="text" name="companyPhoneNumber" class="form-control 
                                <?php echo (!empty($companyPhoneNumber_error)) ? 'is-invaid' : ''; ?>" value="<?= $company_details['phoneNumber']; ?>">
                                    <span class="errors text-danger"><?php echo $companyPhoneNumber_error; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="CompanyAddress">Company Address</label>
                            <input type="text" name="companyAddress" class="form-control 
                        <?php echo (!empty($companyAddress_error)) ? 'is-invalid' : ''; ?>" value="<?= $company_details['address']; ?>">
                            <span class="errors text-danger"><?php echo $companyAddress_error; ?></span>
                        </div>

                        <!-- Update btn -->
                        <div class="form-group my-3">
                            <input type="submit" value="Update Company Details" class="btn w-100 bg-primary">
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>