<?php 
include("../database/connect.php");

if(isset($_POST['search'])){
    $conn = initializeConn();
    $search = $_POST['search'];

    try {
        // Prepare and execute the SQL query
        $query = "SELECT * FROM barang WHERE nama_barang LIKE :search";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Fetch all rows as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>BLI n GO</title>
            <script src='C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js'></script>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js'></script>
            <link rel='stylesheet' href='categories.css'>
            <link
              rel='stylesheet'
              href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap'
            />
        
            <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
        
        </head>
        <body>
        <nav class='navbar navbar-expand-sm fixed-top' id='navbar' style='background-color: whitesmoke;'>
                <div class='container-fluid'>
                  <a class='navbar-brand' href='../homepage/homepage.php'><img src='../homepage/asset-homepage/logo bli n go 2 1.png' alt='logo' style='height: 1cm;'></a>
                  <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#mynavbar'>
                    <span class='navbar-toggler-icon'></span>
                  </button>
                  <div class='collapse navbar-collapse' id='mynavbar'>
                    <ul class='navbar-nav me-auto'>
                      <li class='nav-item'>
                        <a class='nav-link' href='../allProduct/allproduct.php' id='allproduct'>All Product</a>
                      </li>
                    </ul>
                    <form class='d-flex'>
                        <ul class='navbar-nav me-auto'>
                            <li class='nav-item'>
                                <a class='nav-link' href='#contact'>Contact Us</a>
                            </li>
                        </ul>
                        <form action='categories.php' method='post'>
                            <button type='submit' class='btn btn-warning' name='logout'>Log Out</button>
                        </form>
                        <a href='/proyek-tekweb/keranjang/keranjang.php' class='btn'><img src='../homepage/asset-homepage/cart-shopping.svg' alt='keranjang'></a>
                        <a href='/proyek-tekweb/wishlist/wishlist.php' class='btn'><img src='../homepage/asset-homepage/wishlist.svg' alt='wishlist'></a>
                    </form>
                  </div>
                </div>
            </nav>
        
            <div id='search'>
                <form action='./search.php' method='POST'>
                    <div class='input-group rounded'>
                        <span class='input-group-text border-0' id='search-addon'>
                            <img src='../allProduct/asset-allproduct/search.png' alt='search' style='height: 30px;'>
                        </span>
                        <input type='search' class='form-control rounded' name='searchBar' id='searchBar' placeholder='Search Here'/>
                        <input type='submit' name='submit'>
                    </div>
                </form>
            </div>
        
            <div id='products-container'>";

            foreach ($result as $row) { 
                $foto = base64_encode($row['foto_barang']);
                echo
                "<form action='./productDesc/productDesc.php?id=" . $row['id'] . "' method='POST'>
                    <button type='submit' class='btn-products'>
                        <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-products'>
                        <p class='name-product'>" . $row['nama_barang'] . "</p>
                        <p class='price'>Rp. " . $row['harga'] . "</p>
                    </button>
                </form>";
            }
            echo "/div>
            <div id='contact'>
            <h4>Contact Us</h4>
            <div class='btn-contact-container'>
                <button class='btn-contact'><img src='../homepage/asset-homepage/wa-logo.png' alt='wa'></button>
                <button class='btn-contact'><img src='../homepage/asset-homepage/ig-logo.png' alt='ig'></button>
            </div> 
            </div>
            <div id='footer'>
            <h6 id='footer-text'>Copyright © 2023</h6>
            </div>
            </body>
            </html>";
        } else {
            echo "No matching results found.";
        }

    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }
}
?>