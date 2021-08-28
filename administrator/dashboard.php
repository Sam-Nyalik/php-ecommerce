<?php
    // Start a session
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

?>

<?=headerTemplate('ADMIN | DASHBOARD'); ?>

<div id="main_navbar">
    <div class="container-fluid">
        <div class="row pt-4 flex-nowrap justify-content-between align-items-center">
            <div class="col-4">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="col-4 text-center">
                <h5>E-Commerce Web App</h5>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <h6 id="dropdown-menu" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    $id = false;
                    if(isset($id)){
                        $id = $_SESSION['id'];
                    }
                    // Prepare a SELECT query to get the admin's name from the database
                    $sql = $pdo->query("SELECT fullName FROM admin WHERE id = '$id'");

                    while($row = $sql->fetch(PDO::FETCH_BOTH)){
                        echo $row['fullName'];
                    }

                    ?>
                </h6>
            </div>
        </div>
    </div>
</div>