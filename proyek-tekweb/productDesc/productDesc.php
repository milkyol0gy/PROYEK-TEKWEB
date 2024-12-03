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
    <!-- <script src="C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="productDesc.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
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
        }

        $query2 = "SELECT id_barang FROM wishlist WHERE id_barang=".$_GET['id'];
        $result2 = mysqli_query($conn, $query2);
        if ($result2) {
            $check = mysqli_num_rows($result2);
        }
    ?>
    $(document).ready(function() {
        var id = <?php echo isset($_GET['id']) ? $_GET['id'] : 0; ?>;
        var uname = '<?php echo $username; ?>';
        var check = <?php echo $check; ?>

        $.ajax({
            url: 'desc.php?function=display&id=' + id,
            type: 'GET',
            success: function(data) {
                $('#product-desc').html(data);

                if (check > 0) {
                    $('#wishlist-btn-off').show();
                    $('#wishlist-btn').hide();
                }
                else {
                    $('#wishlist-btn').show();
                    $('#wishlist-btn-off').hide();
                }

                // Setelah konten dimasukkan, tambahkan event listener menggunakan jQuery
                $("#wishlist-btn").on('click', function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: 'desc.php?function=wishlist&id=' + id + '&uname=' + uname,
                        type: 'GET',
                        success: function(data) {
                            $('#wishlist-btn-off').show();
                            $('#wishlist-btn').hide();
                        },
                        error: function() {
                            console.log('Error fetching wishlist data.');
                        }
                    });
                });

                
                $("#wishlist-btn-off").on('click', function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: 'desc.php?function=delete&id=' + id + '&uname=' + uname,
                        type: 'GET',
                        success: function(data) {
                            $('#wishlist-btn').show();
                            $('#wishlist-btn-off').hide();
                        },
                        error: function() {
                            console.log('Error fetching wishlist data.');
                        }
                    });
                });
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
                <form action="productDesc.php" method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
                <a href="../keranjang/keranjang.php" class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></a>
                <a href="../wishlist/wishlist.php" class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></a>
            </form>
          </div>
        </div>
    </nav>

    <div id="product-desc"></div>

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
