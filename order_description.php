<?php 
    
    // Check if the user is logged in
    include_once "user/check_login.php";
    include_once "functions/functions.php";
    $pdo = databaseConnect();

    // Unset the cart session
    unset($_SESSION['cart']);

?>

<!-- Header Template -->
<?=headerTemplate('USER | ORDER-DESCRIPTION'); ?>

<div class="container" style="margin-top: 45px;">
    <div class="row">
        <p><a class="text-secondary" href="index.php?page=home"><i class="bi bi-arrow-left-circle"></i> Home</a></p>
    </div>
</div>

<div class="container">
    <div class="row">
        <h3 class="text-center">Your order has been received. Thank you!</h3>
    </div>
</div>
