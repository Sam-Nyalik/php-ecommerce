<?php

// Include the functions file
include_once "functions/functions.php";
$pdo = databaseConnect();

?>

<!-- Total Number of items in the cart -->
<?php include_once "number_of_items_in_cart.php"; ?>

<!-- Include the header template -->
<?= headerTemplate('HOME'); ?>

<!-- TopBar -->
<?= top_barTemplate() ?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce.</a></h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                        <a href="index.php?page=all_product_categories/apple_products" class="dropdown-item">Apple</a>
                        <a href="index.php?page=all_product_categories/samsung_products" class="dropdown-item">Samsung</a>
                        <a href="index.php?page=all_product_categories/huawei_products" class="dropdown-item">Huawei</a>
                        <a href="index.php?page=all_product_categories/dell_products" class="dropdown-item">Dell</a>
                        <a href="index.php?page=all_product_categories/hp_products" class="dropdown-item">Hp</a>
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
                <a href="index.php?page=cart"><i class="bi bi-bag active" style="margin-right: 30px;"><span class="text-dark">(<?php echo $total_items_in_cart; ?>)</span></i></a>
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
            <div class="section-title">
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
                                <img src="<?= $recentProduct['productImage']; ?>" alt="<?= $recentProduct['productName']; ?>" class="img-fluid card-img-top">
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
                                <small class="text-muted"><s style="font-size: 16px;">&dollar;<?= $recentProduct['productRetailPrice']; ?></s></small>
                                <h6 class="text-dark" style="font-weight:600;">&dollar;<?= $recentProduct['productPrice']; ?></h6>
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
                <form action="#" class="newsletter-form">
                    <input type="email" name="newsletter-email" autocomplete="off" placeholder="Email Address..." class="form-control">
                    <button class="btn">Subscribe</button>
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