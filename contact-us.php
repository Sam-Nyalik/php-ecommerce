<?php

include_once "functions/functions.php";

?>

<!-- Header template -->
<?= headerTemplate('CONTACT US'); ?>

<!-- Topbar -->
<?= top_barTemplate() ?>

<!-- Main Navbar -->
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
                    <a class="nav-link" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="" class="dropdown-item">Apple</a>
                        <a href="" class="dropdown-item">Samsung</a>
                        <a href="" class="dropdown-item">Huawei</a>
                        <a href="" class="dropdown-item">Dell</a>
                        <a href="" class="dropdown-item">Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link active">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <i class="bi bi-bag" style="margin-right: 30px;"><span class="text-dark">(0)</span></i>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Contact Header -->
<div id="contact_header">
    <div class="container">
        <div class="row text-center">
            <div class="contact_header_description">
                <h3>How Can We Help?</h3>
                <h5>Shoot us a message!</h5>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us -->
<div id="contact_us">
<div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="" class="contact_us_form">
                    <!-- FirstName -->
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        </div>
                    
                        <!-- LastName -->
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="EmailAddress">Email Address</label>
                        <input type="text" class="form-control">
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="" class="form-control"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer Template -->
<?= footerTemplate(); ?>