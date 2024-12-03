<?php 
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../sign-in.php");
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../sign-in.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLI n GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="homepage.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'home.php?function=categories',
                type: 'GET',
                success: function(data) {
                    $('#categories').html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });

            $.ajax({
                url: 'home.php?function=favourites',
                type: 'GET',
                success: function(data) {
                    $('#body-popular').html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });
        });
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-sm fixed-top" id="navbar">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
              <a class="nav-link" href="/proyek-tekweb/allProduct/allproduct.php" id="allproduct">All Product</a>
              </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <form action="homepage.php" method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
                <a href="/proyek-tekweb/keranjang/keranjang.php" class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></a>
                <a href="/proyek-tekweb/wishlist/wishlist.php" class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></a>
            </div>
          </div>
        </div>
    </nav>

    <div id="shop-now">
        <a href="../allProduct/allproduct.php">
            <button id="btn-shop-now">Shop Now</button>
        </a>
    </div>

    <div id="product-popular">
        <h4 id="header-popular">Popular Products</h4>
        <div id="body-popular">
        </div>
    </div>

    <div id="product-categories" class="product">
        <h4 id="header-categories" class="product-header">Product Categories</h4>
        <ul class="list-group list-group-horizontal position-relative overflow-auto w-100" id="categories"></ul>
    </div>

    <div id="contact">
        <h4>Contact Us</h4>
        <div class="btn-contact-container">
            <button class="btn-contact"><img src="asset-homepage/wa-logo.png" alt="wa"></button>
            <button class="btn-contact"><img src="asset-homepage/ig-logo.png" alt="ig"></button>
        </div>
        
    </div>

    <div id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </div>
</body>
</html>