<?php

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$search_item = "";
$search_item_error = $general_error = "";

// Process form data when the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate Search input
    if (empty(trim($_POST['search']))) {
        $search_item_error = "Field is required!";
    } else {
        // check if the product exists in the database
        $sql = "SELECT id FROM all_products WHERE productName = :search";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":search", $param_search, PDO::PARAM_STR);
            // Set parameters
            $param_search = trim($_POST['search']);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $search_item = trim($_POST['search']);
                } else {
                    $general_error = "";
                }
            } else {
                echo "There was an error. Please try again!";
            }

            // Close the statement
            unset($stmt);
        }
    }
}
?>


<div id="search_bar">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-12">
                <form action="index.php?page=home" method="post" class="search_bar_form">
                    <!-- General Error -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Search here..." class="form-control">
                        <span class="text-danger"><?php echo $search_item_error; ?></span>
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" class="btn rounded-pill" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="products">
    <div class="container">
        <div class="row text-center">
            <?php
            if (isset($_POST['search'])) {
                $product_data = trim($_POST['search']);

                // Prepare a SELECT statetemt to fetch product from the database with the specified input name
                $sql = $pdo->prepare("SELECT * FROM all_products WHERE productName LIKE '%$product_data%'");
                $sql->execute();
                if ($sql->rowCount() == 1) {
                    // Fetch the results and return them as an associative array
                    $database_searched_product = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

                    <h5 class="text-center">Results for "<?php echo $product_data; ?>"</h5>
                    <?php foreach ($database_searched_product as $searched_product) : ?>
                        <div class="col-md-3">
                            <a href="index.php?page=individual_product&id=<?= $searched_product['id']; ?>">
                                <div class="card">
                                    <div>
                                        <img src="<?= $searched_product['productImage1']; ?>" alt="<?= $searched_product['productName']; ?>" class="img-fluid img-responsive">
                                    </div>
                                    <div class="card-body">
                                        <h5><?= $searched_product['productName']; ?></h5>
                                        <h6 class="ratings">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </h6>
                                        <hr>
                                        <?php if ($searched_product['productRetailPrice'] > 0) : ?>
                                            <small class="text-muted"><s style="font-size: 16px;">&dollar;<?= $searched_product['productRetailPrice']; ?></s></small>
                                        <?php endif; ?>
                                        <h6 class="text-dark" style="font-weight: 600;">&dollar;<?= $searched_product['productPrice']; ?></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                <?php
                } else {
                ?>
                    <h3 class="text-center">Product with the name "<?php echo $product_data; ?>" wasn't found</h3>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>