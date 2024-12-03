<?php 
    session_start();

    if (!isset($_SESSION['uname'])) {
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
    
    <!-- <script src="C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="keranjang.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />
    <script>
        $(document).ready(function() {

            $.ajax({
                url: 'cart.php?function=item',
                type: 'GET',
                success: function(data) {
                    $('#item-box').html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });

            $.ajax({
                url: 'cart.php?function=price',
                type: 'GET',
                success: function(data) {
                    $('#harga-item').html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });

            $.ajax({
                url: 'cart.php?function=total',
                type: 'GET',
                success: function(data) {
                    $('#total-harga').html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });
        });
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-sm fixed-top" id="navbar" style="background-color: whitesmoke;">
        <div class="container-fluid">
          <a class="navbar-brand" href="../homepage/homepage.php"><img src="../homepage/asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="../allProduct/allproduct.php" id="allproduct">All Product</a>
              </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <form action="keranjang.php" method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
                <a href="/proyek-tekweb/keranjang/keranjang.php" class="btn"><img src="/proyek-tekweb/keranjang/keranjang-onclick.svg" alt="keranjang"></a>
                <a href="/proyek-tekweb/wishlist/wishlist.php" class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></a>
            </div>
          </div>
        </div>
    </nav>

    <div id="judul">
        <h4>Keranjang</h4>
    </div>

    <!--container keseluruhan -->
    <div class="keranjang-container"> 
        <!-- container dari item yg ada di keranjang -->
        <div class="box-of-items" id="item-box"></div>
        <div class="box-total-belanja">
            <div class="border-container">
                <h6 class="judul-total">Ringkasan Belanja</h6>
                <div id="harga-item" class="row"></div><hr> 
                <div class="row" id="total-harga"></div>
                <a href="../pembayaran/pembayaran.php">
                    <button class="bayar">Bayar</button>
                </a>
            </div>
        </div>

    </div>

    <div id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </div>       
</body>
</html>