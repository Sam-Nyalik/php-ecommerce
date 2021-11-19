<?php 
    // Start session
    session_start();

    // Check if the admin is logged in
    include_once "includes/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

    // Delete Product brand when the delete button is clicked
        $sql = "DELETE FROM product_brands WHERE id = '".$_GET['id']."'";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()){
            header("location: index.php?page=administrator/all_product_brands");
            exit;
        } else {
            echo "There was an error. Please try again!";
        }
