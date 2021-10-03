<?php

// Start a session
session_start();

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL_USERS'); ?>

<!-- Main Navbar -->
<?php include_once "./administrator/includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>All Users</h5>
        </div>
    </div>
</div>

<!-- All Users Table -->
<div id="all_users">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Date Added</th>
                                <th>More Info</th>
                            </tr>
                        </thead>
                        <!-- Prepare a SELECT statement to fetch all the users from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM users");
                        $sql->execute();
                        $database_all_users = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $count = 1;
                        ?>
                        <?php foreach ($database_all_users as $all_users) : ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?= $all_users['firstName']; ?></td>
                                    <td><?= $all_users['lastName']; ?></td>
                                    <td><?= $all_users['email']; ?></td>
                                    <td><?= $all_users['phoneNumber']; ?></td>
                                    <td><?= $all_users['date_added']; ?></td>
                                    <td class="text-center"><a href="index.php?page=administrator/users/user_info&id=<?=$all_users['id']; ?>">
                                            <i class="bi bi-files"></i>
                                        </a></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?=footerTemplate(); ?>