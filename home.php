<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include the functions file
include_once "functions/functions.php";
$pdo = databaseConnect();


?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php"; ?>

<!-- Include the header template -->
<?= headerTemplate('HOME'); ?>

<!-- TopBar -->
<?php include_once "inc/top-bar.php"; ?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <div class="side_nav" id="bars_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bars"></div>
            <div class="bars"></div>
            <div class="bars"></div>
        </div>
        <ul class="bars_drop dropdown-menu" aria-labelledby="bars_dropdown">
            <a href="" class="dropdown-item"><img src="icons/restaurant.png" alt="food"> Food</a>
            <a href="" class="dropdown-item"><img src="icons/soft-drink.png" alt="Beverages"> Beverages</a>
            <a href="" class="dropdown-item"><img src="icons/shoes.png" alt="shoes"> Shoes</a>
            <a href="" class="dropdown-item"><img src="icons/clothes-hanger.png" alt="clothes"> Clothes</a>
            <a href="" class="dropdown-item"><img src="icons/work.png" alt="office"> Office</a>
            <a href="" class="dropdown-item"><img src="icons/furnitures.png" alt="furniture"> Furniture</a>
            <a href="" class="dropdown-item"><img src="icons/console.png" alt="games"> Gaming</a>
            <a href="" class="dropdown-item"><img src="icons/open-book.png" alt="Books"> Education</a>
        </ul>

        <h3 class="navbar-brand"><a href="index.php?page=home">
                <!-- Fetch company Name from the database -->
                <?php
                $sql = $pdo->prepare("SELECT companyName FROM company_details WHERE id = 1");
                $sql->execute();
                $database_company_name = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($database_company_name as $company_name) : ?>
                    <?= $company_name['companyName']; ?>
                <?php endforeach; ?>
            </a></h3>
        <div class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item"><img src="icons/apple.png" alt="apple"> Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item"><img src="icons/samsung.png" alt="samsung"> Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item"><img src="icons/huawei.png" alt="huawei"> Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item"><img src="icons/dell.png" alt="dell"> Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item"><img src="icons/hp.png" alt="hp"> Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="index.php?page=all_products" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="index.php?page=laptop_products" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <a href="index.php?page=cart"><i class="bi bi-cart4 active" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Search bar -->
<?= searchBarTemplate(); ?>

<!-- Main Carousel -->
<div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="container">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/image3.jpg" class="d-block w-100" height="600" alt="" srcset="">
                <div class="carousel-caption d-md-block">
                    <div class="carousel-caption-1" data-aos="fade-right">
                        <h5>New Apple Products</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique error cumque aliquid dolor dicta voluptate labore cum aperiam explicabo iusto!</p>
                        <button class="btn"><a href="index.php?page=all_product_categories/apple_products">Shop Now</a></button>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/image17.jpg" class="d-block w-100" height="600" alt="" srcset="">
                <div class="carousel-caption d-md-block">
                    <div class="carousel-caption-2">
                        <h5>New Huawei Products</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint sapiente quae fugiat explicabo voluptatem accusantium!</p>
                        <button class="btn"><a href="index.php?page=all_product_categories/huawei_products">Shop Now</a></button>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/image5.jpg" class="d-block w-100" height="600" alt="" srcset="">
                <div class="carousel-caption d-md-block">
                    <div class="carousel-caption-3">
                        <h5>New Samsung Products</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint sapiente quae fugiat explicabo voluptatem accusantium!</p>
                        <button class="btn"><a href="index.php?page=all_product_categories/samsung_products">Shop Now</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div id="featured-products">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="images/image7.jpg" alt="" class="img-fluid">
                <h5>Phone Products</h5>
                <a href="index.php?page=phone_products"><button class="btn">See More</button></a>
                <p>35% Discount</p>
            </div>
            <div class="col-md-7">
                <img src="images/image8.jpg" class="img-fluid" alt="" srcset="">
                <h5><span></span> Laptop Products</h5>
                <a href="index.php?page=laptop_products"><button class="btn">See More</button></a>
            </div>
        </div>
    </div>
</div>

<!-- Recently Added Products -->
<div id="products">
    <div class="container">
        <div class="row text-center">
            <div class="section-title1">
                <h5><span>Recently Added</span> Products</h5>
            </div>
            <?php
            // Fetch 4 products from the recently_added_products table in the database
            $stmt = $pdo->prepare("SELECT * FROM all_products ORDER BY date_added DESC LIMIT 4");
            $stmt->execute();
            $recentlyAddedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($recentlyAddedProducts as $recentProduct) : ?>
                <div class="col-md-3 col-sm-6 my-3 my-md-0">
                    <a href="index.php?page=individual_product&id=<?= $recentProduct['id']; ?>">
                        <div class="card">
                            <div>
                                <img src="<?= $recentProduct['productImage1']; ?>" alt="<?= $recentProduct['productName']; ?>" class="img-fluid card-img-top">
                            </div>
                            <div class="card-body">
                                <h5><?= $recentProduct['productName']; ?></h5>
                                <h6 class="ratings">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </h6>
                                <hr>
                                <?php if ($recentProduct['productRetailPrice'] > 0) : ?>
                                    <small class="text-muted"><s style="font-size: 16px;">Ksh. <?= $recentProduct['productRetailPrice']; ?></s></small>
                                <?php endif; ?>
                                <h6 class="text-dark" style="font-weight:600;">Ksh. <?= $recentProduct['productPrice']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="see-more">
            <div class="row g-0 text-center">
                <div class="col-md-12">
                    <a href="index.php?page=all_products" class="btn-outline rounded-pill">All Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Favorite Brands -->
<div id="brands">
    <div class="container">
        <div class="row">
            <h3 class="text-center">Shop from your favorite brands</h3>
            <!-- Apple -->
            <div class="col-md-2">
                <a href="index.php?page=all_product_categories/apple_products">
                    <h5>Apple</h5>
                    <!-- Fetch Apple image from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'Apple' ORDER BY date_added ASC LIMIT 1");
                    $sql->execute();
                    $database_apple_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_apple_brand as $apple_brand) : ?>
                        <img src="<?= $apple_brand['productImage1']; ?>" class="img-fluid" alt="">
                    <?php endforeach; ?>
                </a>
            </div>

            <!-- Huawei -->
            <div class="col-md-2">
                <a href="index.php?page=all_product_categories/huawei_products">
                    <h5>Huawei</h5>
                    <!-- Fetch Apple image from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'Huawei' ORDER BY date_added ASC LIMIT 1");
                    $sql->execute();
                    $database_apple_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_apple_brand as $apple_brand) : ?>
                        <img src="<?= $apple_brand['productImage']; ?>" class="img-fluid" alt="">
                    <?php endforeach; ?>
                </a>
            </div>

            <!-- Samsung -->
            <div class="col-md-2">
                <a href="index.php?page=all_product_categories/samsung_products">
                    <h5>Samsung</h5>
                    <!-- Fetch Apple image from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'Samsung' ORDER BY date_added ASC LIMIT 1");
                    $sql->execute();
                    $database_apple_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_apple_brand as $apple_brand) : ?>
                        <img src="<?= $apple_brand['productImage1']; ?>" class="img-fluid" alt="">
                    <?php endforeach; ?>
                </a>
            </div>

            <!-- Dell -->
            <div class="col-md-2">
                <a href="index.php?page=all_product_categories/dell_products">
                    <h5>Dell</h5>
                    <!-- Fetch Apple image from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'Dell' ORDER BY date_added ASC LIMIT 1");
                    $sql->execute();
                    $database_apple_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_apple_brand as $apple_brand) : ?>
                        <img src="<?= $apple_brand['productImage']; ?>" class="img-fluid" alt="">
                    <?php endforeach; ?>
                </a>
            </div>

            <!-- HP -->
            <div class="col-md-2">
                <a href="index.php?page=all_product_categories/hp_products">
                    <h5>HP</h5>
                    <!-- Fetch Apple image from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM all_products WHERE productBrand = 'HP' ORDER BY date_added ASC LIMIT 1");
                    $sql->execute();
                    $database_apple_brand = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($database_apple_brand as $apple_brand) : ?>
                        <img src="<?= $apple_brand['productImage']; ?>" class="img-fluid" alt="">
                    <?php endforeach; ?>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Advertisement Section -->
<div id="main-advertisement">
    <div class="container">
        <!-- Get main advertisement details from the database -->
        <?php
        $stmt = $pdo->prepare("SELECT * FROM main_advertisement ORDER BY date_added DESC LIMIT 1");
        $stmt->execute();
        $main_advert = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($main_advert as $advert) : ?>
            <div class="row">
                <div class="col-md-12">
                    <img src="<?= $advert['productImage']; ?>" class="img-fluid" alt="<?= $advert['productName']; ?>" srcset="" data-aos="fade-up">
                    <div class="advertisement-description" data-aos="fade-down">
                        <h1><?= $advert["productName"] ?></h1>
                        <p><?= $advert["productDescription"]; ?></p>
                        <a href="index.php?page=main_advert&id=<?= $advert['id']; ?>">See More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- about-orders -->
<div id="about-orders">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="bi bi-arrow-90deg-left"></i>
                    </div>
                    <div class="card-body">
                        <h4>Free Returns</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet quasi nam commodi dolor cum, libero rem expedita rerum deserunt nihil.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="bi bi-truck-flatbed"></i>
                    </div>
                    <div class="card-body">
                        <h4>Free Shipping</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet quasi nam commodi dolor cum, libero rem expedita rerum deserunt nihil.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="bi bi-flag-fill"></i>
                    </div>
                    <div class="card-body">
                        <h4>Customer Support</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet quasi nam commodi dolor cum, libero rem expedita rerum deserunt nihil.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter -->
<div id="newsletter">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h3>Subscribe to our Newsletter</h3>
                <form action="#" method="post" class="newsletter-form">
                    <?php
                    if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                        $id = false;
                        if (isset($_SESSION['id'])) {
                            $id = $_SESSION['id'];
                        }
                        // Prepare a SELECT statement to fetch the logged in user's email
                        $sql = $pdo->prepare("SELECT * FROM users WHERE id = '$id'");
                        $sql->execute();
                        $database_user_email = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <?php foreach ($database_user_email as $user_email) : ?>
                            <input type="email" name="newsletter-email" autocomplete="off" placeholder="Email Address..." class="form-control" value="<?= $user_email['email']; ?>">
                            <button class="btn">Subscribe</button>
                        <?php endforeach; ?>
                    <?php  } else { ?>
                        <input type="email" name="newsletter-email" autocomplete="off" placeholder="Email Address..." class="form-control" value="">
                        <button class="btn">Subscribe</button>
                    <?php    } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Social Media Links -->
<div id="social_links">
    <div class="container">
        <div class="row">
            <div class="col-md-6 my-3">
                <h2>Connect With Us Today!</h2>
            </div>
            <div class="col-md-6 my-3 d-flex justify-content-end">
                <div class="social_icons">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-linkedin"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Back to top -->
<a href="#top-bar">
    <div id="back_to_top" class=" d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <i class="bi bi-chevron-double-up"></i>
            </div>
        </div>
    </div>
</a>


<!-- Footer Section -->
<?= footerTemplate(); ?>