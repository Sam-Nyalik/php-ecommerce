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
                <i class="bi bi-person" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                    <h3 class="dropdown-item">
                        <!-- Get Administrator's name from the database -->
                        <?php
                        $id = false;
                        if (isset($_SESSION['id'])) {
                            $id = $_SESSION['id'];
                        }
                        $sql = $pdo->query("SELECT fullName FROM admin WHERE id = '$id'");
                        while ($row = $sql->fetch()) {
                            echo $row['fullName'];
                        }
                        ?>
                    </h3>
                    <h5 class="dropdown-item">Administrator</h5>
                    <hr>
                    <h6 class="dropdown-item"><a href="">Profile</a></h6>
                    <h6 class="dropdown-item"><a href="">Change Password</a></h6>
                    <hr>
                    <h6 class="dropdown-item"><a href="index.php?page=administrator/logout" onclick="logout()">Sign-Out</a></h6>
                </div>
            </div>
        </div>
    </div>
</div>