<?php 
    // Check if the user is logged in
    include_once "user/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

    // Define variables and assign them empty values
    $email = "";

    // Process form data when the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Validate email address
        if(empty(trim($_POST['newsletter-email']))){
            header("location: index.php?page=user/login");
        } else {
            $email = trim($_POST['newsletter-email']);
        }

        // Prepare an INSERT statement
        $sql = "INSERT INTO newsletter_subscription(email) VALUES(:email)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set Parameters
            $param_email = $email;
            // Attempt to execute
            if($stmt->execute()){
                echo "<script>alert('You have successfully registered for our newsletter notifications!');</script>";
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }

    ?>

<!-- Newsletter -->
<div id="newsletter">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h3>Subscribe to our Newsletter</h3>
                <form action="#" method="post" class="newsletter-form">
                    <?php
                    if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                        $id = false;
                        if (isset($_SESSION['id'])) {
                            $id = $_SESSION['id'];
                        }
                        // Prepare a SELECT statement to fetch the logged in user's email
                        $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                        $sql->execute();
                        $database_user_email = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <?php foreach ($database_user_email as $user_email) : ?>
                            <input type="email" name="newsletter-email" autocomplete="off" placeholder="Email Address..." class="form-control" value="<?= $user_email['email']; ?>">
                            <button class="btn">Subscribe</button>
                        <?php endforeach; ?>
                    <?php  } else { ?>
                        <input type="email" name="newsletter-email" autocomplete="off" placeholder="Email Address..." class="form-control" value="">
                        <button class="btn">Subscribe</button>
                    <?php    } ?>
                </form>
            </div>
        </div>
    </div>
</div>
