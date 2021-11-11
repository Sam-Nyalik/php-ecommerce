<?php 

    // Start session
    session_start();

    include_once "functions/functions.php";
    $pdo = databaseConnect();

    $id = $_GET['id'];

    $sql = "DELETE FROM product_types WHERE id = '$id'";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute()){
        header("location: index.php?page=administrator/all_product_types");
        exit;
    } else {
        echo "There was an error. Please try again!";
    }
