<?php

include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Topbar Template -->
<div id="top-bar">
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="topbar-left">
                    <h5>Free Shipping on orders above $350</h5>
                </div>
            </div>
            <div class="col-md-8">
                <div class="topbar-right">
                    <div class="dropdown">
                        <?php
                        if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                            // Prepare a SELECT statement to fetch user's info
                            $id = false;
                            if (isset($_SESSION['id'])) {
                                $id = $_SESSION['id'];
                            }
                            $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                            $sql->execute();
                            $database_user_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <?php foreach ($database_user_info as $user_info) : ?>
                                <h6 class="dropdown-toggle" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-check"></i></i>Hi, <?= $user_info['firstName']; ?>
                                </h6>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    <a href="index.php?page=user/account/index">
                                        <h6 class="dropdown-item"><i class="bi bi-person"></i>My Account</h6>
                                    </a>
                                    <a href="index.php?page=user/order_history">
                                        <h6 class="dropdown-item"><i class="bi bi-archive"></i>Orders</h6>
                                    </a>
                                    <hr />
                                    <a href="index.php?page=user/logout"><button class="dropdown-item btn w-100 text-center">Logout</button></a>
                                </div>

                            <?php endforeach; ?>
                        <?php } else { ?>
                            <h6 class="dropdown-toggle" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-x"></i>User Account
                            </h6>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <a href="index.php?page=user/login"><button class="dropdown-item btn w-100 text-center">Sign In</button></a>
                                <hr />
                                <a href="index.php?page=user/account/index">
                                    <h6 class="dropdown-item"><i class="bi bi-person"></i>My Account</h6>
                                </a>
                                <a href="index.php?page=user/order_history">
                                    <h6 class="dropdown-item"><i class="bi bi-archive"></i>Orders</h6>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>