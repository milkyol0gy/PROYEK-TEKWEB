<?php 
    session_start();
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: /proyek-tekweb/sign-in.php");
        exit();
    }
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
    <link rel="stylesheet" href="wishlist.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php 
        $conn = mysqli_connect('localhost', 'root', '', 'blingo');
        $query = "SELECT username FROM user";
    
        //get result
        $result = mysqli_query($conn, $query);
        $username = null;
        if ($result) {
            
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['username'] == $_SESSION['uname']) {
                    $username = $row['username'];
                    break;
                }
            }
        };
    ?>
    <script>
        $(document).ready(function() {
            var uname = '<?php echo $username; ?>';
            
            $.ajax({
                url: 'wish.php?function=display&uname=' + uname,
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
          <a class="navbar-brand" href="/proyek-tekweb/homepage/homepage.php"><img src="../homepage/asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="/proyek-tekweb/allProduct/allproduct.php" id="allproduct">All Product</a>
              </li>
            </ul>
            <form class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <form action="wishlist.php" method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
                <a href="/proyek-tekweb/keranjang/keranjang.php" class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></a>
                <a href="#" class="btn"><img src="../wishlist/asset-wishlist/wishlist-click.svg" alt="wishlist"></a>
            </form>
          </div>
        </div>
    </nav>

    <div id="judul">
        <h4>Semua Wishlist</h4>
    </div>

    <div id="products-container">
        <!-- <div id="item-1" class="btn-products">
            <img src="../homepage/asset-homepage/fruits.png" alt="Apel fuji" class="img-products">
            <p class="name-product">Apel Fuji</p>
            <p class="price">Rp.25.000,-/KG</p>
        </div>
        <div id="item-2" class="btn-products">
            <img src="../homepage/asset-homepage/fruits.png" alt="Apel fuji" class="img-products">
            <p class="name-product">Apel Fuji</p>
            <p class="price">Rp.25.000,-/KG</p>
        </div>
        <div id="item-3" class="btn-products">
            <img src="../homepage/asset-homepage/fruits.png" alt="Apel fuji" class="img-products">
            <p class="name-product">Apel Fuji</p>
            <p class="price">Rp.25.000,-/KG</p>
        </div>
        <div id="item-4" class="btn-products">
            <img src="../homepage/asset-homepage/fruits.png" alt="Apel fuji" class="img-products">
            <p class="name-product">Apel Fuji</p>
            <p class="price">Rp.25.000,-/KG</p>
        </div>
        <div id="item-5" class="btn-products">
            <img src="../homepage/asset-homepage/fruits.png" alt="Apel fuji" class="img-products">
            <p class="name-product">Apel Fuji</p>
            <p class="price">Rp.25.000,-/KG</p>
        </div> -->
    </div>

    <div id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </div>
</body>
</html>