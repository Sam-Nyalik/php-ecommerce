
<?php 
     $id = false;
     if (isset($_SESSION['id'])) {
         $id = $_SESSION['id'];
     }
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
              
                <?php 
                    // Prepare a SELECT statement to fetch admin profile image
                    $sql = $pdo->prepare("SELECT * FROM admin WHERE id = '$id'");
                    $sql->execute();
                    $database_profile_image = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach($database_profile_image as $profile_image): ?>
                    <img src="<?=$profile_image['profileImage'];?>" id="dropdownMenu" class="img-fluid profileImage" data-bs-toggle="dropdown" aria-expanded="false" alt="<?=$profile_image['fullName'];?>">
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