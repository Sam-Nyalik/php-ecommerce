<?php 

// Start a session
session_start();

// Check if the admin is logged in
include_once "./administrator/includes/check_login.php";
include_once "./functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Header Template -->
<?=headerTemplate('ADMIN | NOT_READ_QUERIES'); ?>

<!-- Main Admin Navbar -->
<?php include_once "./administrator/includes/main_navbar.php"; ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Admin Unread Queries</h5>
        </div>
    </div>
</div>

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
                                <th>More Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- SELECT from the contact_queries table where is_read column = 0 -->
                            <?php
                                $count = 1;
                                $sql = $pdo->prepare("SELECT * FROM contact_queries WHERE is_read = 0 ORDER BY posting_date DESC");
                                $sql->execute();
                                $database_contact_queries = $sql->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($database_contact_queries as $contact_queries): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?=$contact_queries['firstName'];?></td>
                                    <td><?=$contact_queries['lastName'];?></td>
                                    <td><?=$contact_queries['email'];?></td>
                                    <td class="text-center"><a href="index.php?page=administrator/contact-queries/query_info&id=<?=$contact_queries['id']; ?>"><i class="bi bi-files"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Template -->
<?=footerTemplate();?>
