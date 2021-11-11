<?php
$id = false;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

//   Fetch the total number of unread queries from the database  
$sql = $pdo->prepare("SELECT * FROM contact_queries WHERE is_read = 0");
$sql->execute();
$database_contact_queries = $sql->rowCount();
?>
<div id="main_navbar">
    <div class="container-fluid">
        <div class="row pt-3 flex-nowrap justify-content-between align-items-center">
            <div class="col-4">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="col-4 text-center">
                <h5 class="main_title"><a href="index.php?page=administrator/dashboard">E-Commerce Web App</a></h5>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <div class="message_icon">
                    <div>
                        <i class="bi bi-bell" id="notificationMenu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <div class="dropdown-menu" aria-labelledby="notificationMenu">
                            <!-- Fetch Unread Queries from the database -->
                            <?php
                            $sql = $pdo->prepare("SELECT * FROM contact_queries WHERE is_read = '0'");
                            $sql->execute();
                            $rowcount = $sql->rowCount();
                            $database_contact_queries = $sql->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <h2 class="dropdown-item text-muted" style="font-size: 20px">Unread Messages: <span style="color: #540b0e;"><?= $rowcount; ?></span> </h3>
                            <hr>
                            <hr>
                            <?php foreach ($database_contact_queries as $contact_queries) : ?>
                                <a href="index.php?page=administrator/contact-queries/query_info&id=<?=$contact_queries['id']; ?>">
                                    <h2 class="text-dark" style="font-weight: 650; font-size: 18px"><?=$contact_queries['firstName'];?> <?=$contact_queries['lastName'];?></h2>
                                    <p class="text-muted" style="font-size: 12px; width: 250px"><?=$contact_queries['message'];?></p>
                                </a>
                            <?php endforeach; ?>
                            <hr>
                            <?php 
                                // Fetch Read Queries from the database
                                $sql = $pdo->prepare("SELECT * FROM contact_queries WHERE is_read = '1'");
                                $sql->execute();
                                $rowCount = $sql->rowCount();
                                $database_read_queries = $sql->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <h2 class="dropdown-item text-muted" style="font-size: 20px;">Read Messages: <span style="color: #540b0e;"><?=$rowCount?></span></h2>
                            <hr>
                            <hr>
                            <?php foreach($database_read_queries as $read_queries): ?>
                                <a href="index.php?page=administrator/contact-queries/read&id=<?=$read_queries['id'];?>?>">
                                <h2 class="text-dark" style="font-weight: 650; font-size: 18px"><?=$read_queries['firstName'];?> <?=$read_queries['lastName'];?></h2>
                                <p class="text-muted" style="font-size: 12px; width: 250px"><?=$read_queries['message'];?></p>
                                <h2 class="text-dark" style="font-weight:550; font-size: 15px">Admin Response: <span class="text-muted"><?=$read_queries['admin_response'];?></span></h2>
                                <hr>
                            </a>
                            <?php endforeach; ?>    
                        </div>
                    </div>
                </div>
                <?php
                // Prepare a SELECT statement to fetch admin profile image
                $sql = $pdo->prepare("SELECT * FROM admin WHERE id = '$id'");
                $sql->execute();
                $database_profile_image = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_profile_image as $profile_image) : ?>
                    <img src="<?= $profile_image['profileImage']; ?>" id="dropdownMenu" class="img-fluid profileImage" data-bs-toggle="dropdown" aria-expanded="false" alt="<?= $profile_image['fullName']; ?>">
                <?php endforeach; ?>

                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                    <h3 class="dropdown-item">
                        <!-- Get Administrator's name from the database -->
                        <?php
                        $sql = $pdo->query("SELECT fullName FROM admin WHERE id = '$id'");
                        while ($row = $sql->fetch()) {
                            echo $row['fullName'];
                        }
                        ?>
                    </h3>
                    <h5 class="dropdown-item">Administrator</h5>
                    <hr>
                    <h6 class="dropdown-item"><a href="index.php?page=administrator/profile">Profile</a></h6>
                    <h6 class="dropdown-item"><a href="index.php?page=administrator/change_password">Change Password</a></h6>
                    <hr>
                    <h6 class="dropdown-item"><a href="index.php?page=administrator/logout" onclick="logout()">Sign-Out</a></h6>
                </div>
            </div>
        </div>
    </div>
</div>