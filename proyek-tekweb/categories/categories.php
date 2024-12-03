<?php
include("../database/connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLI n GO</title>
    <script src="C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="categories.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchBar').keyup(function(event) {
                var input = $(this).val();
                event.preventDefault(); // Prevent the default form submission
                if (input != '') {
                    $.ajax({
                        url: '/proyek-tekweb/search.php',
                        type: 'POST',
                        data: { searchBar: input },
                        success: function(data) {
                            $('#products-container').html(data);
                        },
                        error: function() {
                            console.log('Error fetching products.');
                        }
                    });
                }
            });

            var id = <?php echo $_GET['id']; ?>;
            $.ajax({
                url: 'category.php?id=' + id,
                type: 'GET',
                success: function(data) {
                    $('#products-container').html(data);
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
            <form class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <button class="btn btn-warning">Log Out</button>
                <button class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></button>
                <button class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></button>
                <button class="btn"><img src="" alt=""></button>
            </form>
          </div> 
        </div>
    </nav>

    <div id="search">
        <form id="searchForm" action="./search.php" method="POST">
            <div class="input-group rounded">
                <span class="input-group-text border-0" id="search-addon">
                    <img src="../allProduct/asset-allproduct/search.png" alt="search" style="height: 30px;">
                </span>
                <input type="text" class="form-control" style="text-align: center;" placeholder="Search Item" name="searchBar" id="searchBar">
            </div>
        </form>
    </div>

    <div id="products-container"></div>
    <div id="contact">
        <h4>Contact Us</h4>
        <div class="btn-contact-container">
            <button class="btn-contact"><img src="../homepage/asset-homepage/wa-logo.png" alt="wa"></button>
            <button class="btn-contact"><img src="../homepage/asset-homepage/ig-logo.png" alt="ig"></button>
        </div>
        
    </div>

    <div id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </div>
</body>
</html>