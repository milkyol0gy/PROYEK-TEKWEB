<?php

    include("../database/connect.php");

    class Category
    {
        private $conn;

        public function __construct($connection)
        {
            $this->conn = $connection;
        }

        public function display()
        {
            if(isset($_GET["id"])){
                $id = $_GET["id"];
                try {
                    // Prepare and execute the SQL query
                    $stmt = $this->conn->prepare("SELECT * FROM barang WHERE kategori = '$id'");
                    $stmt->execute();
    
                    // Fetch all rows as an associative array
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                    if (isset($result)) {
                        foreach ($result as $row) : 
                        $foto = base64_encode($row['foto_barang']);
                        echo
                        "<form action='../productDesc/productDesc.php?id=" . $row['id'] . "' method='POST'>
                            <button type='submit' class='btn-products'>
                                <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-products'>
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
    }

// Initialize the connection
$conn = initializeConn();

// Check if the connection is successful before proceeding
if ($conn) {
    // Create an instance of the Product class with the database connection
    $product = new Category($conn);

    // Call the display method
    $product->display();
} else {
    echo "Failed to initialize database connection.";
}
