<?php
// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$fullName = $profileImage = "";
$fullName_error = $profileImage_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fullName
    if (empty(trim($_POST["fullName"]))) {
        $fullName_error = "Full Name field is required!";
    } else {
        $fullName = trim($_POST["fullName"]);
    }

    // Check for errors before dealing with the database
    if (empty($fullName_error)) {
        $id = false;
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        }
        if (!empty($_FILES['profileImage']['name'])) {
            move_uploaded_file($_FILES['profileImage']['tmp_name'], "administrator/profileImages/" . $_FILES['profileImage']['name']);
            $profileImage = "administrator/profileImages/" . $_FILES['profileImage']['name'];

            // Prepare an update statement
            $sql = "UPDATE admin SET fullName = :fullName, profileImage = :profileImage WHERE id = '$id'";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":fullName", $param_fullName, PDO::PARAM_STR);
                $stmt->bindParam(":profileImage", $param_profileImage, PDO::PARAM_STR);
                // Set parameters
                $param_fullName = $fullName;
                $param_profileImage = $profileImage;
                // Attempt to execute
                if ($stmt->execute()) {
                    echo "<script>alert('Admin profile has been updated successfully!');</script>";
                } else {
                    echo "There was an error. Please try again!";
                }

                // Close the statement
                unset($stmt);
            }
        }
    }
}
?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | PROFILE') ?>

<?php include_once "includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Admin Profile</h5>
        </div>
    </div>
</div>

<!-- Admin Profile -->
<div id="login">
<div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Fetch admin data from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM admin WHERE id = '$id'");
                $sql->execute();
                $admin_data = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($admin_data as $data) :  ?>
                    <form action="index.php?page=administrator/profile" method="post" enctype="multipart/form-data" class="login-form">
                        <!-- Creation Date Time -->
                        <h5 class="text-muted"><span class="text-dark">Creation Date: </span><?= $data['creationDate']; ?></h5>
                        <h5 class="text-muted"><?php
                            if ($data['updationDate']) : ?>
                                <span class="text-dark">Last Updation Date: </span> <?php echo $data['updationDate']; ?>

                            <?php endif; ?>
                        </h5>

                        <!-- General Errors -->
                        <div class="form-group">
                            <span class="text-danger">
                                <ul>
                                    <!-- FullName Error -->
                                    <li><?php
                                        if ($fullName_error) {
                                            echo $fullName_error;
                                        }
                                        ?></li>
                                </ul>
                            </span>
                        </div>
                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" name="fullName" placeholder="Enter Full Name" value="<?= $data['fullName']; ?>" class="form-control 
                            <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Profile Image -->
                        <div class="form-group">
                            <label for="profileImage">Profile Image</label>
                            <input type="file" accept=".jpeg, .jpg, .png" name="profileImage" class="form-control 
                            <?php echo (!empty($profileImage_error)) ? 'is-invalid' : ''; ?>">
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" name="email" placeholder="Enter Email Address" readonly value="<?= $data['emailAddress']; ?>" class="form-control">
                        </div>

                        <!-- Update btn -->
                        <div class="form-group">
                            <input type="submit" value="Update Profile" class="btn w-100">
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<!-- Footer Template -->
<?= footerTemplate(); ?>