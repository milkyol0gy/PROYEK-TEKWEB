<?php
    session_start();
    $userId = $_SESSION['user_id']['id'];
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']['id'];
    }
     else {
        header("Location: ../sign-in.php");
    }
    
    include("../database/connect.php");

    class Product
    {
        private $conn;

        public function __construct($connection)
        {
            $this->conn = $connection;
        }

        public function display()
        {
            try {
                // Prepare and execute the SQL query
                $stmt = $this->conn->prepare("SELECT * FROM barang");
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

// Initialize the connection
$conn = initializeConn();

// Check if the connection is successful before proceeding
if ($conn) {
    // Create an instance of the Product class with the database connection
    $product = new Product($conn);

    // Call the display method
    $product->display();
} else {
    echo "Failed to initialize database connection.";
}
