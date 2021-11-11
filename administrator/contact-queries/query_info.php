<?php
// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$admin_response = $success = "";
$admin_response_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate the admin response
    if (empty(trim($_POST['admin_response']))) {
        $admin_response_error = "Field is required!";
    } else {
        $admin_response = trim($_POST['admin_response']);
    }

    // Check for errors before dealing with the database
    if (empty($admin_response_error)) {
        //  UPDATE the contact_queries table(admin_response & is_read)
        $sql = "UPDATE contact_queries SET admin_response = :admin_response, is_read = :is_read WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":admin_response", $param_admin_response, PDO::PARAM_STR);
            $stmt->bindParam(":is_read", $param_is_read, PDO::PARAM_INT);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_admin_response = $admin_response;
            $param_is_read = 1;
            $param_id = $_GET['id'];

            // Attempt to execute
            if ($stmt->execute()) {
                $success = "Query info has been updated successfully!";
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the prepared statement
            unset($stmt);
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | QUERY_DETAILS'); ?>

<!-- Main Navbar -->
<?php include_once "./administrator/includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Admin Query Info</h5>
        </div>
    </div>
</div>

<div id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <?php
                $sql = $pdo->prepare("SELECT * FROM contact_queries WHERE id = '" . $_GET['id'] . "'");
                $sql->execute();
                $database_query_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_query_info as $query_info) : ?>
                    <form action="#" method="post" class="login-form">
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

                        <div class="form-group">
                            <div class="row">
                                <!-- FirstName -->
                                <div class="col-6">
                                    <label for="FirstName">First Name</label>
                                    <input type="text" readonly value="<?= $query_info['firstName']; ?>" class="form-control">
                                </div>

                                <!-- LastName -->
                                <div class="col-6">
                                    <label for="LastName">Last Name</label>
                                    <input type="text" readonly value="<?= $query_info['lastName']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="EmailAddress">Email Address</label>
                            <input type="email" readonly value="<?= $query_info['email']; ?>" class="form-control">
                        </div>

                        <!-- Subject -->
                        <div class="form-group">
                            <label for="Subject">Subject</label>
                            <input type="text" readonly value="<?= $query_info['subject']; ?>" class="form-control">
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="Message">Message</label>
                            <textarea class="form-control" readonly><?= $query_info['message']; ?></textarea>
                        </div>

                        <!-- Posting Date -->
                        <div class="form-group">
                            <label for="PostingDate">Posting Date</label>
                            <input type="text" readonly value="<?= $query_info['posting_date']; ?>" class="form-control">
                        </div>

                        <!-- Admin Response -->
                        <div class="form-group">
                            <label for="AdminResponse">Admin Response</label>
                            <textarea class="form-control 
                            <?php echo (!empty($admin_response_error)) ? 'is-invalid' : ''; ?>" name="admin_response"></textarea>
                            <span class="text-danger"><?php echo $admin_response_error; ?></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group my-3">
                            <input type="submit" value="Update Query" class="btn w-100">
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?= footerTemplate(); ?>