<?php
    include("../database/connect.php");

    class Home{
        private $conn;

        public function __construct($connection)
        {
            $this->conn = $connection;
        }

        public function displayCategory()
        {
            try {
                // Prepare and execute the SQL query
                $stmt = $this->conn->prepare("SELECT * FROM kategori_barang");
                $stmt->execute();

                // Fetch all rows as an associative array
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (isset($result)) {
                    foreach ($result as $row) : 
                        $foto = base64_encode($row['icon']);
                        echo 
                        "<li class='list-group-item'>
                            <form action='../categories/categories.php?id=" . $row['id'] . "' method='POST'>
                                <button type='submit' class='btn-categories'>
                                    <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_kategori'] . "' class='img-categories'>
                                    <p class='name-category'>" . $row['nama_kategori'] . "</p>
                                </button> 
                            </form>            
                        </li>";
                
                    endforeach;
                }

            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
            }
        }

        public function displayFavourite()
        {
            try {
                // get top 8 products
                $stmt = $this->conn->prepare("SELECT id_barang, COUNT(id_barang) as sales_count FROM log_penjualan WHERE ABS(YEAR(time) - YEAR(CURDATE())) = 0 AND ABS(MONTH(time) - MONTH(CURDATE())) <= 1 GROUP BY id_barang ORDER BY sales_count DESC");
                $stmt->execute();

                $productId = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); // Extract product ID from fetchAll

                // get data of top 8 products
                if (!empty($productId)) {
                    $query = $this->conn->prepare("SELECT * FROM barang WHERE id IN (" . implode(',', $productId) . ")");
                    $query->execute();
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                }

                if (isset($result)) {
                    foreach ($result as $row) : 
                        $foto = base64_encode($row['foto_barang']);
                        echo 
                        "<form action='../productDesc/productDesc.php?id=" . $row['id'] . "' method='POST'>
                            <button type='submit' class='btn-popular'>
                                <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-popular'>
                                <p class='categories'>Minuman</p>
                                <p class='name-product'>" . $row['nama_barang'] . "</p>
                            <p class='price'>Rp. " . $row['harga'] . "</p>
                            </button>
                        </form>";
                    endforeach;
                }

            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
            }
        }

    }

$conn = initializeConn();

if ($conn) {
    $home = new Home($conn);

    if (isset($_GET['function']) && $_GET['function'] == 'categories') {
        $home->displayCategory();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'favourites') {
        $home->displayFavourite();
    } else {
        echo "Invalid function parameter.";
    }
} else {
    echo "Failed to initialize database connection.";
}

